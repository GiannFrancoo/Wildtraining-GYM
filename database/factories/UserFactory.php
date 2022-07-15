<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                  => $this->faker->name(),
            'email'                 => $this->faker->unique()->safeEmail(),
            'email_verified_at'     => now(),
            'password'              => 'password',
            'remember_token'        => Str::random(10),     
            'primary_phone'         => $this->faker->phoneNumber(),
            'secundary_phone'       => $this->faker->phoneNumber(),
            'address'               => $this->faker->address(),
            'birthday'              => Carbon::now()->subYears(rand(1, 55)),
            'start_date'            => Carbon::now()->subYears(rand(1, 55)),
            'personal_information'  => $this->faker->realText(),
            'social_work'           => $this->faker->words(2,true),
            'role_id'               => Role::inRandomOrder()->first()->id, //llamo todos lo roles en orden random (serian 2 igual), y de ahi agarro el primero 
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
