<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Tour::factory()->count(5)->create([
            'is_active' => true,
        ]);
    }

    
    public function it_can_create_a_booking()
    {
        $tour = Tour::first();
        
        $bookingData = [
            'tour_id' => $tour->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '1234567890',
            'booking_date' => now()->addDays(7)->format('Y-m-d'),
            'number_of_people' => 2,
            'special_requirements' => 'Vegetarian meal',
        ];

        $response = $this->postJson('/api/v1/bookings', $bookingData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'id',
                         'booking_number',
                         'tour_id',
                         'customer_name',
                         'total_amount',
                         'status',
                     ]
                 ]);

        $this->assertDatabaseHas('bookings', [
            'customer_email' => 'john@example.com',
        ]);
    }

    
    public function it_validates_booking_data()
    {
        $response = $this->postJson('/api/v1/bookings', [
            'tour_id' => 999,
            'customer_name' => '',
            'customer_email' => 'invalid-email',
        ]);

        $response->assertStatus(422)
                 ->assertJsonPath('success', false)
                 ->assertJsonValidationErrors(['tour_id', 'customer_name', 'customer_email']);
    }

    
    public function it_can_get_booking_details()
    {
        $booking = Booking::factory()->create();
        
        $response = $this->getJson('/api/v1/bookings/' . $booking->id);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'booking_number',
                         'tour',
                         'customer_name',
                         'status',
                     ]
                 ])
                 ->assertJsonPath('data.id', $booking->id);
    }

    
    public function it_returns_404_for_non_existent_booking()
    {
        $response = $this->getJson('/api/v1/bookings/999');

        $response->assertStatus(404)
                 ->assertJsonPath('success', false);
    }

    
    public function it_can_process_payment_for_booking()
    {
        $booking = Booking::factory()->create([
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $paymentData = [
            'amount' => $booking->total_amount,
            'payment_method' => 'credit_card',
            'transaction_id' => 'TXN' . time(),
        ];

        $response = $this->postJson('/api/v1/bookings/' . $booking->id . '/payment', $paymentData);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        $this->assertDatabaseHas('transactions', [
            'booking_id' => $booking->id,
            'transaction_type' => 'payment',
        ]);
    }

    
    public function it_can_get_transaction_history_for_booking()
    {
        $booking = Booking::factory()->create();
        
        Transaction::factory()->count(3)->create([
            'booking_id' => $booking->id,
        ]);

        $response = $this->getJson('/api/v1/bookings/' . $booking->id . '/transactions');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => [
                             'id',
                             'transaction_id',
                             'amount',
                             'transaction_type',
                             'status',
                         ]
                     ]
                 ]);
    }

    
    public function it_validates_payment_amount()
    {
        $booking = Booking::factory()->create([
            'total_amount' => 100,
        ]);

        $response = $this->postJson('/api/v1/bookings/' . $booking->id . '/payment', [
            'amount' => 50,
            'payment_method' => 'credit_card',
            'transaction_id' => 'TXN123',
        ]);

        $response->assertStatus(422);
    }

    
    public function authenticated_user_can_cancel_their_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'confirmed',
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/user/bookings/' . $booking->id . '/cancel');

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
    }

    
    public function user_cannot_cancel_other_users_booking()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $booking = Booking::factory()->create([
            'user_id' => $user1->id,
        ]);

        Sanctum::actingAs($user2);

        $response = $this->postJson('/api/v1/user/bookings/' . $booking->id . '/cancel');

        $response->assertStatus(404);
    }

    
    public function it_calculates_total_amount_correctly()
    {
        $tour = Tour::factory()->create([
            'price' => 50,
        ]);

        $response = $this->postJson('/api/v1/bookings', [
            'tour_id' => $tour->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '1234567890',
            'booking_date' => now()->addDays(7)->format('Y-m-d'),
            'number_of_people' => 3,
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.total_amount', 150);
    }
}
