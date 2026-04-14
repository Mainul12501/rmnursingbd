<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_title' => $this->faker->sentence(10),
            'menu_title' => $this->faker->text(255),
            'main_image' => $this->faker->text(255),
            'sub_images' => $this->faker->text(),
            'page_content' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'status' => $this->faker->numberBetween(0, 127),
            'order' => $this->faker->numberBetween(0, 127),
        ];
    }
}
