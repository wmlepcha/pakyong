<?php

namespace App\Http\Requests;

use App\Support\Clean;
use App\Support\ContentRepository;
use App\Support\EnquiryOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnquiryRequest extends FormRequest
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
            'package' => filled($this->input('package')) ? Clean::text($this->input('package')) : null,
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $destinations = ContentRepository::destinations()->pluck('name')->push('Not sure yet')->all();

        return [
            'name' => ['required', 'string', 'min:2', 'max:60', "regex:/^[\p{L}\p{M}\s.'’-]+\$/u", 'regex:/\p{L}{2}/u'],
            'phone' => ['required', 'string', 'max:20', function (string $attribute, mixed $value, \Closure $fail): void {
                $digits = strlen(preg_replace('/\D/', '', (string) $value));
                if ($digits < 10 || $digits > 15) {
                    $fail('Enter a valid phone number (10 to 15 digits).');
                }
            }],
            'destinations' => ['required', 'array', 'min:1', 'max:10'],
            'destinations.*' => ['string', Rule::in($destinations)],
            'tier' => ['required', Rule::in(EnquiryOptions::TIERS)],
            'traveller' => ['required', Rule::in(EnquiryOptions::TRAVELLERS)],
            'season' => ['required', Rule::in(EnquiryOptions::SEASONS)],
            'stay' => ['required', Rule::in(EnquiryOptions::STAYS)],
            'start_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:'.now()->addYears(3)->toDateString()],
            'days' => ['required', 'integer', Rule::in(EnquiryOptions::DAYS)],
            'people' => ['required', 'integer', 'between:1,50'],
            'budget' => ['nullable', 'integer', 'between:500,1000000'],
            'package' => ['nullable', 'string', 'max:60'],
            'website' => ['nullable', 'string', 'max:0'],
            'elapsed' => ['nullable', 'integer'],
        ];
    }
}
