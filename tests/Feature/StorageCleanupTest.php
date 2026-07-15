<?php

namespace Tests\Feature;

use App\Models\Ders;
use App\Models\Episode;
use App\Models\Ustaz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_ders_removes_associated_files_from_storage(): void
    {
        Storage::fake('public');

        $ustaz = Ustaz::factory()->create();
        $ders = Ders::factory()->create([
            'ustaz_id' => $ustaz->id,
            'cover_image' => 'derses/covers/cover.jpg',
            'pdf_file' => 'derses/pdfs/lesson.pdf',
        ]);

        Storage::disk('public')->put('derses/covers/cover.jpg', 'cover');
        Storage::disk('public')->put('derses/pdfs/lesson.pdf', 'pdf');

        $ders->delete();

        Storage::disk('public')->assertMissing('derses/covers/cover.jpg');
        Storage::disk('public')->assertMissing('derses/pdfs/lesson.pdf');
    }

    public function test_deleting_episode_removes_audio_file_from_storage(): void
    {
        Storage::fake('public');

        $ders = Ders::factory()->create();
        $episode = Episode::factory()->create([
            'ders_id' => $ders->id,
            'audio_file' => 'episodes/lesson.mp3',
        ]);

        Storage::disk('public')->put('episodes/lesson.mp3', 'audio');

        $episode->delete();

        Storage::disk('public')->assertMissing('episodes/lesson.mp3');
    }
}
