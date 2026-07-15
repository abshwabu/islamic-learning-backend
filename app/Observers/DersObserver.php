<?php

namespace App\Observers;

use App\Models\Ders;
use App\Services\EpisodeEndPageCalculator;
use App\Support\PublicStorageCleanup;

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

    public function deleting(Ders $ders): void
    {
        PublicStorageCleanup::deleteMany([
            $ders->cover_image,
            $ders->pdf_file,
        ]);
    }
}
