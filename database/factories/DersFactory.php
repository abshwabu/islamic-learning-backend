<?php

namespace Database\Factories;

use App\Models\Ders;
use App\Models\Topic;
use App\Models\Ustaz;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ders>
 */
class DersFactory extends Factory
{
    protected $model = Ders::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'ustaz_id' => Ustaz::factory(),
            'topic_id' => fake()->boolean(70) ? Topic::factory() : null,
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->optional()->paragraphs(2, true),
            'cover_image' => fake()->optional()->filePath(),
            'pdf_file' => 'derses/'.Str::uuid().'.pdf',
            'pdf_page_count' => fake()->numberBetween(20, 200),
            'sort_order' => fake()->numberBetween(0, 100),
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
