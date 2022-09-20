<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function postにアクセスすると投稿画面が表示される()
    {
        $this->get(route('post.create'))->assertRedirect(route('login'));

        User::factory()->create();
        $user = User::first();

        $this->actingAs($user)->get(route('post.create'))->assertOk()->assertViewIs('post');
    }

    /** @test */
    function 不備があると元の画面に戻される()
    {
        User::factory()->create();
        $user = User::first();

        // タイトル周り
        $this->actingAs($user)->post(route('post.create'), ['title' => null])->assertInvalid(['title' => '必ず指定']);
        $this->actingAs($user)->post(route('post.create'), ['title' => str_repeat('a', 256)])->assertInvalid(['title' => '文字以下で指定']);
        $this->actingAs($user)->post(route('post.create'), ['title' => str_repeat('a', 255)])->assertValid(['title']);

        // 本文周り
        $this->actingAs($user)->post(route('post.create'), ['body' => null])->assertInvalid(['body' => '必ず指定']);

        // ステータス周り
        $this->actingAs($user)->post(route('post.create'), ['status' => 'Hello, world!'])->assertInvalid(['status' => '数字を指定']);
        $this->actingAs($user)->post(route('post.create'), ['status' => '4'])->assertInvalid(['status' => 'の間で指定']);
        $this->actingAs($user)->post(route('post.create'), ['status' => '1'])->assertValid(['status']);
        $this->actingAs($user)->post(route('post.create'), ['status' => 0])->assertValid(['status']);
    }

    /** @test */
    function 実際に記事が保存される()
    {
        //
    }
}
