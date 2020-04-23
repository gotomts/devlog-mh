<?php

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'url' => 'test1',
            'title' => 'title1',
            'description' => 'description1',
            'keyword' => 'keyword1',
            'content' => 'content1',
            'status_id' => 1,
            'category_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Post::create([
            'url' => 'test2',
            'title' => 'title2',
            'description' => 'description2',
            'keyword' => 'keyword2',
            'content' => 'content2',
            'status_id' => 2,
            'category_id' => 2,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
