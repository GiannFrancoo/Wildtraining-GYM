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
                'name'                  => 'Gian Franco',
                'last_name'             => 'Bentivegna',
                'email'                 => 'giannfrancoo1@hotmail.com',
                'gender_id'             => Gender::MAN,
                'email_verified_at'     => now(),
                'password'              => 'password',
                'remember_token'        => Str::random(10),     
                'primary_phone'         => '+54 9 291 5023991',
                'secondary_phone'       => '+54 9 291 5024849',
                'address'               => 'Eduardo Gonzalez 480',
                'birthday'              => Carbon::createFromDate(1998,8,28,'America/Argentina/Buenos_Aires'),
                'start_date'            => Carbon::createFromDate(2022,5,1,'America/Argentina/Buenos_Aires'),
                'role_id'               => Role::ADMIN, 
                'social_work'           => 'osecac',   
            ],
            [
                'name'                  => 'Juan Martin',
                'last_name'             => 'Sanchez',
                'email'                 => 'martinst1@hotmail.com',
                'gender_id'             => Gender::MAN,
                'email_verified_at'     => now(),
                'password'              => 'Larenga73',
                'remember_token'        => Str::random(10),     
                'primary_phone'         => '+54 9 2915 04-8149',
                'secondary_phone'       => '',
                'address'               => 'Rosario 1942 2A',
                'birthday'              => Carbon::createFromDate(1989,7,21,'America/Argentina/Buenos_Aires'),
                'start_date'            => Carbon::createFromDate(2022,4,11,'America/Argentina/Buenos_Aires'),
                'role_id'               => Role::ADMIN, 
                'social_work'           => 'No definida',   
            ]
        ];

        foreach ($usersAdmin as $userAdmin) {
            User::updateOrCreate($userAdmin);
        }       
        
        User::factory(30)->create();       
    }
}
