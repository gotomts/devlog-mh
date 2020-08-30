<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
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
    }
}
