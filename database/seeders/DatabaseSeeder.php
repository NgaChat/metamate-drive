<?php

namespace Database\Seeders;

use App\Models\Ads;
use App\Models\Drive;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();

        Drive::factory(10)->create();

        Ads::factory(5)->create();
    }
}
