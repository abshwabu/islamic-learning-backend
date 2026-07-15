<?php

namespace Database\Factories;

use App\Models\Ders;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startPage = fake()->numberBetween(1, 50);

        return [
            'ders_id' => Ders::factory(),
            'title' => 'Episode '.fake()->numberBetween(1, 20).': '.fake()->sentence(2),
            'audio_file' => 'episodes/'.Str::uuid().'.mp3',
            'duration_seconds' => fake()->numberBetween(300, 3600),
            'start_page' => $startPage,
            'end_page' => $startPage + fake()->numberBetween(5, 20),
            'sort_order' => fake()->numberBetween(1, 20),
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
