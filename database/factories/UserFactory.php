<?php

namespace Database\Factories;

use App\Models\Gender;
use App\Models\Role;
use App\Models\SocialWork;
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
            'last_name'             => $this->faker->name(),
            'gender_id'             => Gender::inRandomOrder()->first()->id,
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
            'role_id'               => Role::find(2)->id, 
            'social_work_id'        => SocialWork::inRandomOrder()->first()->id,
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
