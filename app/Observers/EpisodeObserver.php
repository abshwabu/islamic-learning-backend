<?php

namespace App\Observers;

use App\Models\Ders;
use App\Models\Episode;
use App\Services\EpisodeEndPageCalculator;

class EpisodeObserver
{
    public function __construct(
        private readonly EpisodeEndPageCalculator $calculator,
    ) {}

    public function saved(Episode $episode): void
    {
        $this->calculator->recalculateForDersId($episode->ders_id);
    }

    public function deleted(Episode $episode): void
    {
        $this->calculator->recalculateForDersId($episode->ders_id);
    }
}
