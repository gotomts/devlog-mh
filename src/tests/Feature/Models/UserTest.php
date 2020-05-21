<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function testGetById()
    {
        $user = factory(User::class)->create();
        $this->assertInstanceOf(User::class, User::getById($user->id));
        $testUser = User::getById($user->id);
        $this->assertEquals($user->id, $testUser->id);
        $this->assertEquals($user->name, $testUser->name);
        $this->assertEquals($user->email, $testUser->email);
        $this->assertEquals($user->password, $testUser->password);
        $this->assertEquals($user->role_type, $testUser->role_type);
        $this->assertEquals($user->remember_token, $testUser->remember_token);
        $this->assertEquals($user->created_by, $testUser->created_by);
        $this->assertEquals($user->updated_by, $testUser->updated_by);
        $this->assertEquals($user->deleted_by, $testUser->deleted_by);
        $this->assertEquals($user->created_at, $testUser->created_at);
        $this->assertEquals($user->updated_at, $testUser->updated_at);
        $this->assertEquals($user->deleted_at, $testUser->deleted_at);
    }

    /** @test */
    public function testGetAll()
    {
        $createUsers = 20;
        factory(User::class, $createUsers)->create();

        // 取得できたオブジェクトの確認
        $users = User::getAll();
        $this->assertInstanceOf(LengthAwarePaginator::class, $users);

        // 作成したレコード数と取得したレコードの数が一致するか
        $this->assertEquals($createUsers, $users->total());

        // 1ページあたりの表示数は指定どおりか
        $this->assertEquals(config('pagination.items'), $users->perPage());
    }

    /** @test */
    public function testInsert()
    {
        $user = factory(User::class)->create();
        $params = [
            'name'          => $this->faker()->name(),
            'email'         => $this->faker()->safeEmail(),
            'password'      => $this->faker()->password(),
            'role_type'     => 1,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];
        $result = User::insert($params);
        $this->assertInstanceOf(User::class, $result);

        $checkUser = User::where('email', '=', $params['email'])->first();
        $checkPassword = \Hash::check($params['password'], $checkUser->password);
        $this->assertTrue($checkPassword);
        $this->assertEquals($params['name'], $checkUser->name);
        $this->assertEquals($params['email'], $checkUser->email);
        $this->assertEquals($params['role_type'], $checkUser->role_type);
        $this->assertEquals($params['created_by'], $checkUser->created_by);
        $this->assertEquals($params['updated_by'], $checkUser->updated_by);
    }

    /** @test */
    public function testUpdateById()
    {
        $user = factory(User::class)->create();
        $updateUser = factory(User::class)->create();
        $params = [
            'email'         => $this->faker()->safeEmail(),
            'password'      => $this->faker()->password(),
            'role_type'     => 2,
            'created_by'    => $user->id,
            'updated_by'    => $user->id,
        ];
        $result = User::updateById($updateUser->id, $params);
        $this->assertTrue($result);
        $checkUser = User::where('email', '=', $params['email'])->first();
        $checkPassword = \Hash::check($params['password'], $checkUser->password);
        $this->assertTrue($checkPassword);
        $this->assertEquals($params['email'], $checkUser->email);
        $this->assertEquals($params['role_type'], $checkUser->role_type);
        $this->assertEquals($params['created_by'], $checkUser->created_by);
        $this->assertEquals($params['updated_by'], $checkUser->updated_by);
    }
}
