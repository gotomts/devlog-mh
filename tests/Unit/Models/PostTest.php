<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function testGetByUrl()
    {
        $post = factory(Post::class)->create();
        $urlPost = Post::getByUrl($post->url);

        $this->assertEquals($post->id, $urlPost->id);
        $this->assertEquals($post->url, $urlPost->url);
        $this->assertEquals($post->title, $urlPost->title);
        $this->assertEquals($post->description, $urlPost->description);
        $this->assertEquals($post->keyword, $urlPost->keyword);
        $this->assertEquals($post->markdown_content, $urlPost->markdown_content);
        $this->assertEquals($post->html_content, $urlPost->html_content);
        $this->assertEquals($post->status_id, $urlPost->status_id);
        $this->assertEquals($post->category_id, $urlPost->category_id);
        $this->assertEquals($post->created_by, $urlPost->created_by);
        $this->assertEquals($post->updated_by, $urlPost->updated_by);
        $this->assertEquals($post->deleted_by, $urlPost->deleted_by);
    }

    /** @test */
    public function testGetAll()
    {
        $createNum = 20;
        factory(Post::class, $createNum)->create();

        $posts = Post::getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $posts);

        // 作成したレコード数と取得したレコードの数が一致するか
        $this->assertEquals($createNum, $posts->total());

        // 1ページあたりの表示数は指定どおりか
        $this->assertEquals(config('pagination.items'), $posts->perPage());
    }

    /** @test */
    public function testGetPublishingAll()
    {
        $createNum = 20;
        factory(Post::class, $createNum)->create();

        $posts = Post::getPublishingAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $posts);

        foreach ($posts as $value) {
            // 取得できたレコードは公開中の記事か
            $this->assertEquals(config('const.statuses.publishing'), $value->status_id);
            // 取得できたレコードに下書きは含まれないか
            $this->assertNotEquals(config('const.statuses.draft'), $value->status_id);
        }

        // 1ページあたりの表示数は指定どおりか
        $this->assertEquals(config('pagination.items'), $posts->perPage());
    }

    /** @test */
    public function testGetPageLinkUrl()
    {
        $posts = factory(Post::class, 3)->create([
            'status_id'   => config('const.statuses.publishing'),
        ]);

        $nextPost       = $posts[0];
        $currentPost    = $posts[1];
        $prevPost       = $posts[2];

        $prevLink = Post::getPageLinkUrl($currentPost->id, true);
        $nextLink = Post::getPageLinkUrl($currentPost->id, false);

        $this->assertEquals($prevPost->url, $prevLink->url);
        $this->assertEquals($nextPost->url, $nextLink->url);
    }

    /** @test */
    public function testGetPostCategoryAll()
    {
        $category = factory(Category::class)->create();
        $notCategory = factory(Category::class)->create();

        factory(Post::class, 3)->create([
            'category_id'   => $category->id,
            'status_id'     => config('const.statuses.publishing'),
        ]);

        $categoryPosts = Post::getPostCategoryAll($category->name);

        foreach ($categoryPosts as $categoryPost) {
            $this->assertEquals($category->name, $categoryPost->categories->name);
            $this->assertNotEquals($notCategory->name, $categoryPost->categories->name);
        }
    }

    /** @test */
    public function testInsert()
    {
        $user = factory(User::class)->create();
        $params = [
            'url' => $this->faker()->unique()->word,
            'title' => implode($this->faker()->words($nb=3, $asText=false)),
            'description' => $this->faker()->text($maxNbChars=124),
            'keyword' => implode($this->faker()->words($nb=5, $asText=false)),
            'markdown_content' => implode($this->faker()->paragraphs($nb=3, $asText=false)),
            'html_content' => '<p>'.implode($this->faker()->paragraphs($nb=3, $asText=false)).'</p>',
            'status_id' => $this->faker()->numberBetween($min=1, $max=2),
            'category_id' => $this->faker()->numberBetween($min=1, $max=5),
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        $result = Post::insert($params);
        $this->assertInstanceOf(Post::class, $result);
        $this->assertDatabaseHas('posts', $params);
    }

    /** @test */
    public function testInsertWithPostImage()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function testUpdateById()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function testUpdateByIdWithPostImage()
    {
        $this->assertTrue(true);
    }
}
