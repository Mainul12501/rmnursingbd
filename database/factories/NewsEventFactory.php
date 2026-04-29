<?php

namespace Database\Factories;

use App\Models\NewsEvent;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'main_image' => $this->faker->text(255),
            'sub_images' => $this->faker->text(),
            'main_content' => $this->faker->text(),
            'status' => 1,
            'slug' => $this->faker->slug(),
            'news_event_category_id' => \App\Models\NewsEventCategory::factory(),
        ];
    }
}
