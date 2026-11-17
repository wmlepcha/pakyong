<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_valid_message_is_stored(): void
    {
        $this->postJson(route('contact-messages.store'), ['name' => 'Tenzing Bhutia', 'phone' => '9812345678', 'message' => 'I would like a trip to Lachung in December.', 'elapsed' => 6000])->assertCreated();

        $this->assertDatabaseHas('contact_messages', ['name' => 'Tenzing Bhutia', 'status' => 'new']);
    }

    public function test_short_or_invalid_messages_are_rejected(): void
    {
        $this->postJson(route('contact-messages.store'), ['name' => 'Tenzing', 'phone' => '9812345678', 'message' => 'Hi'])->assertUnprocessable()->assertJsonValidationErrors('message');
        $this->postJson(route('contact-messages.store'), ['name' => 'T', 'phone' => 'abc', 'message' => 'A long enough message here.'])->assertUnprocessable();
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_html_is_stripped_and_instant_submits_are_ignored(): void
    {
        $this->postJson(route('contact-messages.store'), ['name' => 'Tenzing', 'phone' => '9812345678', 'message' => '<script>alert(1)</script>Please call me tomorrow', 'elapsed' => 5000])->assertCreated();
        $this->assertStringNotContainsString('<script>', (string) ContactMessage::first()->message);

        $this->postJson(route('contact-messages.store'), ['name' => 'Tenzing', 'phone' => '9812345678', 'message' => 'Please call me tomorrow', 'elapsed' => 100])->assertCreated();
        $this->assertDatabaseCount('contact_messages', 1);
    }
}
