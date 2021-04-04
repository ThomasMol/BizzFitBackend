<?php

namespace Database\Factories;

use App\Models\PhysicalActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhysicalActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PhysicalActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        $types = [
            'Running',
            'Cycling',
            'Walking',
            'Weightlifting',
        ];

        return [
            'id'=> $this->faker->uuid,
            //'user_id' => $this->faker->uuid ,
            'type' => $types[$this->faker->numberBetween(0,3)],
            'points' => $this->faker->numberBetween(25,200),
            'time_seconds' => $this->faker->numberBetween(25,12000),
            'date_time' => $this->faker->dateTimeBetween('-10 days', 'now')
        ];
    }
}
