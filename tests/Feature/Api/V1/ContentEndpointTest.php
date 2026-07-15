<?php

namespace Tests\Feature\Api\V1;

use App\Models\Ders;
use App\Models\Episode;
use App\Models\Topic;
use App\Models\Ustaz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_endpoint_returns_expected_json_shape(): void
    {
        $ustaz = Ustaz::factory()->create([
            'name' => 'Active Ustaz',
            'slug' => 'active-ustaz',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Ustaz::factory()->inactive()->create([
            'name' => 'Inactive Ustaz',
            'slug' => 'inactive-ustaz',
        ]);

        $topic = Topic::factory()->create([
            'name' => 'Active Topic',
            'slug' => 'active-topic',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Topic::factory()->inactive()->create([
            'name' => 'Inactive Topic',
            'slug' => 'inactive-topic',
        ]);

        $publishedDers = Ders::factory()->create([
            'ustaz_id' => $ustaz->id,
            'topic_id' => $topic->id,
            'title' => 'Published Ders',
            'slug' => 'published-ders',
            'pdf_file' => 'derses/sample.pdf',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Ders::factory()->unpublished()->create([
            'ustaz_id' => $ustaz->id,
            'topic_id' => null,
            'title' => 'Draft Ders',
            'slug' => 'draft-ders',
        ]);

        Episode::factory()->create([
            'ders_id' => $publishedDers->id,
            'title' => 'Published Episode',
            'audio_file' => 'episodes/sample.mp3',
            'start_page' => 1,
            'end_page' => 10,
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Episode::factory()->unpublished()->create([
            'ders_id' => $publishedDers->id,
            'title' => 'Draft Episode',
            'audio_file' => 'episodes/draft.mp3',
            'start_page' => 11,
            'sort_order' => 2,
        ]);

        $response = $this->getJson('/api/v1/content');

        $response->assertOk();
        $response->assertJsonStructure([
            'ustazes' => [
                ['id', 'name', 'slug', 'bio', 'photo', 'sort_order'],
            ],
            'topics' => [
                ['id', 'name', 'slug', 'icon', 'color', 'sort_order'],
            ],
            'derses' => [
                ['id', 'ustaz_id', 'topic_id', 'title', 'slug', 'description', 'cover_image', 'pdf_file', 'pdf_page_count', 'sort_order', 'episodes' => [
                    ['id', 'ders_id', 'title', 'audio_file', 'duration_seconds', 'start_page', 'end_page', 'sort_order'],
                ]],
            ],
        ]);

        $response->assertJsonCount(1, 'ustazes');
        $response->assertJsonCount(1, 'topics');
        $response->assertJsonCount(1, 'derses');
        $response->assertJsonCount(1, 'derses.0.episodes');

        $response->assertJsonPath('ustazes.0.slug', 'active-ustaz');
        $response->assertJsonPath('topics.0.slug', 'active-topic');
        $response->assertJsonPath('derses.0.slug', 'published-ders');
        $response->assertJsonPath('derses.0.episodes.0.title', 'Published Episode');
        $response->assertJsonPath('derses.0.pdf_file', url('storage/derses/sample.pdf'));
        $response->assertJsonPath('derses.0.episodes.0.audio_file', url('storage/episodes/sample.mp3'));
    }
}
