<?php

namespace App\Services;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class BookingLinkService
{

    public function linkBookingsByEmail(User $user): int
    {
        try {

            $count = Booking::where('customer_email', $user->email)
                ->whereNull('user_id')
                ->update(['user_id' => $user->id]);

            if ($count > 0) {
                Log::info("Linked {$count} booking(s) to user {$user->id} ({$user->email})");
            }

            return $count;
        } catch (\Exception $e) {
            Log::error("Error linking bookings for user {$user->id}: " . $e->getMessage());
            return 0;
        }
    }

    public function hasUnlinkedBookings(User $user): bool
    {
        return Booking::where('customer_email', $user->email)
            ->whereNull('user_id')
            ->exists();
    }

    public function getUnlinkedBookingsCount(User $user): int
    {
        return Booking::where('customer_email', $user->email)
            ->whereNull('user_id')
            ->count();
    }
}
