<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Administrador'],
            ['id' => 2, 'name' => 'Usuario'],
        ];

        foreach ($roles as $role){
            Role::updateOrCreate($role);
        } 

    }
}
