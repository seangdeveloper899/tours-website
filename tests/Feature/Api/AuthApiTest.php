<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    
    public function it_can_register_a_new_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'user' => [
                             'id',
                             'name',
                             'email',
                             'phone',
                         ],
                         'token',
                     ]
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    
    public function it_validates_registration_data()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
        ]);

        $response->assertStatus(422)
                 ->assertJsonPath('success', false)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    
    public function it_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'user',
                         'token',
                     ]
                 ]);
    }

    
    public function it_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJsonPath('success', false)
                 ->assertJsonPath('message', 'Invalid credentials');
    }

    
    public function it_can_logout_authenticated_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/logout');

        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('message', 'Logout successful');
    }

    
    public function it_can_get_authenticated_user_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/profile');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'phone',
                     ]
                 ])
                 ->assertJsonPath('data.email', $user->email);
    }

    
    public function it_can_update_user_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->putJson('/api/v1/profile', [
            'name' => 'Updated Name',
            'phone' => '9876543210',
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.name', 'Updated Name');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    
    public function it_can_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/change-password', [
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    
    public function it_validates_current_password_when_changing()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/change-password', [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonPath('success', false);
    }

    
    public function it_can_get_user_bookings()
    {
        $user = User::factory()->create();
        $tour = Tour::factory()->create();
        
        Booking::factory()->count(3)->create([
            'user_id' => $user->id,
            'tour_id' => $tour->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/user/bookings');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'statistics',
                         'bookings',
                     ]
                 ]);
    }

    
    public function guest_cannot_access_protected_routes()
    {
        $response = $this->getJson('/api/v1/profile');

        $response->assertStatus(401);
    }
}
