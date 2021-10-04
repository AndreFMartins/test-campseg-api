<?php

use App\Role;
use App\User;
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
        $adminId = Role::query()->where('name', 'admin')->first()->id;
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'password' => '123mudar',
            'role_id' => $adminId,
        ]);

        factory(User::class, 30)->create();
    }
}
