<?php

use App\Role;
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
        Role::query()->create([
            'name' => 'admin',
            'description' => 'Administrador',
        ]);
        Role::query()->create([
            'name' => 'common',
            'description' => 'Comum',
        ]);
    }
}
