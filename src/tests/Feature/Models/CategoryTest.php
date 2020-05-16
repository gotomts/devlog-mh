<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カテゴリが作成できるか
     *
     * @test
     * @return void
     */
    public function testCreateCategory()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create([
            'name' => 'category',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        $this->assertEquals(
            Category::find($category->id),
            $category->find($category->id)
        );
    }

    /**
     * getByIdメソッドは有効か
     *
     * @return void
     */
    public function testGetById()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create([
            'name' => 'category',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        $this->assertEquals(
            Category::getById($category->id),
            $category->getById($category->id)
        );
    }

    /**
     * getAllメソッドを利用でき、ページャーの型で返ってくるか
     *
     * @test
     * @return void
     */
    public function testGetAll()
    {
        $data = Category::getAll();
        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
    }

    /**
     * getPostCategoryメソッドを利用でき、投稿記事が存在するか
     *
     * @test
     * @return void
     */
    public function testGetPostCategory()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create([
            'name' => 'category',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        $post = factory(Post::class)->create();
        $this->assertCount(
            1,
            $category->getPostCategory($category->id)
        );
    }
}
