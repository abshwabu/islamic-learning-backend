<?php

namespace App\Observers;

use App\Models\Episode;
use App\Services\EpisodeEndPageCalculator;
use App\Support\PublicStorageCleanup;

class EpisodeObserver
{
    public function __construct(
        private readonly EpisodeEndPageCalculator $calculator,
    ) {}

    public function saved(Episode $episode): void
    {
        $this->calculator->recalculateForDersId($episode->ders_id);
    }

    public function deleting(Episode $episode): void
    {
        PublicStorageCleanup::delete($episode->audio_file);
    }

    public function deleted(Episode $episode): void
    {
        $this->calculator->recalculateForDersId($episode->ders_id);
    }
}
