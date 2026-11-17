<?php

namespace App\Http\Requests;

use App\Support\Clean;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
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
            'message' => Clean::text($this->input('message'), multiline: true),
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:60', "regex:/^[\p{L}\p{M}\s.'’-]+\$/u", 'regex:/\p{L}{2}/u'],
            'phone' => ['required', 'string', 'max:20', function (string $attribute, mixed $value, \Closure $fail): void {
                $digits = strlen(preg_replace('/\D/', '', (string) $value));
                if ($digits < 10 || $digits > 15) {
                    $fail('Enter a valid phone number (10 to 15 digits).');
                }
            }],
            'message' => ['required', 'string', 'min:10', 'max:500'],
            'website' => ['nullable', 'string', 'max:0'],
            'elapsed' => ['nullable', 'integer'],
        ];
    }
}
