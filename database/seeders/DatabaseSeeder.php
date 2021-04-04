<?php

namespace Database\Seeders;

use App\Models\MentalState;
use App\Models\Organization;
use App\Models\PhysicalActivity;
use App\Models\User;
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
        Organization::factory(5)->create()->each(function ($organization){
            User::factory(10)->create(['organization_id' => $organization->id])->each(function ($user){
                MentalState::factory(15)->create(['user_id' => $user->id]);
                PhysicalActivity::factory(15)->create(['user_id' => $user->id]);
            });
        });

    }
}
