<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Request;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
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

    /** @test */
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

    /** @test */
    public function testGetAll()
    {
        $data = Category::getAll();
        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
    }

    /** @test */
    public function testGetPostCategory()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create([
            'name' => 'category',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        $post = factory(Post::class)->create([
            'category_id' => $category->id
        ]);
        $this->assertCount(
            1,
            $category->getPostCategory($post->category_id)
        );
    }

    /** @test */
    public function testInsert()
    {
        $user = factory(User::class)->create();
        $params = [
            'name' => 'カテゴリー',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        $result = Category::insert($params);
        $this->assertInstanceOf(Category::class, $result);
    }

    /** @test */
    public function testUpdateById()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $params = [
            'name' => 'カテゴリー',
            'updated_by' => $user->id,
        ];
        $result = Category::updateById($category->id, $params);
        $this->assertTrue($result);
    }
}
