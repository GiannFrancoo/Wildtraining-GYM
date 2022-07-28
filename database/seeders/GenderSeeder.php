<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            ['id' => 1, 'name' => 'Masculino'],
            ['id' => 2, 'name' => 'Femenino'],
        ];

        foreach ($genders as $gender) {
            Gender::updateOrCreate($gender);
        } 
    }
}
