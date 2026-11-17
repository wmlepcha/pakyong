<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

/**
 * Admin login with a lockout: five failed attempts (password or 2FA code) for the
 * same email and IP block further tries for 15 minutes, on top of Filament's own limit.
 */
class Login extends BaseLogin
{
    private const MAX_ATTEMPTS = 5;

    private const LOCK_SECONDS = 900;

    public function authenticate(): ?LoginResponse
    {
        $key = 'admin-login:'.sha1(strtolower((string) ($this->data['email'] ?? '')).'|'.request()->ip());

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            throw ValidationException::withMessages([
                'data.email' => 'Too many sign-in attempts. Please try again in '.ceil(RateLimiter::availableIn($key) / 60).' minutes.',
            ]);
        }

        try {
            $response = parent::authenticate();
        } catch (ValidationException $exception) {
            RateLimiter::hit($key, self::LOCK_SECONDS);

            throw $exception;
        }

        if ($response !== null) {
            RateLimiter::clear($key);
        }

        return $response;
    }
}
