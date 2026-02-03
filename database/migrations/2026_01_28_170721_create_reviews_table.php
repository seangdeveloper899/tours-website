<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');

            $table->string('reviewer_name');
            $table->string('reviewer_email')->nullable();
            $table->integer('rating');
            $table->string('title')->nullable();
            $table->text('comment');

            $table->boolean('is_verified')->default(false);

            $table->boolean('is_approved')->default(false);
            $table->text('admin_notes')->nullable();

            $table->integer('helpful_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
