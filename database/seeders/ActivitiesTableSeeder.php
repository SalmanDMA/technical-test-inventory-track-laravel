<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitiesTableSeeder extends Seeder
{
    public function run()
    {
        Activity::factory()->count(10)->create();
    }
}
