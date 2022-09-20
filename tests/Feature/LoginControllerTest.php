<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function リンクをクリックするとログイン画面が表示される()
    {
        $this->get(route('login'))->assertOk()->assertViewIs('auth.login');
    }

    /** @test */
    function データに不備があったらフラッシュが表示される()
    {
        $this->post(route('login'), ['email' => null])->assertInvalid(['email' => '必ず指定']);
        $this->post(route('login'), ['password' => null])->assertInvalid(['password' => '必ず指定']);
    }

    /** @test */
    function 正常にログインされる()
    {
        User::factory()->create(['password' => Hash::make('password')]);
        $user = User::first();

        $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function 誤った認証情報で元の画面にリダイレクトされる()
    {
        User::factory()->create(['password' => Hash::make('password')]);
        $user = User::first();

        $this->from(route('login'))->post(route('login'), ['email' => $user->email, 'password' => 'otherText'])->assertRedirect(route('login'));
        $this->get(route('login'))->assertSee('認証情報が正しくありません。')->assertSee($user->email);
    }

    /** @test */
    function ログアウトボタンを押すとWebサイトからログアウトする()
    {
        User::factory()->create();
        $user = User::first();

        $this->actingAs($user)->post(route('logout'), [])->assertRedirect(route('top'));
        $this->assertGuest();
    }

    /** @test */
    function ゲストのアクセスを禁止する()
    {
        $this->post(route('logout'), [])->assertRedirect(route('login'));
    }
}
