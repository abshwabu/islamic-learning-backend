<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Throwable;

class PdfPageCountService
{
    public function countPages(string $pathOnPublicDisk): ?int
    {
        $fullPath = Storage::disk('public')->path($pathOnPublicDisk);

        if (! is_file($fullPath)) {
            return null;
        }

        try {
            $pdf = (new Parser)->parseFile($fullPath);

            return count($pdf->getPages());
        } catch (Throwable) {
            return null;
        }
    }
}
