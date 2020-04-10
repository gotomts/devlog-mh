<?php

namespace Tests\Feature;

use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /** @noinspection NonAsciiCharacters */
    /**
     * カテゴリー一覧表示チェック
     * @test
     * @return void
     */
    public function カテゴリー一覧表示テスト()
    {
        // 既存ユーザーでログイン
        \Auth::loginUsingId(1);
        // カテゴリーページをGET
        $request = $this->get('category');
        // ステータスコードチェック
        $request->assertStatus(200);
        // テンプレートチェック
        $request->assertViewIs('category.list');
        // 表示内容チェック
        $request->assertSee(config('title.category.list') . ' | ' . config('app.name'))
            ->assertSee('前のページへ戻る')
            ->assertSee(config('title.category.list'))
            ->assertSee('新規作成')
            ->assertSee('編集')
            ->assertSee('カテゴリー名')
            ->assertSee('更新者')
            ->assertSee('更新日時');
    }

    public function testShowCreate()
    {

    }

}
