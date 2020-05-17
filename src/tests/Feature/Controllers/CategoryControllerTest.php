<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * カテゴリー一覧表示テスト
     * @test
     * @return void
     */
    public function textShowList()
    {
        // ユーザー作成
        $user = factory(User::class)->create();
        // 既存ユーザーでログイン
        \Auth::loginUsingId($user->id);
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
        // ユーザー作成
        $user = factory(User::class)->create();
        // 既存ユーザーでログイン
        \Auth::loginUsingId($user->id);
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

    /** @test */
    public function testExeCreate()
    {
        $user = factory(User::class)->create();
        \Auth::loginUsingId($user->id);
        $params = [
            'name' => 'カテゴリー',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        $url = url('admin/category/create');
        $response = $this->post($url, $params);
        $response->assertStatus(302);

        // DBに登録されたレコードの確認
        $this->assertDatabaseHas('categories', $params);

        // 表示確認
        $response->assertRedirect('admin/category');
        // リダイレクト先に登録成功のメッセージが表示されるか
        $redirectResponse = $this->get('admin/category');
        $redirectResponse->assertSee(config('messages.common.success'));
    }

    public function testShowEdit()
    {
        // FIXME:
        $this->assertTrue(true);
    }

    public function testExeEdit()
    {
        // FIXME:
        $this->assertTrue(true);
    }
}
