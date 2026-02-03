<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $bookings = \App\Models\Booking::query()
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('customer_email', $user->email);
            })
            ->with(['tour.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard', compact('bookings'));
    }
}
