<?php

namespace App\Models;

use App\Models\Concerns\FlushesContentCache;
use App\Support\Media;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use FlushesContentCache, HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['sections' => 'array', 'published_at' => 'date', 'updated_on' => 'date', 'is_published' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            $words = str_word_count(strip_tags($post->intro.' '.collect($post->sections ?? [])->map(fn (array $s): string => ($s['heading'] ?? '').' '.collect($s['paragraphs'] ?? [])->implode(' '))->implode(' ')));
            $post->mins = max(1, (int) round($words / 200));
        });
    }

    /**
     * @return array<string, mixed>
     */
    public function toPage(): array
    {
        return [
            'slug' => $this->slug, 'title' => $this->title, 'cat' => $this->category, 'mins' => $this->mins,
            'excerpt' => $this->excerpt, 'intro' => $this->intro, 'img_url' => Media::url($this->image), 'img_alt' => $this->image_alt,
            'date' => $this->published_at?->toDateString(), 'updated' => $this->updated_on?->toDateString(),
            'sections' => collect($this->sections ?? [])->map(fn (array $s): array => [$s['heading'] ?? '', collect($s['paragraphs'] ?? [])->all()])->all(),
            'seo_description' => $this->seo_description,
        ];
    }
}
