<?php

namespace App\Models;

use App\Models\Concerns\FlushesContentCache;
use App\Support\Media;
use Database\Factories\PackageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /** @use HasFactory<PackageFactory> */
    use FlushesContentCache, HasFactory;

    protected $guarded = [];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['bullets' => 'array', 'is_published' => 'boolean'];
    }

    public function imageUrl(): ?string
    {
        return Media::url($this->image);
    }
}
