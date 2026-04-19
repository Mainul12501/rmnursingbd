<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentRequest;

class AppointmentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppointmentRequest::factory()
            ->count(5)
            ->create();
    }
}
