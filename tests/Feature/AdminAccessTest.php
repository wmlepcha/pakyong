<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\Enquiries\Pages\EditEnquiry;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Models\ContactMessage;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_the_edit_pages_of_enquiries_and_messages_open(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        $this->actingAs($admin)->get($this->adminUrl('/enquiries/'.Enquiry::factory()->create()->id.'/edit'))->assertOk()->assertSee('Pema Lepcha');
        $this->actingAs($admin)->get($this->adminUrl('/contact-messages/'.ContactMessage::factory()->create()->id.'/edit'))->assertOk()->assertSee('Tenzing Bhutia');
    }

    public function test_adding_a_note_lists_it_below_and_removes_its_status_from_the_picker(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $enquiry = Enquiry::factory()->create(['status' => 'new']);

        $page = Livewire::actingAs($admin)->test(EditEnquiry::class, ['record' => $enquiry->getKey()]);

        $page->fillForm(['status' => 'new', 'new_note' => 'Called, no answer'])->callAction(TestAction::make('addNote')->schemaComponent('noteActions'));
        $this->assertSame([['status' => 'new', 'note' => 'Called, no answer']], $enquiry->fresh()->status_notes);

        $page->assertFormFieldExists('status', fn ($field): bool => array_keys($field->getOptions()) === ['contacted', 'booked', 'closed']);

        $page->fillForm(['status' => 'booked', 'new_note' => 'Sent quote'])->callAction(TestAction::make('addNote')->schemaComponent('noteActions'));
        $this->assertCount(2, $enquiry->fresh()->status_notes);
        $this->assertSame('booked', $enquiry->fresh()->status);
    }

    public function test_a_post_can_be_written_with_blank_line_separated_paragraphs(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        Storage::fake('public');

        Livewire::actingAs($admin)->test(CreatePost::class)
            ->fillForm([
                'title' => 'Five days in North Sikkim', 'intro' => 'Intro', 'category' => 'Planning', 'is_published' => true,
                'image' => UploadedFile::fake()->image('c.jpg', 1200, 800),
                'sections' => [['heading' => 'Day one', 'paragraphs' => "First.\n\nSecond."]],
            ])
            ->call('create')->assertHasNoFormErrors();

        $post = Post::firstWhere('slug', 'five-days-in-north-sikkim');
        $this->assertSame([['heading' => 'Day one', 'paragraphs' => ['First.', 'Second.']]], $post->sections);
        $this->actingAs($admin)->get($this->adminUrl('/posts/'.$post->id.'/edit'))->assertOk()->assertSee('Day one');
    }

    public function test_faqs_are_split_into_tabs_by_category(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $permits = FaqCategory::create(['name' => 'Permits']);
        $planning = FaqCategory::create(['name' => 'Planning']);
        $a = Faq::factory()->create(['faq_category_id' => $permits->id]);
        $b = Faq::factory()->create(['faq_category_id' => $planning->id]);

        Livewire::actingAs($admin)->test(ListFaqs::class)
            ->assertCanSeeTableRecords([$a, $b])
            ->set('activeTab', 'category-'.$permits->id)
            ->assertCanSeeTableRecords([$a])->assertCanNotSeeTableRecords([$b]);
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
