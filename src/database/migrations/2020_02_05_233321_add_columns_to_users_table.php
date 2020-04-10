<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{

    // テーブル名
    private $tableName = 'users';
    // カラム名 削除フラグ
    private $deleteFlg = 'delete_flg';
    // カラム名 更新者
    private $userId   = 'user_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->tableName)) {
            Schema::table($this->tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($this->tableName, $this->deleteFlg)) {
                    $table->integer($this->deleteFlg)->nullable();
                }
                if (!Schema::hasColumn($this->tableName, $this->userId)) {
                    $table->integer($this->userId);
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
                if (Schema::hasColumn($this->tableName, $this->deleteFlg)) {
                    $table->dropColumn($this->deleteFlg);
                }
                if (Schema::hasColumn($this->tableName, $this->userId)) {
                    $table->dropColumn($this->userId);
                }
            });

        }
    }
}
