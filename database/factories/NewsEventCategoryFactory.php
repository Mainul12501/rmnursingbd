<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\NewsEventCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsEventCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsEventCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->numberBetween(0, 127),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
