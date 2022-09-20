<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function 会員登録の画面が表示される()
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertViewIs('auth.register')
            ->assertSee('会員登録');
    }

    /** @test */
    function フォームに不備があったら元の画面にリダイレクトされる()
    {
        $existing_user = User::factory()->create();

        // ユーザー名周り
        $this->from(route('register'))->post(route('register'), ['username' => null])
            ->assertInvalid(['username' => '必ず指定']);
        $this->from(route('register'))->post(route('register'), ['username' => str_repeat('7', 7)])
            ->assertInvalid(['username' => '8文字以上']);
        $this->from(route('register'))->post(route('register'), ['username' => str_repeat('8', 8)])
            ->assertValid('username');

        // メアド周り
        $this->from(route('register'))->post(route('register'), ['email' => null])
            ->assertInvalid(['email' => '必ず指定']);
        $this->from(route('register'))->post(route('register'), ['email' => 'testUser@email@again.com'])
            ->assertInvalid(['email' => '有効なメールアドレス']);
        $this->from(route('register'))->post(route('register'), ['email' => $existing_user->email])
            ->assertInvalid(['email' => '既に存在']);

        // パスワード周り
        $this->from(route('register'))->post(route('register'),  ['password' => null])
            ->assertInvalid(['password' => '必ず指定']);
        $this->from(route('register'))->post(route('register'), ['password' => str_repeat('7', 7)])
            ->assertInvalid(['password' => '8文字以上']);
        $this->from(route('register'))->post(route('register'), ['password' => 'password', 'password_confirmation' => 'password1'])
            ->assertInvalid(['password' => '一致']);
        $this->from(route('register'))->post(route('register'), ['password' => 'validPassword', 'password_confirmation' => 'validPassword'])
            ->assertValid('password');
    }

    /** @test */
    function 正常にDBに登録される()
    {
        $validUserData = [
            'username' => 'tesingUser',
            'email' => 'testingUser@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $this->post(route('register'), $validUserData);

        $this->assertDatabaseHas('users', [
            'name' => $validUserData['username'],
            'email' => $validUserData['email']
        ]);

        $users = User::where('email', $validUserData['email'])->get();
        $this->assertTrue(count($users) === 1);
    }

    /** @test */
    function 登録したユーザーでそのままログインされる()
    {
        $validUserData = [
            'username' => 'tesingUser',
            'email' => 'testingUser@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $this->post(route('register'), $validUserData);

        $user = User::find(1);

        $this->assertAuthenticatedAs($user);
    }
}
