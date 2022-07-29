<?php

namespace Database\Seeders;

use App\Models\SocialWork;
use Illuminate\Database\Seeder;

class SocialWorkSeeder extends Seeder
{
    const NOSOCIALWORK = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socialWorks = [
            ['id' => 1, 'name' => 'Sin obra social'],
            ['id' => 2, 'name' => 'IOMA'],
            ['id' => 3, 'name' => 'PAMI'],
            ['id' => 4, 'name' => 'OSECAC'],
            ['id' => 5, 'name' => 'SOSUNS'],
            ['id' => 6, 'name' => 'SWISS MEDICAL'],
            ['id' => 7, 'name' => 'DOSEM'],
        ];

        foreach ($socialWorks as $socialWork) {
            SocialWork::updateOrCreate($socialWork);
        } 

    }
}
