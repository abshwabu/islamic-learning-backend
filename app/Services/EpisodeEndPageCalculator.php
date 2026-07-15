<?php

namespace App\Services;

use App\Models\Ders;

class EpisodeEndPageCalculator
{
    public function recalculateForDers(Ders $ders): void
    {
        $episodes = $ders->episodes()->orderBy('sort_order')->get();

        foreach ($episodes as $index => $episode) {
            $nextEpisode = $episodes[$index + 1] ?? null;
            $endPage = $nextEpisode
                ? max($episode->start_page, $nextEpisode->start_page - 1)
                : $ders->pdf_page_count;

            if ($episode->end_page !== $endPage) {
                $episode->updateQuietly(['end_page' => $endPage]);
            }
        }
    }

    public function recalculateForDersId(int $dersId): void
    {
        $ders = Ders::query()->find($dersId);

        if ($ders) {
            $this->recalculateForDers($ders);
        }
    }
}
