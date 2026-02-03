<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    
    public function it_can_submit_contact_form()
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about tours',
            'message' => 'I would like to know more about your tours.',
        ];

        $response = $this->postJson('/api/v1/contact', $contactData);

        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john@example.com',
        ]);
    }

    
    public function it_validates_contact_form_data()
    {
        $response = $this->postJson('/api/v1/contact', [
            'name' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertStatus(422)
                 ->assertJsonPath('success', false)
                 ->assertJsonValidationErrors(['name', 'email', 'message']);
    }

    
    public function it_requires_valid_email_format()
    {
        $response = $this->postJson('/api/v1/contact', [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'subject' => 'Test',
            'message' => 'Test message',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    
    public function it_requires_minimum_message_length()
    {
        $response = $this->postJson('/api/v1/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test',
            'message' => 'Hi',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['message']);
    }
}
