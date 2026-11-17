<?php

namespace App\Models;

use App\Models\Concerns\FlushesContentCache;
use App\Support\Media;
use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use FlushesContentCache, HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function imageUrl(): ?string
    {
        return Media::url($this->image);
    }
}
