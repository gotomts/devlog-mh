<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    protected $table = 'posts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('url', 255)->unique();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('keyword')->nullable();
                $table->text('markdown_content')->nullable();
                $table->text('html_content')->nullable();
                $table->integer('status_id');
                $table->integer('category_id');
                $table->integer('created_by');
                $table->integer('updated_by');
                $table->integer('deleted_by')->nullable();
                $table->timestamps();
                $table->softDeletes('deleted_at');
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
