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
            'email' => 'mh.goto.web@gmail.com',
            'password' => bcrypt('fHM?L/UXohx33X'),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon(),
            'user_id' => 1,
            'role' => 1,
        ]);
    }
}
