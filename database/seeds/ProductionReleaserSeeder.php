<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class ProductionReleaserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name'  => '下書き'
        ]);
        Status::create([
            'name'  => '公開'
        ]);
        DB::table('users')->insert([
            'name' => config('user.name'),
            'email' => config('user.email'),
            'password' => bcrypt(config('user.password')),
            'role_type' => config('const.role_type.admin'),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => \CommonHelper::getNow(),
            'updated_at' => \CommonHelper::getNow(),
        ]);
    }
}
