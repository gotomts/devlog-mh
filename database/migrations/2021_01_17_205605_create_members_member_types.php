<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersMemberTypes extends Migration
{
    protected $tableName = 'members_member_types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('members_id');
                $table->unsignedBigInteger('member_types_id');

                $table->primary(['members_id', 'member_types_id']);
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
            Schema::dropIfExists($this->tableName);
        }
    }
}