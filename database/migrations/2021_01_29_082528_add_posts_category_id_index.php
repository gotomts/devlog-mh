<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostsCategoryIdIndex extends Migration
{
    protected $table = 'posts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn($this->table, 'category_id')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->index('category_id');
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
        if (Schema::hasColumn($this->table, 'category_id')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->dropIndex('posts_category_id_index');
            });
        }
    }
}
