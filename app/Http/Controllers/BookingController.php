<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function create($tourSlug)
    {
        $tour = Tour::where('slug', $tourSlug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('bookings.create', compact('tour'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'number_of_people' => 'required|integer|min:1',
            'booking_date' => 'required|date|after:today',
            'special_requirements' => 'nullable|string',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);
        
        if ($validated['number_of_people'] > $tour->max_people) {
            return back()->withErrors(['number_of_people' => "Maximum {$tour->max_people} participants allowed for this tour."])->withInput();
        }

        $validated['price_per_person'] = $tour->price;
        $validated['total_amount'] = $tour->price * $validated['number_of_people'];
        $validated['deposit_amount'] = 0;
        $validated['status'] = 'pending';
        $validated['payment_status'] = 'unpaid';
        $validated['booking_reference'] = $this->generateBookingReference();
        
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }

        $booking = Booking::create($validated);

        if (Auth::check()) {
            return redirect()->route('bookings.checkout', $booking->id)
                ->with('success', 'Booking created! Please complete payment.');
        }

        return redirect()->route('bookings.checkout', $booking->id);
    }

    public function checkout($id)
    {
        $booking = Booking::with('tour')->findOrFail($id);
        
        if (Auth::check() && $booking->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.show', $booking->id);
        }

        return view('bookings.checkout', compact('booking'));
    }

    public function processPayment(Request $request, $id)
    {
        $booking = Booking::with('tour')->findOrFail($id);

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer,cash',
            'payment_type' => 'required|in:full,deposit',
        ]);

        $validationErrors = $this->transactionService->validatePaymentData($validated);
        if (!empty($validationErrors)) {
            return back()->withErrors(['payment' => implode(', ', $validationErrors)])->withInput();
        }

        $result = $this->transactionService->processPayment($booking, $validated);

        if ($result['success']) {
            return redirect()->route('bookings.show', $booking->id)
                ->with('success', $result['message']);
        } else {
            return back()
                ->withErrors(['payment' => $result['message']])
                ->withInput();
        }
    }

    public function show($id)
    {
        $booking = Booking::with(['tour', 'transactions'])->findOrFail($id);
        
        if (Auth::check() && $booking->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        $transactionHistory = $this->transactionService->getTransactionHistory($booking);
        
        return view('bookings.show', compact('booking', 'transactionHistory'));
    }

    public function transactionHistory($id)
    {
        $booking = Booking::with(['tour', 'transactions'])->findOrFail($id);
        
        if (Auth::check() && $booking->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access to booking transactions.');
        }
        
        $transactionHistory = $this->transactionService->getTransactionHistory($booking);
        
        return view('bookings.transactions', compact('booking', 'transactionHistory'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access to cancel booking.');
        }
        
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->withErrors(['error' => 'This booking cannot be cancelled.']);
        }
        
        $booking->status = 'cancelled';
        $booking->save();
        
        return redirect()->route('dashboard')
            ->with('success', 'Booking cancelled successfully.');
    }

    private function generateBookingReference()
    {
        do {
            $reference = 'BK' . date('Ymd') . strtoupper(Str::random(6));
        } while (Booking::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
