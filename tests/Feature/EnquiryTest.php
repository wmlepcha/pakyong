<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        Destination::query()->where('slug', 'east-sikkim')->existsOr(fn () => Destination::factory()->create(['name' => 'East Sikkim', 'slug' => 'east-sikkim']));

        return array_merge([
            'name' => 'Pema Lepcha', 'phone' => '+91 74781 27403', 'destinations' => ['East Sikkim'], 'tier' => 'Standard',
            'traveller' => 'Indian visitor', 'season' => 'Peak season', 'stay' => 'Hotels', 'start_date' => now()->addDays(20)->toDateString(),
            'days' => 5, 'people' => 2, 'budget' => 15000, 'package' => null, 'elapsed' => 8000,
        ], $overrides);
    }

    public function test_a_valid_enquiry_is_stored(): void
    {
        $this->postJson(route('enquiries.store'), $this->payload())->assertCreated();

        $this->assertDatabaseHas('enquiries', ['name' => 'Pema Lepcha', 'tier' => 'Standard', 'status' => 'new', 'days' => 5]);
        $this->assertSame(['East Sikkim'], Enquiry::first()->destinations);
    }

    public function test_unknown_destinations_and_tampered_choices_are_rejected(): void
    {
        $this->postJson(route('enquiries.store'), $this->payload(['destinations' => ['Atlantis']]))->assertUnprocessable()->assertJsonValidationErrors('destinations.0');
        $this->postJson(route('enquiries.store'), $this->payload(['tier' => 'Platinum']))->assertUnprocessable()->assertJsonValidationErrors('tier');
        $this->postJson(route('enquiries.store'), $this->payload(['days' => 99]))->assertUnprocessable()->assertJsonValidationErrors('days');
        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_bad_names_phones_dates_and_budgets_are_rejected(): void
    {
        foreach ([['name' => '12345'], ['phone' => '123'], ['start_date' => now()->subDay()->toDateString()], ['budget' => 50], ['people' => 0]] as $bad) {
            $this->postJson(route('enquiries.store'), $this->payload($bad))->assertUnprocessable();
        }
        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_markup_in_the_name_is_stripped(): void
    {
        $this->postJson(route('enquiries.store'), $this->payload(['name' => 'Pema <b>Lepcha</b>']))->assertCreated();

        $this->assertDatabaseHas('enquiries', ['name' => 'Pema Lepcha']);
    }

    public function test_bots_get_a_fake_success_and_nothing_is_stored(): void
    {
        $this->postJson(route('enquiries.store'), $this->payload(['website' => 'http://spam.example']))->assertUnprocessable();
        $this->postJson(route('enquiries.store'), $this->payload(['elapsed' => 300]))->assertCreated();

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_the_endpoint_is_rate_limited(): void
    {
        $payload = $this->payload();

        foreach (range(1, 8) as $ignored) {
            $this->postJson(route('enquiries.store'), $payload)->assertCreated();
        }

        $this->postJson(route('enquiries.store'), $payload)->assertTooManyRequests();
    }
}
