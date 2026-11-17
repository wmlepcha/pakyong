<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Enquiry;
use App\Models\User;
use App\Support\Whatsapp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappTest extends TestCase
{
    use RefreshDatabase;

    public function test_numbers_are_normalised_for_whatsapp_links(): void
    {
        $this->assertSame('917478127403', Whatsapp::number('7478127403'));
        $this->assertSame('917478127403', Whatsapp::number('+91 74781 27403'));
        $this->assertSame('917478127403', Whatsapp::number('07478127403'));
        $this->assertSame('14155550123', Whatsapp::number('+1 (415) 555-0123'));
        $this->assertStringContainsString('text=Hello%20there', Whatsapp::link('7478127403', 'Hello there'));
    }

    public function test_the_log_endpoint_needs_an_admin_and_marks_the_record_contacted(): void
    {
        $enquiry = Enquiry::factory()->create();
        $url = route('filament.admin.whatsapp-log');

        $this->postJson($url, ['type' => 'enquiry', 'id' => $enquiry->id, 'body' => 'Hello'])->assertUnauthorized();

        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $this->actingAs($admin)->postJson($url, ['type' => 'enquiry', 'id' => $enquiry->id, 'body' => 'Hello Pema'])->assertOk();

        $this->assertSame('contacted', $enquiry->fresh()->status);
        $this->assertDatabaseHas('whatsapp_messages', ['body' => 'Hello Pema', 'user_id' => $admin->id]);
    }

    public function test_contact_messages_can_be_logged_too(): void
    {
        $message = ContactMessage::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        $this->actingAs($admin)->postJson(route('filament.admin.whatsapp-log'), ['type' => 'contact', 'id' => $message->id, 'body' => 'Thanks'])->assertOk();

        $this->assertSame('contacted', $message->fresh()->status);
    }
}
