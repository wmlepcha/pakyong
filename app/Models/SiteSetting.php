<?php

namespace App\Models;

use App\Models\Concerns\FlushesContentCache;
use App\Support\Media;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use FlushesContentCache;

    protected $guarded = [];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function heroUrl(): ?string
    {
        return Media::url($this->hero_image);
    }

    public function placeUrl(): ?string
    {
        return Media::url($this->place_image);
    }
}
