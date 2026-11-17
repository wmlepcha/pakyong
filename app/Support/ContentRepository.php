<?php

namespace App\Support;

use App\Models\Destination;
use App\Models\Experience;
use App\Models\FaqCategory;
use App\Models\Package;
use App\Models\Post;
use App\Models\SiteSetting;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Reads every piece of editable content for the public site, cached until something is saved in the admin.
 */
class ContentRepository
{
    public static function flush(): void
    {
        Cache::forever('content.version', (int) Cache::get('content.version', 1) + 1);
    }

    /**
     * Caches plain arrays only (Laravel does not unserialize objects from the cache).
     *
     * @return array<mixed>
     */
    private static function remember(string $key, Closure $callback): array
    {
        return Cache::rememberForever('content.v'.Cache::get('content.version', 1).'.'.$key, function () use ($callback): array {
            $value = $callback();

            return $value instanceof Collection ? $value->all() : $value;
        });
    }

    /**
     * @return array{hero_url: string, hero_alt: string, place_url: string, place_alt: string}
     */
    public static function home(): array
    {
        return self::remember('home', function (): array {
            $s = SiteSetting::current();

            return [
                'hero_url' => $s->heroUrl() ?: '/images/all-sikkim.webp',
                'hero_alt' => $s->hero_alt ?: 'Kanchenjunga above a sea of cloud in Sikkim',
                'place_url' => $s->placeUrl() ?: '/images/west.webp',
                'place_alt' => $s->place_alt ?: 'Prayer flags and a stupa on a Himalayan trail',
            ];
        });
    }

    /**
     * Published destinations in order, keyed by slug, in the array shape the views use.
     *
     * @return Collection<string, array<string, mixed>>
     */
    public static function destinations(): Collection
    {
        return collect(self::remember('destinations', fn (): Collection => Destination::query()->where('is_published', true)
            ->orderBy('sort_order')->orderBy('id')->get()->mapWithKeys(fn (Destination $d): array => [$d->slug => $d->toPage()])));
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function destination(string $slug): ?array
    {
        return self::destinations()->get($slug);
    }

    /**
     * The four photo tiles on the home page.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function homeTiles(): Collection
    {
        return collect(self::remember('tiles', fn (): Collection => Destination::query()->where('is_published', true)->where('home_tile', true)
            ->orderBy('tile_order')->limit(4)->get()->map(fn (Destination $d): array => $d->toPage())->values()));
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function packages(): Collection
    {
        return collect(self::remember('packages', fn (): Collection => Package::query()->where('is_published', true)->orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (Package $p): array => ['title' => $p->title, 'duration' => $p->duration, 'img_url' => $p->imageUrl(), 'bullets' => $p->bullets ?? []])));
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public static function experiences(): Collection
    {
        return collect(self::remember('experiences', fn (): Collection => Experience::query()->where('is_published', true)->orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (Experience $e): array => ['title' => $e->title, 'description' => $e->description, 'img_url' => $e->imageUrl()])));
    }

    /**
     * Published posts, newest first.
     *
     * @return Collection<string, array<string, mixed>>
     */
    public static function posts(): Collection
    {
        return collect(self::remember('posts', fn (): Collection => Post::query()->where('is_published', true)->whereDate('published_at', '<=', now())
            ->orderByDesc('published_at')->orderByDesc('id')->get()->mapWithKeys(fn (Post $p): array => [$p->slug => $p->toPage()])));
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function post(string $slug): ?array
    {
        return self::posts()->get($slug);
    }

    /**
     * @return array<int, string>
     */
    public static function postCategories(): array
    {
        return self::posts()->pluck('cat')->unique()->values()->all();
    }

    /**
     * Published questions with their category, in order.
     *
     * @return Collection<int, array{cat: string, home: bool, q: string, a: string, link: array<int, string>|null}>
     */
    public static function faqItems(): Collection
    {
        return collect(self::remember('faqs', fn (): Collection => FaqCategory::query()->orderBy('sort_order')->with(['faqs' => fn ($q) => $q->where('is_published', true)])->get()
            ->flatMap(fn (FaqCategory $c): Collection => $c->faqs->map(fn ($f): array => [
                'cat' => $c->name, 'home' => $f->show_on_home, 'q' => $f->question, 'a' => $f->answer,
                'link' => $f->link_label && $f->link_url ? [$f->link_label, $f->link_url] : null,
            ]))->values()));
    }

    /**
     * @return array<int, string>
     */
    public static function faqCategories(): array
    {
        return self::faqItems()->pluck('cat')->unique()->values()->all();
    }
}
