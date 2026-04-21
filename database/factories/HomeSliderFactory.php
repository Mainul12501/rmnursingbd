<?php

namespace Database\Factories;

use App\Models\HomeSlider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeSliderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HomeSlider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->text(),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
