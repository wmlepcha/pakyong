<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('himalio:admin {email : Email used to sign in} {--name=Owner : Display name} {--password= : Password (asked securely when omitted)} {--reset-2fa : Only clear two-factor authentication so it can be set up again}')]
#[Description('Create the admin user, reset its password, or clear its two-factor authentication')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = strtolower((string) $this->argument('email'));

        if ($this->option('reset-2fa')) {
            $user = User::where('email', $email)->first();

            if (! $user) {
                $this->components->error('No user with that email.');

                return self::FAILURE;
            }

            $user->forceFill(['app_authentication_secret' => null, 'app_authentication_recovery_codes' => null])->save();
            $this->components->info('Two-factor authentication cleared. Sign in and set it up again.');

            return self::SUCCESS;
        }

        $password = $this->option('password') ?: $this->secret('Password (at least 12 characters)');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen((string) $password) < 12) {
            $this->components->error('Use a valid email and a password of at least 12 characters.');

            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $existing = $user->exists;
        $user->name = $existing ? $user->name : (string) $this->option('name');
        $user->password = $password;
        $user->is_admin = true;
        $user->save();

        $this->components->info($existing ? 'Password reset.' : 'Admin created.');
        $this->line('Sign in at /'.config('app.admin_path').' and set up two-factor authentication when prompted.');

        return self::SUCCESS;
    }
}
