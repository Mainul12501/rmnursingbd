<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ClientReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientReview::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->text(255),
            'client_image' => $this->faker->text(255),
            'rating' => '1',
            'content' => $this->faker->text(),
            'pub_date' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
