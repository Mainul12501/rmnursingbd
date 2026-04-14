<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsEventCategory;

class NewsEventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsEventCategory::factory()
            ->count(5)
            ->create();
    }
}
