<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{

    // テーブル名
    private $tableName = 'users';
    // 追加カラム
    private $addRole = 'role';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->tableName)) {
            Schema::table($this->tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($this->tableName, $this->addRole)) {
                    $table->integer($this->addRole)->default(config('const.USER.Role.general'));
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable($this->tableName)) {
            Schema::table($this->tableName, function (Blueprint $table) {
                if (Schema::hasColumn($this->tableName, $this->addRole)) {
                    $table->dropColumn($this->addRole);
                }
            });
        }
    }
}
