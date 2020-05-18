<?php

namespace Tests\Feature\Models;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

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
        $this->assertTrue(true);
    }

    /** @test */
    public function testInsert()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function testUpdateById()
    {
        $this->assertTrue(true);
    }
}
