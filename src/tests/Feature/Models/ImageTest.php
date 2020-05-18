<?php

namespace Tests\Feature\Models;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function testGetAll()
    {
        // 画像作成
        $createImages = 20;
        factory(Image::class, $createImages)->create();

        // 取得できたオブジェクトの確認
        $images = Image::getAll();
        $this->assertInstanceOf(LengthAwarePaginator::class, $images);

        // 作成したレコード数と取得した数が一致するか
        $this->assertEquals($createImages, $images->total());

        // １ページあたりの画像の数は指定どおりか
        $this->assertEquals(config('pagination.items'), $images->perPage());
    }

    /** @test */
    public function testGetById()
    {
        $Image = factory(Image::class)->create();
        $this->assertEquals(
            Image::getById($Image->id),
            $Image->getById($Image->id)
        );
    }

    /** @test */
    public function testInsert()
    {
        $user = factory(User::class)->create();
        $params = [
            'url'           => $this->faker()->url,
            'title'         => $this->faker()->word,
            'alt'           => $this->faker()->word,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];
        $result = Image::insert($params);
        $this->assertInstanceOf(Image::class, $result);
        $this->assertDatabaseHas('images', $params);
    }

    /** @test */
    public function testUpdateById()
    {
        $user = factory(User::class)->create();
        $image = factory(Image::class)->create();
        $params = [
            'title'         => 'タイトル変更テスト titleタグ',
            'alt'           => 'タイトル変更テスト altタグ',
            'updated_by'    => $user->id,
        ];
        $result = Image::updateById($image->id, $params);
        $this->assertTrue($result);
        $this->assertDatabaseHas('images', [
            'url'           => $image->url,
            'title'         => $params['title'],
            'alt'           => $params['alt'],
            'created_by'    => 1,
            'updated_by'    => $user->id,
        ]);
    }
}
