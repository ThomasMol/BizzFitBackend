<?php

namespace Database\Seeders;

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
        \App\Models\Organization::factory(5)->create()->each(function ($organization){
            \App\Models\User::factory(10)->create(['organization_id' => $organization->id]);
        });

    }
}
