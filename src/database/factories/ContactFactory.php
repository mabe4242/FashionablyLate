<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1,5),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->numberBetween(1,3),
            'email' => $this->faker->safeEmail(),
            'tel' => '0'. $this->faker->numberBetween(70, 90) . 
                $this->faker->numberBetween(1000, 9999) .
                $this->faker->numberBetween(1000, 9999),
            'address' => $this->faker->address(),
            'building' => $this->faker->realText(10),
            'detail' => $this->faker->realText(20),
            'created_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
