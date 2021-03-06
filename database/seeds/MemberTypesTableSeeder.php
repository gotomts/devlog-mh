<?php

use Illuminate\Database\Seeder;
use App\Models\MemberTypes;

class MemberTypesTableSeeder extends Seeder
{
    protected $tableName = 'member_types';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 一旦FK制約を無視
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // member_typesテーブルは固定値なので、シーディングするときはtruncateする
        \DB::table($this->tableName)->truncate();
        // member_typesテーブルへ値を登録
        MemberTypes::create([
            'name'  => '一般'
        ]);
        MemberTypes::create([
            'name'  => '特別'
        ]);
        MemberTypes::create([
            'name'  => '制限中'
        ]);

        // FK制約を戻す
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
