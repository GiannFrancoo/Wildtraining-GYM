<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

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
            ['id' => 2, 'name' => 'Profesor'],
            ['id' => 3, 'name' => 'Usuario'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        } 

    }
}
