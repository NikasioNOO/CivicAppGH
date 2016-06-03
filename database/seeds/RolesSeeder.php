<?php

use Illuminate\Database\Seeder;
use CivicApp\Models\Auth\Role;
use CivicApp\Models\Auth\App_User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roleAdmin = Role::create(['role_name' => 'Admin']);


        Role::create(['role_name' => 'Viewer']);
        $admin = App_User::create([
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('passwordadmin'),

        ]);

        $admin->roles()->attach($roleAdmin->id);


/*
        DB::table('roles')->insert([
            'role_name' => 'Admin',
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Viewer'
        ]);

        DB::table('app_users')->insert([
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('passwordadmin'),

        ]);

        DB::table('app_user_role')->insert([
            "app_user_id" => 1,
            "role_id" =>1
        ]);
*/
    }
}
