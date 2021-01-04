<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    protected $table = 'members';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->insert([
            'name' => 'member',
            'email' => 'member@example.com',
            'password' => bcrypt('Password!'),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \CommonHelper::getNow(),
            'updated_at' => \CommonHelper::getNow(),
        ]);
    }
}
