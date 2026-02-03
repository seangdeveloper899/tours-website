<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bookings', 'booking_reference')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('booking_reference')->nullable()->unique()->after('booking_number');
            });

            DB::table('bookings')->orderBy('id')->get()->each(function ($booking) {
                DB::table('bookings')
                    ->where('id', $booking->id)
                    ->update(['booking_reference' => 'BK' . str_pad($booking->id, 8, '0', STR_PAD_LEFT)]);
            });
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'booking_reference')) {
                $table->dropColumn('booking_reference');
            }
        });
    }
};
