<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Password!'),
            'role_type' => \IniHelper::get('USER_ROLE', false, 'ADMIN'),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \CommonHelper::getNow(),
            'updated_at' => \CommonHelper::getNow(),
        ]);
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('Password!'),
            'role_type' => \IniHelper::get('USER_ROLE', false, 'GENERAL'),
            'created_by' => 1,
            'updated_by' => 2,
            'created_at' => \CommonHelper::getNow(),
            'updated_at' => \CommonHelper::getNow(),
        ]);
        DB::table('users')->insert([
            'name' => 'delete_user',
            'email' => 'delete_user@example.com',
            'password' => bcrypt('Password!'),
            'role_type' => \IniHelper::get('USER_ROLE', false, 'GENERAL'),
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_by' => 2,
            'created_at' => \CommonHelper::getNow(),
            'updated_at' => \CommonHelper::getNow(),
            'deleted_at' => \CommonHelper::getNow(),
        ]);
    }
}
