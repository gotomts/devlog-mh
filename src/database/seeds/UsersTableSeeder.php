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
            'email' => 'develop@example.com',
            'password' => bcrypt('Password!'),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon(),
            'user_id' => 1,
            'role' => 1,
        ]);
    }
}
