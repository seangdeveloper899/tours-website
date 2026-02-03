<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class TransactionService
{

    public function processPayment(Booking $booking, array $data): array
    {
        DB::beginTransaction();

        try {

            $amount = $data['payment_type'] === 'full'
                ? ($booking->total_price ?? $booking->total_amount)
                : ($booking->total_price ?? $booking->total_amount) * 0.3;

            $transactionId = $this->generateTransactionId();

            $transaction = Transaction::create([
                'booking_id' => $booking->id,
                'transaction_id' => $transactionId,
                'transaction_type' => 'payment',
                'payment_method' => $data['payment_method'],
                'amount' => $amount,
                'status' => 'processing',
                'description' => $data['payment_type'] === 'full'
                    ? 'Full payment for booking'
                    : 'Deposit payment for booking (30%)',
                'metadata' => [
                    'payment_type' => $data['payment_type'],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ],
            ]);

            $paymentResult = $this->processPaymentGateway($transaction, $data);

            if ($paymentResult['success']) {

                $transaction->markAsCompleted();

                $totalPaid = $booking->transactions()
                    ->where('status', 'completed')
                    ->where('transaction_type', 'payment')
                    ->sum('amount');

                $paymentStatus = 'unpaid';
                $bookingTotal = $booking->total_price ?? $booking->total_amount;
                if ($totalPaid >= $bookingTotal) {
                    $paymentStatus = 'paid';
                } elseif ($totalPaid > 0) {
                    $paymentStatus = 'partial';
                }

                $booking->update([
                    'payment_method' => $data['payment_method'],
                    'transaction_id' => $transactionId,
                    'payment_date' => now(),
                    'payment_status' => $paymentStatus,
                    'deposit_amount' => $data['payment_type'] === 'deposit' ? $amount : 0,
                    'status' => 'confirmed',
                ]);

                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'transaction' => $transaction,
                    'booking' => $booking->fresh(),
                    'amount_paid' => $amount,
                    'remaining_balance' => max(0, $bookingTotal - $totalPaid),
                ];
            } else {

                $transaction->markAsFailed($paymentResult['error'] ?? 'Payment processing failed');

                DB::commit();

                return [
                    'success' => false,
                    'message' => $paymentResult['error'] ?? 'Payment processing failed',
                    'transaction' => $transaction,
                ];
            }
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Transaction failed: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }

    public function processRefund(Booking $booking, float $amount, ?string $reason = null): array
    {
        DB::beginTransaction();

        try {

            $totalPaid = $booking->total_paid;
            if ($amount > $totalPaid) {
                throw new Exception('Refund amount cannot exceed total paid amount');
            }

            $transactionId = $this->generateTransactionId();

            $transaction = Transaction::create([
                'booking_id' => $booking->id,
                'transaction_id' => $transactionId,
                'transaction_type' => 'refund',
                'payment_method' => $booking->payment_method,
                'amount' => -$amount,
                'status' => 'processing',
                'description' => $reason ?? 'Refund for booking cancellation',
                'metadata' => [
                    'refund_reason' => $reason,
                    'processed_by' => Auth::check() ? Auth::user()->name : 'System',
                ],
            ]);

            $refundResult = $this->processRefundGateway($transaction);

            if ($refundResult['success']) {
                $transaction->update([
                    'status' => 'refunded',
                    'processed_at' => now(),
                ]);

                $remainingPaid = $totalPaid - $amount;
                $bookingTotal = $booking->total_price ?? $booking->total_amount;
                $paymentStatus = 'unpaid';
                if ($remainingPaid >= $bookingTotal) {
                    $paymentStatus = 'paid';
                } elseif ($remainingPaid > 0) {
                    $paymentStatus = 'partial';
                }

                $booking->update([
                    'payment_status' => $paymentStatus,
                ]);

                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Refund processed successfully',
                    'transaction' => $transaction,
                    'refund_amount' => $amount,
                ];
            } else {
                $transaction->markAsFailed($refundResult['error'] ?? 'Refund processing failed');

                DB::commit();

                return [
                    'success' => false,
                    'message' => $refundResult['error'] ?? 'Refund processing failed',
                ];
            }
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage(),
            ];
        }
    }

    public function getTransactionHistory(Booking $booking): array
    {
        $transactions = $booking->transactions()
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'transactions' => $transactions,
            'total_paid' => $booking->total_paid,
            'remaining_balance' => $booking->remaining_balance,
            'booking_total' => $booking->total_price ?? $booking->total_amount,
        ];
    }

    private function processPaymentGateway(Transaction $transaction, array $data): array
    {

        $success = rand(1, 100) <= 95;

        if ($success) {
            return [
                'success' => true,
                'gateway_transaction_id' => 'GTW_' . strtoupper(Str::random(16)),
                'processed_at' => now(),
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Payment declined by payment gateway',
                'error_code' => 'DECLINED_' . rand(1000, 9999),
            ];
        }
    }

    private function processRefundGateway(Transaction $transaction): array
    {

        return [
            'success' => true,
            'gateway_transaction_id' => 'RFD_' . strtoupper(Str::random(16)),
            'processed_at' => now(),
        ];
    }

    private function generateTransactionId(): string
    {
        do {
            $transactionId = 'TXN' . date('YmdHis') . strtoupper(Str::random(8));
        } while (Transaction::where('transaction_id', $transactionId)->exists());

        return $transactionId;
    }

    public function validatePaymentData(array $data): array
    {
        $errors = [];

        if (!isset($data['payment_method']) || !in_array($data['payment_method'], ['credit_card', 'paypal', 'bank_transfer', 'cash'])) {
            $errors[] = 'Invalid payment method';
        }

        if (!isset($data['payment_type']) || !in_array($data['payment_type'], ['full', 'deposit'])) {
            $errors[] = 'Invalid payment type';
        }

        return $errors;
    }
}
