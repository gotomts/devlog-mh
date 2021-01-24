<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    protected $table = 'statuses';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // statusesテーブルは固定値なので、シーディングするときはtruncateする
        \DB::table($this->table)->truncate();
        // statusesテーブルへ値を登録
        Status::create([
            'name'  => '下書き'
        ]);
        Status::create([
            'name'  => '公開'
        ]);
        Status::create([
            'name'  => '限定公開'
        ]);
    }
}
