<?php

namespace Database\Factories;

use App\Models\MentalState;
use Illuminate\Database\Eloquent\Factories\Factory;

class MentalStateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MentalState::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'=> $this->faker->uuid,
            //'user_id' => $this->faker->uuid ,
            'points' => $this->faker->numberBetween(25,200),
            'state' => $this->faker->biasedNumberBetween(0,4, 'sqrt'),
            'date_time' => $this->faker->dateTimeBetween('-10 days', 'now')
        ];
    }
}
