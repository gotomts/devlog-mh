<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriesNameIndex extends Migration
{
    protected $table = 'categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn($this->table, 'name')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->index('name');
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
        if (Schema::hasColumn($this->table, 'name')) {
            Schema::table($this->table, function (Blueprint $table) {
                $table->dropIndex('categories_name_index');
            });
        }
    }
}
