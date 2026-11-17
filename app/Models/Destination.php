<?php

namespace App\Models;

use App\Models\Concerns\FlushesContentCache;
use App\Support\Media;
use Database\Factories\DestinationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    /** @use HasFactory<DestinationFactory> */
    use FlushesContentCache, HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'good_for' => 'array', 'about' => 'array', 'calendar' => 'array', 'seasons' => 'array',
            'pack_always' => 'array', 'places' => 'array', 'getting' => 'array', 'itinerary' => 'array',
            'tips' => 'array', 'faqs' => 'array', 'home_tile' => 'boolean', 'is_published' => 'boolean',
        ];
    }

    /**
     * The shape the destination views use (lists instead of keyed rows), with image URLs resolved.
     *
     * @return array<string, mixed>
     */
    public function toPage(): array
    {
        $places = collect($this->places ?? []);
        $photos = $places->map(fn (array $p): ?array => filled($p['image'] ?? null) ? [
            'url' => Media::url($p['image']), 'author' => $p['credit_author'] ?? null, 'license' => $p['credit_license'] ?? null,
            'licenseUrl' => $p['credit_license_url'] ?? null, 'page' => $p['credit_page'] ?? null,
        ] : null)->all();

        return [
            'slug' => $this->slug, 'group' => $this->region, 'region' => $this->region, 'place' => $this->name.', India',
            'name' => $this->name, 'short' => $this->short ?: $this->name,
            'img_url' => Media::url($this->card_image), 'hero_url' => Media::url($this->hero_image ?: $this->card_image),
            'base' => $this->base, 'days' => $this->days, 'high' => $this->high, 'elev' => $this->elev,
            'tagline' => $this->tagline, 'places_line' => $this->places_line,
            'good_for' => $this->good_for ?? [], 'about' => $this->about ?? [], 'calendar' => $this->calendar ?? [],
            'seasons' => collect($this->seasons ?? [])->map(fn (array $s): array => [$s['name'] ?? '', $s['months'] ?? '', $s['temp'] ?? '', $s['mood'] ?? '', $s['text'] ?? '', $s['wear'] ?? []])->all(),
            'pack_always' => $this->pack_always ?? [],
            'places' => $places->map(fn (array $p): array => [$p['name'] ?? '', $p['type'] ?? '', $p['description'] ?? '', $p['meta'] ?? ''])->all(),
            'place_photos' => $photos,
            'getting' => collect($this->getting ?? [])->map(fn (array $g): array => [$g['route'] ?? '', $g['detail'] ?? '', $g['time'] ?? ''])->all(),
            'permits' => $this->permits, 'stay' => $this->stay, 'itinerary' => $this->itinerary ?? [], 'tips' => $this->tips ?? [],
            'faqs' => collect($this->faqs ?? [])->map(fn (array $f): array => [$f['q'] ?? '', $f['a'] ?? ''])->all(),
            'seo_title' => $this->seo_title, 'seo_description' => $this->seo_description,
        ];
    }
}
