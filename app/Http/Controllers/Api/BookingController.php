<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'number_of_participants' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $tour = Tour::where('id', $request->tour_id)
            ->where('is_active', true)
            ->first();

        if (!$tour) {
            return response()->json([
                'success' => false,
                'message' => 'Tour not found or not available'
            ], 404);
        }

        if ($request->number_of_participants > $tour->max_participants) {
            return response()->json([
                'success' => false,
                'message' => "Maximum {$tour->max_participants} participants allowed for this tour"
            ], 422);
        }

        $totalPrice = $tour->price * $request->number_of_participants;

        $bookingReference = $this->generateBookingReference();

        $bookingData = [
            'tour_id' => $request->tour_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'booking_date' => $request->booking_date,
            'number_of_participants' => $request->number_of_participants,
            'number_of_people' => $request->number_of_participants,
            'total_price' => $totalPrice,
            'total_amount' => $totalPrice,
            'price_per_person' => $tour->price,
            'special_requests' => $request->special_requests,
            'special_requirements' => $request->special_requests,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'booking_reference' => $bookingReference,
        ];

        if ($request->user()) {
            $bookingData['user_id'] = $request->user()->id;
        }

        $booking = Booking::create($bookingData);

        $booking->load('tour');

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $booking = Booking::with(['tour', 'guide', 'transactions'])
            ->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $transactionHistory = $this->transactionService->getTransactionHistory($booking);

        return response()->json([
            'success' => true,
            'data' => [
                'booking' => $booking,
                'transaction_history' => $transactionHistory,
            ]
        ]);
    }

    public function processPayment(Request $request, string $id): JsonResponse
    {
        $booking = Booking::with('tour')->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer,cash',
            'payment_type' => 'required|in:full,deposit',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validationErrors = $this->transactionService->validatePaymentData($request->all());
        if (!empty($validationErrors)) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validationErrors
            ], 422);
        }

        $result = $this->transactionService->processPayment($booking, $request->all());

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => [
                    'booking' => $result['booking'],
                    'transaction' => $result['transaction'],
                    'amount_paid' => $result['amount_paid'],
                    'remaining_balance' => $result['remaining_balance'],
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'transaction' => $result['transaction'] ?? null,
            ], 400);
        }
    }

    public function transactionHistory(string $id): JsonResponse
    {
        $booking = Booking::with(['tour', 'transactions'])->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $transactionHistory = $this->transactionService->getTransactionHistory($booking);

        return response()->json([
            'success' => true,
            'data' => $transactionHistory
        ]);
    }

    private function generateBookingReference()
    {
        do {
            $reference = 'BK' . date('Ymd') . strtoupper(\Illuminate\Support\Str::random(6));
        } while (Booking::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
