<?php

namespace Database\Seeders;

use App\Models\SocialWork;
use Illuminate\Database\Seeder;

class SocialWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socialWorks = [
            ['id' => 1, 'name' => 'IOMA'],
            ['id' => 2, 'name' => 'PAMI'],
            ['id' => 3, 'name' => 'OSECAC'],
            ['id' => 4, 'name' => 'SWISS MEDICAL'],
        ];

        foreach ($socialWorks as $socialWork) {
            SocialWork::updateOrCreate($socialWork);
        } 

    }
}
