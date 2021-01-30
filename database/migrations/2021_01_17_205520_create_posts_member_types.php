<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsMemberTypes extends Migration
{
    protected $table = 'posts_member_types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->unsignedBigInteger('posts_id');
                $table->unsignedBigInteger('member_types_id');

                $table->primary(['posts_id', 'member_types_id']);
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
        if (Schema::hasTable($this->table)) {
            Schema::dropIfExists($this->table);
        }
    }
}
