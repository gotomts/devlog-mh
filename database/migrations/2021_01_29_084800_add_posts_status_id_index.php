<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostsStatusIdIndex extends Migration
{
    protected $table = 'posts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn($this->table, 'status_id')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->index('status_id');
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
        if (Schema::hasColumn($this->table, 'status_id')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->dropIndex('posts_status_id_index');
            });
        }
    }
}
