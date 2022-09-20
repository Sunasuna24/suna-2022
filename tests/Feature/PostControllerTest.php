<?php

namespace Tests\Feature;

use App\Models\Post;
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
    function 不備があるとエラーメッセージが出力される()
    {
        User::factory()->create();
        $user = User::first();

        // タイトル周り
        $this->actingAs($user)->post(route('post.create'), ['title' => null])->assertInvalid(['title' => '必ず指定']);
        $this->actingAs($user)->get(route('post.create'))->assertSee('必ず指定');
        $this->actingAs($user)->post(route('post.create'), ['title' => null, 'body' => 'Dummy body!'])->assertInvalid(['title' => '必ず指定']);
        $this->actingAs($user)->get(route('post.create'))->assertSee('必ず指定')->assertSee('Dummy body!');
        $this->actingAs($user)->post(route('post.create'), ['title' => str_repeat('a', 256)])->assertInvalid(['title' => '文字以下で指定']);
        $this->actingAs($user)->get(route('post.create'))->assertSee('文字以下で指定')->assertSee(str_repeat('a', 256));
        $this->actingAs($user)->post(route('post.create'), ['title' => str_repeat('a', 255)])->assertValid(['title']);

        // 本文周り
        $this->actingAs($user)->post(route('post.create'), ['body' => null])->assertInvalid(['body' => '必ず指定']);
        $this->actingAs($user)->get(route('post.create'))->assertSee('必ず指定');

        // ステータス周り
        $this->actingAs($user)->post(route('post.create'), ['status' => 'Hello, world!'])->assertInvalid(['status' => '数字を指定']);
        $this->actingAs($user)->get(route('post.create'))->assertSee('数字を指定');
        $this->actingAs($user)->post(route('post.create'), ['status' => '4'])->assertInvalid(['status' => 'の間で指定']);
        $this->actingAs($user)->get(route('post.create'))->assertSee('の間で指定');
        $this->actingAs($user)->post(route('post.create'), ['status' => '1'])->assertValid(['status']);
        $this->actingAs($user)->post(route('post.create'), ['status' => 0])->assertValid(['status']);
    }

    /** @test */
    function 実際に記事が保存される()
    {
        User::factory()->create();
        $user = User::first();
        $validPostData = [
            'user_id' => $user->id,
            'title' => 'TestTitle',
            'body' => 'This is a sample post for testing this application.',
            'status' => '1'
        ];

        $this->actingAs($user)->post(route('post.create'), $validPostData);

        $post = Post::first();
        $this->assertModelExists($post);
    }

    /** @test */
    function 記事が保存されたら記事の詳細画面にリダイレクトされる()
    {
        $this->withoutExceptionHandling();
        User::factory()->create();
        $user = User::first();
        $validPostData = [
            'user_id' => $user->id,
            'title' => 'TestTitle',
            'body' => 'This is a sample post for testing this application.',
            'status' => '1'
        ];

        $this->actingAs($user)->post(route('post.create'), $validPostData);
        $this->assertDatabaseCount('posts', Post::count());
    }
}
