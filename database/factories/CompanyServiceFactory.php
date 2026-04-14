<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CompanyService;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'content_title' => $this->faker->text(255),
            'page_content' => $this->faker->text(),
            'page_main_image' => $this->faker->text(255),
            'service_menu_type' => 'main',
            'status' => $this->faker->numberBetween(0, 127),
            'page_sub_images' => $this->faker->text(),
            'slug' => $this->faker->slug(),
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
