<?php

namespace Tests\Feature;

use App\Filament\Widgets\LatestRideRequests;
use App\Models\RideRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RideRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'pickup_location' => 'Bagdogra Airport', 'drop_location' => 'MG Marg, Gangtok', 'pickup_district' => 'Siliguri',
            'pickup_date' => now()->addDays(5)->toDateString(), 'car_type' => '7 seater', 'name' => 'Karma Sherpa', 'phone' => '+91 98765 43210', 'elapsed' => 7000,
        ], $overrides);
    }

    public function test_the_page_renders_and_is_in_the_menu(): void
    {
        $this->get('/book-a-ride')->assertOk()->assertSee('Book a ride')->assertSee('Pickup district')->assertSee('7 seater');
        $this->get('/')->assertSee('Book a Ride');
    }

    public function test_a_valid_ride_request_is_stored(): void
    {
        $this->postJson(route('ride-requests.store'), $this->payload())->assertCreated();

        $this->assertDatabaseHas('ride_requests', ['name' => 'Karma Sherpa', 'car_type' => '7 seater', 'pickup_district' => 'Siliguri', 'status' => 'new']);
    }

    public function test_tampered_or_invalid_values_are_rejected(): void
    {
        foreach ([['car_type' => '12 seater'], ['pickup_district' => 'Mars'], ['pickup_date' => now()->subDay()->toDateString()], ['pickup_date' => now()->addYears(2)->toDateString()],
            ['pickup_location' => '12'], ['name' => '9999'], ['phone' => '12']] as $bad) {
            $this->postJson(route('ride-requests.store'), $this->payload($bad))->assertUnprocessable();
        }
        $this->assertDatabaseCount('ride_requests', 0);
    }

    public function test_bots_and_instant_submits_are_not_stored_and_the_endpoint_is_limited(): void
    {
        $this->postJson(route('ride-requests.store'), $this->payload(['elapsed' => 200]))->assertCreated();
        $this->assertDatabaseCount('ride_requests', 0);

        foreach (range(1, 7) as $ignored) {
            $this->postJson(route('ride-requests.store'), $this->payload())->assertCreated();
        }
        $this->postJson(route('ride-requests.store'), $this->payload())->assertTooManyRequests();
    }

    public function test_admins_can_open_the_ride_list_and_log_a_whatsapp_reply(): void
    {
        $ride = RideRequest::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        $this->actingAs($admin)->get('/'.config('app.admin_path').'/ride-requests')->assertOk();
        $this->actingAs($admin)->get('/'.config('app.admin_path').'/ride-requests/'.$ride->id.'/edit')->assertOk()->assertSee('Karma Sherpa');
        $this->actingAs($admin)->get('/'.config('app.admin_path'))->assertOk();
        Livewire::actingAs($admin)->test(LatestRideRequests::class)->assertCanSeeTableRecords([$ride]);
        $this->actingAs($admin)->postJson(route('filament.admin.whatsapp-log'), ['type' => 'ride', 'id' => $ride->id, 'body' => 'Your car is booked.'])->assertOk();

        $this->assertSame('contacted', $ride->fresh()->status);
    }
}
