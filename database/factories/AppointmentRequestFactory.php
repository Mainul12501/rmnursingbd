<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AppointmentRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppointmentRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'subject' => $this->faker->text(255),
            'message' => $this->faker->sentence(20),
            'status' => 'pending',
            'requested_user_id' => \App\Models\User::factory(),
            'managed_user_id' => \App\Models\User::factory(),
            'company_service_id' => \App\Models\CompanyService::factory(),
        ];
    }
}
