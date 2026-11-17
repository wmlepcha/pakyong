<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Experience;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_home_page_shows_the_images_and_trips_chosen_in_the_admin(): void
    {
        SiteSetting::current()->update(['hero_image' => 'home/custom-hero.webp', 'hero_alt' => 'A custom hero']);
        Destination::factory()->create(['name' => 'North Sikkim', 'slug' => 'north-sikkim', 'home_tile' => true, 'tile_order' => 1]);
        Package::factory()->create(['title' => 'Winter Special']);
        Experience::factory()->create(['title' => 'Yak safari test']);

        $this->get('/')->assertOk()
            ->assertSee('/storage/home/custom-hero.webp', false)->assertSee('A custom hero')
            ->assertSee('North Sikkim')->assertSee('Winter Special')->assertSee('Yak safari test');
    }

    public function test_no_prices_are_shown_on_cards_or_packages(): void
    {
        Destination::factory()->create(['home_tile' => true, 'tile_order' => 1]);
        Package::factory()->create();

        foreach (['/', '/destinations'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('from ₹', false)->assertDontSee('from <b', false);
        }
    }

    public function test_destinations_are_listed_and_unpublished_ones_are_hidden(): void
    {
        Destination::factory()->create(['name' => 'Kalimpong', 'slug' => 'kalimpong', 'region' => 'Kalimpong']);
        Destination::factory()->create(['name' => 'Secret Valley', 'slug' => 'secret-valley', 'is_published' => false]);

        $this->get('/destinations')->assertOk()->assertSee('Kalimpong')->assertDontSee('Secret Valley');
        $this->get('/destinations/kalimpong')->assertOk()->assertSee('Kalimpong');
        $this->get('/destinations/secret-valley')->assertNotFound();
    }

    public function test_blog_shows_only_published_posts_and_posts_open_by_slug(): void
    {
        Post::factory()->create(['title' => 'Live post title', 'slug' => 'live-post']);
        Post::factory()->create(['title' => 'Draft post title', 'slug' => 'draft-post', 'is_published' => false]);
        Post::factory()->create(['title' => 'Future post title', 'slug' => 'future-post', 'published_at' => now()->addWeek()->toDateString()]);

        $this->get('/blog')->assertOk()->assertSee('Live post title')->assertDontSee('Draft post title')->assertDontSee('Future post title');
        $this->get('/blog/live-post')->assertOk()->assertSee('The Himalio Travels');
        $this->get('/blog/draft-post')->assertNotFound();
    }

    public function test_the_faq_page_and_home_faq_come_from_the_database(): void
    {
        Faq::factory()->create(['question' => 'Is tea included?', 'answer' => 'Yes, every morning.', 'show_on_home' => true]);
        Faq::factory()->create(['question' => 'Hidden question?', 'is_published' => false]);

        $this->get('/faq')->assertOk()->assertSee('Is tea included?')->assertDontSee('Hidden question?');
        $this->get('/')->assertOk()->assertSee('Is tea included?');
    }

    public function test_saving_content_refreshes_the_cached_pages(): void
    {
        $post = Post::factory()->create(['title' => 'Old title', 'slug' => 'same-post']);
        $this->get('/blog')->assertSee('Old title');

        $post->update(['title' => 'Brand new title']);

        $this->get('/blog')->assertSee('Brand new title')->assertDontSee('Old title');
    }

    public function test_the_sitemap_lists_published_content_only(): void
    {
        Destination::factory()->create(['slug' => 'east-sikkim']);
        Destination::factory()->create(['slug' => 'hidden-place', 'is_published' => false]);
        Post::factory()->create(['slug' => 'live-post']);
        Post::factory()->create(['slug' => 'draft-post', 'is_published' => false]);

        $this->get('/sitemap.xml')->assertOk()->assertSee('/destinations/east-sikkim', false)->assertSee('/blog/live-post', false)
            ->assertDontSee('hidden-place')->assertDontSee('draft-post');
    }

    public function test_unknown_urls_show_the_custom_404_page(): void
    {
        $this->get('/no-such-page')->assertNotFound()->assertSee('wandered off the trail')->assertSee('Back to base camp');
    }
}
