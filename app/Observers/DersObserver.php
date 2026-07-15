<?php

namespace App\Observers;

use App\Models\Ders;
use App\Services\EpisodeEndPageCalculator;

class DersObserver
{
    public function __construct(
        private readonly EpisodeEndPageCalculator $calculator,
    ) {}

    public function updated(Ders $ders): void
    {
        if ($ders->wasChanged('pdf_page_count')) {
            $this->calculator->recalculateForDers($ders);
        }
    }
}
