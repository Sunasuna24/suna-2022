<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

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
