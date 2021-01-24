<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function testShowList()
    {
        // 一旦スキップ
        $this->markTestIncomplete();

        $user = factory(User::class)->create();
        \Auth::guard('member')->loginUsingId($user->id);

        $response = $this->get('admin/user');
        $response->assertStatus(200)
            ->assertViewIs('admin.user.list');

        $response->assertSee(config('title.user.list') . ' | ' . config('app.name'))
            ->assertSee(config('前のページへ戻る'))
            ->assertSee(config('title.user.list'));

        $response->assertSee(config('新規作成'))
            ->assertSee(config('編集'))
            ->assertSee(config('ユーザー名'))
            ->assertSee(config('更新者'))
            ->assertSee(config('更新日時'));

        $response->assertSee($user->name);
        $response->assertSee($user->updated_name);
        $response->assertSee($user->updated_at->format('Y/m/d H:i:s'));
    }

    /** @test */
    public function testShowCreate()
    {
        // 一旦スキップ
        $this->markTestIncomplete();

        $user = factory(User::class)->create();
        \Auth::loginUsingId($user->id);

        $response = $this->get('admin/user/create');
        $response->assertStatus(200)
            ->assertViewIs('admin.user.create');

        $response->assertSee(config('title.user.create') . ' | ' . config('app.name'))
            ->assertSee(config('前のページへ戻る'))
            ->assertSee(config('title.user.create'));

        $requireText = '必須';
        $response->assertSee('ユーザー名')->assertSee($requireText)
            ->assertSee('メールアドレス')->assertSee($requireText)
            ->assertSee('ユーザー権限')->assertSee($requireText)
            ->assertSee('パスワード')->assertSee($requireText)
            ->assertSee('保存する');
    }

    /** @test */
    public function testExeCreate()
    {
        // 一旦スキップ
        $this->markTestIncomplete();

        $user = factory(User::class)->create();
        \Auth::loginUsingId($user->id);

        $params = [
            'name'          => $this->faker()->name(),
            'email'         => $this->faker()->unique()->safeEmail(),
            'password'      => $this->faker()->password($minLength=8, $maxLength=16),
            'role_type'     => 1,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];

        $url = url('admin/user/create');
        $response = $this->post($url, $params);
        $response->assertStatus(302);

        $checkUser = User::where('email', '=', $params['email'])->first();
        $checkPassword = \Hash::check($params['password'], $checkUser->password);
        $this->assertTrue($checkPassword);
        $this->assertEquals($params['name'], $checkUser->name);
        $this->assertEquals($params['email'], $checkUser->email);
        $this->assertEquals($params['role_type'], $checkUser->role_type);
        $this->assertEquals($params['created_by'], $checkUser->created_by);
        $this->assertEquals($params['updated_by'], $checkUser->updated_by);

        $response->assertRedirect('admin/user');

        $redirectResponse = $this->get('admin/user');
        $redirectResponse->assertSee(config('messages.common.success'));
    }

    /** @test */
    public function testShowEdit()
    {
        // 一旦スキップ
        $this->markTestIncomplete();

        $user = factory(User::class, 2)->create();
        \Auth::loginUsingId($user[0]->id);

        $user2 = $user[1];
        $url = "admin/user/edit/$user2->id";
        $response = $this->get($url);

        $response->assertStatus(200)
            ->assertViewIs('admin.user.edit');

        $response->assertSee(config('title.user.edit') . ' | ' . config('app.name'))
            ->assertSee(config('前のページへ戻る'))
            ->assertSee(config('title.user.edit'));

        $requireText = '必須';
        $response->assertSee('ユーザー名')->assertSee($requireText)->assertSee($user2->name)
            ->assertSee('メールアドレス')->assertSee($requireText)->assertSee($user2->email)
            ->assertSee('ユーザー権限')->assertSee($requireText)->assertSee($user2->role_type)
            ->assertSee('パスワード')->assertSee($requireText)->assertDontSee($user2->password)
            ->assertSee('保存する');
    }

    /** @test */
    public function testExeEdit()
    {
        // 一旦スキップ
        $this->markTestIncomplete();

        $user = factory(User::class)->create();
        \Auth::loginUsingId($user->id);

        $editUser = factory(User::class)->create();

        $params = [
            'name'          => $this->faker()->name(),
            'email'         => $editUser->email,
            'password'      => $this->faker()->password($minLength=8, $maxLength=16),
            'role_type'     => 2,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];

        $url = url("admin/user/edit/$editUser->id");
        $response = $this->post($url, $params);
        $response->assertStatus(302);

        $checkUser = User::where('email', '=', $editUser->email)->first();
        $checkPassword = \Hash::check($params['password'], $checkUser->password);
        $this->assertTrue($checkPassword);
        $this->assertEquals($params['name'], $checkUser->name);
        $this->assertEquals($params['email'], $checkUser->email);
        $this->assertEquals($params['role_type'], $checkUser->role_type);
        $this->assertEquals($params['created_by'], $checkUser->created_by);
        $this->assertEquals($params['updated_by'], $checkUser->updated_by);

        $response->assertRedirect('admin/user');

        $redirectResponse = $this->get('admin/user');
        $redirectResponse->assertSee(config('messages.common.success'));
    }
}
