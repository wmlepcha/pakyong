<?php

namespace App\Models\Concerns;

use App\Support\ContentRepository;

/**
 * Saving or deleting a content record makes the public site rebuild its cached data.
 */
trait FlushesContentCache
{
    protected static function bootFlushesContentCache(): void
    {
        static::saved(fn () => ContentRepository::flush());
        static::deleted(fn () => ContentRepository::flush());
    }
}
