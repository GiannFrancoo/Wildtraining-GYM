<?php

namespace Database\Seeders;

use App\Models\Gender;
use App\Models\Role;
use App\Models\SocialWork;
use App\Models\User;
use Carbon\Carbon;
Use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $usersAdmin = [
            [
                'name'                  => 'Lucas',
                'last_name'             => 'Cervelli Haderne',
                'email'                 => 'lucasch98.lch@gmail.com',
                'gender_id'             => Gender::MAN,
                'email_verified_at'     => now(),
                'password'              => 'password',
                'remember_token'        => Str::random(10),     
                'primary_phone'         => '123456789',
                'secondary_phone'       => '123456799',
                'address'               => 'avenida siempre viva 123',
                'birthday'              => Carbon::now()->subYears(rand(1, 55)),
                'start_date'            => Carbon::now()->subYears(rand(1, 55)),
                'role_id'               => Role::ADMIN, 
                'social_work_id'        => SocialWork::inRandomOrder()->first()->id,
            ],
            [
                'name'                  => 'Gian Franco',
                'last_name'             => 'Bentivegna',
                'email'                 => 'GiannFrancoo1@hotmail.com',
                'gender_id'             => Gender::MAN,
                'email_verified_at'     => now(),
                'password'              => 'password',
                'remember_token'        => Str::random(10),     
                'primary_phone'         => '12345678999',
                'secondary_phone'       => '123456789999',
                'address'               => 'avenida siempre viva 123',
                'birthday'              => Carbon::now()->subYears(rand(1, 55)),
                'start_date'            => Carbon::now()->subYears(rand(1, 55)),
                'role_id'               => Role::ADMIN, 
                'social_work_id'        => SocialWork::inRandomOrder()->first()->id,   
            ]
        ];

        foreach ($usersAdmin as $userAdmin) {
            User::updateOrCreate($userAdmin);
        }       
        
       // User::factory(10)
        //     ->create();       

    }
}
