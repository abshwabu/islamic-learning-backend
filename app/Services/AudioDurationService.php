<?php

namespace App\Services;

use getID3;
use Illuminate\Support\Facades\Storage;

class AudioDurationService
{
    public function getDurationSeconds(string $pathOnPublicDisk): ?int
    {
        $fullPath = Storage::disk('public')->path($pathOnPublicDisk);

        if (! is_file($fullPath)) {
            return null;
        }

        $info = (new getID3)->analyze($fullPath);

        if (! isset($info['playtime_seconds'])) {
            return null;
        }

        return (int) round($info['playtime_seconds']);
    }
}
