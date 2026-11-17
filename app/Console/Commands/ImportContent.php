<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Models\Experience;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Package;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('site:import-content')]
#[Description('Load the original site content (destinations, packages, experiences, blog, FAQ) into the database. Safe to run again.')]
class ImportContent extends Command
{
    /**
     * Copies a file shipped in public/images onto the public disk so it can be replaced from the admin.
     */
    private function asset(?string $name): ?string
    {
        if (blank($name)) {
            return null;
        }

        $from = public_path('images/'.$name);

        if (is_file($from)) {
            Storage::disk('public')->put('site/'.$name, (string) file_get_contents($from));
        }

        return 'site/'.$name;
    }

    public function handle(): int
    {
        $dir = database_path('seeders/content/');
        $settings = SiteSetting::current();
        $settings->update([
            'hero_image' => $settings->hero_image ?: $this->asset('all-sikkim.webp'), 'hero_alt' => $settings->hero_alt ?: 'Kanchenjunga above a sea of cloud in Sikkim',
            'place_image' => $settings->place_image ?: $this->asset('west.webp'), 'place_alt' => $settings->place_alt ?: 'Prayer flags and a stupa on a Himalayan trail',
        ]);

        $this->destinations(require $dir.'destinations.php', require $dir.'photos.php', (require $dir.'home.php')['directions']);
        $this->home(require $dir.'home.php');
        $this->blog(require $dir.'blog.php');
        $this->faq(require $dir.'faq.php');

        $this->components->info('Content imported: '.Destination::count().' destinations, '.Package::count().' packages, '.Experience::count().' experiences, '.Post::count().' posts, '.Faq::count().' questions.');

        return self::SUCCESS;
    }

    /**
     * @param  array<string, array<string, mixed>>  $items
     * @param  array<string, array<int, array<string, string>>>  $photos
     * @param  array<int, array<int, string>>  $directions
     */
    private function destinations(array $items, array $photos, array $directions): void
    {
        $lines = collect($directions)->mapWithKeys(fn (array $d): array => [$d[0] => $d[1]]);
        $tiles = ['North Sikkim' => 1, 'West Sikkim' => 2, 'East Sikkim' => 3, 'South Sikkim' => 4];
        $order = 0;

        foreach ($items as $slug => $d) {
            $places = collect($d['places'])->map(function (array $p, int $i) use ($photos, $slug): array {
                $photo = $photos[$slug][$i] ?? null;

                return ['name' => $p[0], 'type' => $p[1], 'description' => $p[2], 'meta' => $p[3], 'image' => $this->asset($photo['file'] ?? null),
                    'credit_author' => $photo['author'] ?? null, 'credit_license' => $photo['license'] ?? null,
                    'credit_license_url' => $photo['licenseUrl'] ?? null, 'credit_page' => $photo['page'] ?? null];
            })->all();

            Destination::updateOrCreate(['slug' => $slug], [
                'region' => $d['group'] ?? 'Sikkim', 'name' => $d['name'], 'short' => $d['short'] ?? null, 'card_image' => $this->asset($d['img']),
                'home_tile' => isset($tiles[$d['name']]), 'tile_order' => $tiles[$d['name']] ?? 0,
                'base' => $d['base'] ?? null, 'days' => $d['days'] ?? null, 'high' => $d['high'] ?? null, 'elev' => $d['elev'] ?? null,
                'tagline' => $d['tagline'] ?? null, 'places_line' => $lines[$d['name']] ?? null,
                'good_for' => $d['good_for'] ?? [], 'about' => $d['about'] ?? [], 'calendar' => $d['calendar'] ?? [],
                'seasons' => collect($d['seasons'])->map(fn (array $s): array => ['name' => $s[0], 'months' => $s[1], 'temp' => $s[2], 'mood' => $s[3], 'text' => $s[4], 'wear' => $s[5] ?? []])->all(),
                'pack_always' => $d['pack_always'] ?? [], 'places' => $places,
                'getting' => collect($d['getting'])->map(fn (array $g): array => ['route' => $g[0], 'detail' => $g[1], 'time' => $g[2]])->all(),
                'permits' => $d['permits'] ?? null, 'stay' => $d['stay'] ?? null, 'itinerary' => $d['itinerary'] ?? [], 'tips' => $d['tips'] ?? [],
                'faqs' => collect($d['faqs'])->map(fn (array $f): array => ['q' => $f[0], 'a' => $f[1]])->all(),
                'is_published' => true, 'sort_order' => $order++,
            ]);
        }
    }

    /**
     * @param  array<string, array<int, array<int, mixed>>>  $home
     */
    private function home(array $home): void
    {
        foreach ($home['packages'] as $i => $p) {
            Package::updateOrCreate(['title' => $p[0]], ['duration' => $p[1], 'image' => $this->asset($p[2]), 'bullets' => $p[4], 'sort_order' => $i, 'is_published' => true]);
        }

        foreach ($home['experiences'] as $i => $e) {
            Experience::updateOrCreate(['title' => $e[0]], ['description' => $e[1], 'image' => $this->asset($e[2]), 'sort_order' => $i, 'is_published' => true]);
        }
    }

    /**
     * @param  array<string, mixed>  $blog
     */
    private function blog(array $blog): void
    {
        foreach ($blog['posts'] as $p) {
            Post::updateOrCreate(['slug' => $p['slug']], [
                'title' => $p['title'], 'category' => $p['cat'], 'excerpt' => $p['excerpt'], 'intro' => $p['intro'], 'image' => $this->asset($p['img']),
                'sections' => collect($p['sections'])->map(fn (array $s): array => ['heading' => $s[0], 'paragraphs' => $s[1]])->all(),
                'published_at' => $p['date'] ?? $blog['published'], 'is_published' => true,
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $faq
     */
    private function faq(array $faq): void
    {
        $categories = collect($faq['categories'])->mapWithKeys(fn (string $name, int $i): array => [$name => FaqCategory::updateOrCreate(['name' => $name], ['sort_order' => $i])]);

        foreach ($faq['items'] as $i => $item) {
            Faq::updateOrCreate(['question' => $item['q']], [
                'faq_category_id' => $categories[$item['cat']]->id, 'answer' => $item['a'], 'show_on_home' => $item['home'] ?? false,
                'link_label' => $item['link'][0] ?? null, 'link_url' => $item['link'][1] ?? null, 'sort_order' => $i, 'is_published' => true,
            ]);
        }
    }
}
