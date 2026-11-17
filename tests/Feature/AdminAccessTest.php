<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private function adminUrl(string $path = ''): string
    {
        return '/'.config('app.admin_path').$path;
    }

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get($this->adminUrl())->assertRedirect($this->adminUrl('/login'));
        $this->get($this->adminUrl('/destinations'))->assertRedirect($this->adminUrl('/login'));
    }

    public function test_the_default_admin_path_does_not_exist(): void
    {
        $this->get('/admin')->assertNotFound();
    }

    public function test_the_login_page_is_not_indexable_or_cacheable(): void
    {
        $this->get($this->adminUrl('/login'))->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')->assertHeader('X-Frame-Options', 'DENY');
    }

    public function test_users_who_are_not_admins_cannot_open_the_panel(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get($this->adminUrl())->assertForbidden();
    }

    public function test_admins_must_set_up_two_factor_before_using_the_panel(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get($this->adminUrl('/destinations'))->assertRedirectContains('multi-factor-authentication/set-up');
    }

    public function test_admins_with_two_factor_reach_the_panel_pages(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        foreach (['', '/destinations', '/posts', '/faqs', '/packages', '/experiences', '/enquiries', '/contact-messages', '/home-images'] as $path) {
            $this->actingAs($admin)->get($this->adminUrl($path))->assertOk();
        }
    }

    public function test_repeated_failed_logins_lock_the_account_for_a_while(): void
    {
        User::factory()->create(['email' => 'owner@example.com', 'is_admin' => true]);

        foreach (range(1, 5) as $ignored) {
            Livewire::test(Login::class)->fillForm(['email' => 'owner@example.com', 'password' => 'wrong-password'])->call('authenticate')->assertHasErrors();
        }

        Livewire::test(Login::class)->fillForm(['email' => 'owner@example.com', 'password' => 'password'])->call('authenticate')
            ->assertHasErrors(['data.email']);
        $this->assertGuest();
    }
}
