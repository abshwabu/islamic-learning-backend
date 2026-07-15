<?php

namespace Database\Seeders;

use App\Models\Ders;
use App\Models\Episode;
use App\Models\Topic;
use App\Models\Ustaz;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ustazAhmad = Ustaz::factory()->create([
            'name' => 'Sheikh Ahmad Hassan',
            'slug' => 'sheikh-ahmad-hassan',
            'bio' => 'Scholar of tafsir and hadith with over 20 years of teaching experience.',
            'sort_order' => 1,
        ]);

        $ustazFatima = Ustaz::factory()->create([
            'name' => 'Ustadha Fatima Ali',
            'slug' => 'ustadha-fatima-ali',
            'bio' => 'Specializes in fiqh and Islamic history for beginners.',
            'sort_order' => 2,
        ]);

        $topicQuran = Topic::factory()->create([
            'name' => 'Quran Studies',
            'slug' => 'quran-studies',
            'icon' => 'book',
            'color' => '#2563EB',
            'sort_order' => 1,
        ]);

        $topicFiqh = Topic::factory()->create([
            'name' => 'Fiqh',
            'slug' => 'fiqh',
            'icon' => 'mosque',
            'color' => '#16A34A',
            'sort_order' => 2,
        ]);

        $dersTafsir = Ders::factory()->create([
            'ustaz_id' => $ustazAhmad->id,
            'topic_id' => $topicQuran->id,
            'title' => 'Introduction to Tafsir',
            'slug' => 'introduction-to-tafsir',
            'description' => 'A foundational course on understanding Quranic interpretation.',
            'pdf_file' => 'derses/sample-tafsir.pdf',
            'pdf_page_count' => 120,
            'sort_order' => 1,
        ]);

        $dersSalah = Ders::factory()->create([
            'ustaz_id' => $ustazFatima->id,
            'topic_id' => $topicFiqh->id,
            'title' => 'Fiqh of Salah',
            'slug' => 'fiqh-of-salah',
            'description' => 'Learn the rulings and spiritual dimensions of prayer.',
            'pdf_file' => 'derses/sample-salah.pdf',
            'pdf_page_count' => 80,
            'sort_order' => 1,
        ]);

        $dersSeerah = Ders::factory()->create([
            'ustaz_id' => $ustazAhmad->id,
            'topic_id' => null,
            'title' => 'Seerah of the Prophet',
            'slug' => 'seerah-of-the-prophet',
            'description' => 'A chronological study of the life of the Prophet Muhammad (peace be upon him).',
            'pdf_file' => 'derses/sample-seerah.pdf',
            'pdf_page_count' => 200,
            'sort_order' => 2,
        ]);

        Episode::factory()->create([
            'ders_id' => $dersTafsir->id,
            'title' => 'What is Tafsir?',
            'audio_file' => 'episodes/tafsir-01.mp3',
            'duration_seconds' => 1800,
            'start_page' => 1,
            'end_page' => 15,
            'sort_order' => 1,
        ]);

        Episode::factory()->create([
            'ders_id' => $dersTafsir->id,
            'title' => 'Major Tafsir Methodologies',
            'audio_file' => 'episodes/tafsir-02.mp3',
            'duration_seconds' => 2100,
            'start_page' => 16,
            'end_page' => 35,
            'sort_order' => 2,
        ]);

        Episode::factory()->create([
            'ders_id' => $dersTafsir->id,
            'title' => 'Tools for Study',
            'audio_file' => 'episodes/tafsir-03.mp3',
            'duration_seconds' => 1500,
            'start_page' => 36,
            'end_page' => 120,
            'sort_order' => 3,
        ]);

        Episode::factory()->create([
            'ders_id' => $dersSalah->id,
            'title' => 'Conditions of Salah',
            'audio_file' => 'episodes/salah-01.mp3',
            'duration_seconds' => 1200,
            'start_page' => 1,
            'end_page' => 20,
            'sort_order' => 1,
        ]);

        Episode::factory()->create([
            'ders_id' => $dersSalah->id,
            'title' => 'The Prayer in Detail',
            'audio_file' => 'episodes/salah-02.mp3',
            'duration_seconds' => 2400,
            'start_page' => 21,
            'end_page' => 80,
            'sort_order' => 2,
        ]);

        Episode::factory()->create([
            'ders_id' => $dersSeerah->id,
            'title' => 'Pre-Islamic Arabia',
            'audio_file' => 'episodes/seerah-01.mp3',
            'duration_seconds' => 2700,
            'start_page' => 1,
            'end_page' => 40,
            'sort_order' => 1,
        ]);
    }
}
