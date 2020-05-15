<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /**
     * カテゴリー一覧表示テスト
     * @test
     * @return void
     */
    public function textShowList()
    {
        // 既存ユーザーでログイン
        \Auth::loginUsingId(1);
        // カテゴリーページをGET
        $request = $this->get('admin/category');
        // ステータスコードチェック
        $request->assertOk();
        // テンプレートチェック
        $request->assertViewIs('admin.category.list');
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

    /**
     * カテゴリー登録画面表示テスト
     * @test
     * @return void
     */
    public function testShowCreate()
    {
        // 既存ユーザーでログイン
        \Auth::loginUsingId(1);
        // カテゴリー登録をGET
        $request = $this->get('admin/category/create');
        // ステータスコードチェック
        $request->assertOk();
        // テンプレートチェック
        $request->assertViewIs('admin.category.create');
        // 表示内容
        $request->assertSee(config('title.category.create') . ' | ' . config('app.name'))
            ->assertSee('前のページへ戻る')
            ->assertSee(config('title.category.create'))
            ->assertSee('カテゴリー名')
            ->assertSee('必須')
            ->assertSee('保存する');
    }
}
