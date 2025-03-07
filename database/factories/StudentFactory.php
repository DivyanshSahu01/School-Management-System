<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name('male'),
            'father_name'=>$this->faker->name('male'),
            'contact'=>rand(6000000000, 9999999999),
            'date_of_birth'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'standard'=>rand(1, 12),
            'medium'=>rand(1, 2),
            'roll_no'=>Str::random(10),
            'fee_type'=>rand(1, 2),
            'address'=>$this->faker->address(),
            'uuid'=>Str::uuid()
        ];
    }
}
