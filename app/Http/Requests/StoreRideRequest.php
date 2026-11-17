<?php

namespace App\Http\Requests;

use App\Support\Clean;
use App\Support\RideOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => Clean::text($this->input('name')),
            'phone' => Clean::phone($this->input('phone')),
            'pickup_location' => Clean::text($this->input('pickup_location')),
            'drop_location' => Clean::text($this->input('drop_location')),
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $place = ['required', 'string', 'min:3', 'max:120', "regex:/^[\p{L}\p{M}\p{N}\s.,'’&()\/#-]+\$/u", 'regex:/\p{L}{2}/u'];

        return [
            'pickup_location' => $place,
            'drop_location' => $place,
            'pickup_district' => ['required', Rule::in(RideOptions::DISTRICTS)],
            'pickup_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:'.now()->addYear()->toDateString()],
            'car_type' => ['required', Rule::in(RideOptions::CARS)],
            'name' => ['required', 'string', 'min:2', 'max:60', "regex:/^[\p{L}\p{M}\s.'’-]+\$/u", 'regex:/\p{L}{2}/u'],
            'phone' => ['required', 'string', 'max:20', function (string $attribute, mixed $value, \Closure $fail): void {
                $digits = strlen(preg_replace('/\D/', '', (string) $value));
                if ($digits < 10 || $digits > 15) {
                    $fail('Enter a valid WhatsApp number (10 to 15 digits).');
                }
            }],
            'website' => ['nullable', 'string', 'max:0'],
            'elapsed' => ['nullable', 'integer'],
        ];
    }
}
