<?php

namespace App\Filament\Support;

use App\Services\PdfPageCountService;

class DersForm
{
    public static function normalizeUploadPath(mixed $state): ?string
    {
        if (blank($state)) {
            return null;
        }

        if (is_array($state)) {
            return $state[0] ?? null;
        }

        return (string) $state;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function processPdfPageCount(array $data): array
    {
        $path = self::normalizeUploadPath($data['pdf_file'] ?? null);

        if ($path) {
            $count = app(PdfPageCountService::class)->countPages($path);

            if ($count !== null) {
                $data['pdf_page_count'] = $count;
            }
        }

        return $data;
    }
}
