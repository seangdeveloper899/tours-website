<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('customer_email');
            $table->index('status');
            $table->index('payment_status');
            $table->index(['user_id', 'status']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['tour_id', 'is_approved']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('booking_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['customer_email']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['tour_id', 'is_approved']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['booking_id']);
            $table->dropIndex(['status']);
        });
    }
};
