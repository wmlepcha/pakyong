<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('himalio:admin {email : Email used to sign in} {--name=Owner : Display name} {--password= : Password (asked securely when omitted)}')]
#[Description('Create the admin user, or reset the password of an existing one')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = strtolower((string) $this->argument('email'));
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
