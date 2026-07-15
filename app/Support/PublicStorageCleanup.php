<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class PublicStorageCleanup
{
    public static function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    /**
     * @param  array<int, string|null>  $paths
     */
    public static function deleteMany(array $paths): void
    {
        foreach ($paths as $path) {
            self::delete($path);
        }
    }
}
