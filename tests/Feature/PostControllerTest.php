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

        $response = $this->actingAs($user)->post(route('post.create'), $validPostData);
        $post = Post::first();
        $response->assertRedirect(route('post.show', $post->id));
        $this->assertDatabaseHas('posts', $validPostData);
    }

    /** @test */
    function 内容と一緒に詳細画面が表示される()
    {
        $post = Post::factory()->create();

        $this->get(route('post.show', $post->id))->assertRedirect(route('login'));

        User::factory()->create();
        $user = User::first();

        $this->actingAs($user)->get(route('post.show', $post->id))
            ->assertOk()
            ->assertViewIs('detail')
            ->assertSee($post->title)
            ->assertSee($post->body);
    }

    /** @test */
    function バリデーション()
    {
        User::factory()->create();
        $user = User::first();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // タイトル周り
        $this->actingAs($user)->post(route('post.show', $post->id), ['title' => null])->assertInvalid(['title' => '必ず指定']);
        $this->actingAs($user)->get(route('post.show', $post->id))->assertSee('必ず指定');
        $this->actingAs($user)->post(route('post.show', $post->id), ['title' => null, 'body' => 'Dummy body!'])->assertInvalid(['title' => '必ず指定']);
        $this->actingAs($user)->get(route('post.show', $post->id))->assertSee('必ず指定')->assertSee('Dummy body!');
        $this->actingAs($user)->post(route('post.show', $post->id), ['title' => str_repeat('a', 256)])->assertInvalid(['title' => '文字以下で指定']);
        $this->actingAs($user)->get(route('post.show', $post->id))->assertSee('文字以下で指定')->assertSee(str_repeat('a', 256));
        $this->actingAs($user)->post(route('post.show', $post->id), ['title' => str_repeat('a', 255)])->assertValid(['title']);

        // 本文周り
        $this->actingAs($user)->post(route('post.show', $post->id), ['body' => null])->assertInvalid(['body' => '必ず指定']);
        $this->actingAs($user)->get(route('post.show', $post->id))->assertSee('必ず指定');

        // ステータス周り
        $this->actingAs($user)->post(route('post.show', $post->id), ['status' => 'Hello, world!'])->assertInvalid(['status' => '数字を指定']);
        $this->actingAs($user)->get(route('post.show', $post->id))->assertSee('数字を指定');
        $this->actingAs($user)->post(route('post.show', $post->id), ['status' => '4'])->assertInvalid(['status' => 'の間で指定']);
        $this->actingAs($user)->get(route('post.show', $post->id))->assertSee('の間で指定');
        $this->actingAs($user)->post(route('post.show', $post->id), ['status' => '1'])->assertValid(['status']);
        $this->actingAs($user)->post(route('post.show', $post->id), ['status' => 0])->assertValid(['status']);
    }

    /** @test */
    function 自分の記事を編集する()
    {
        User::factory()->create();
        $user = User::first();

        $previous_content = [
            'user_id' => $user->id,
            'title' => 'Previous Title',
            'body' => 'This is previous post. It will be changed afterwars.',
            'status' => '1'
        ];
        $post = Post::factory()->create($previous_content);

        $following_content = [
            'user_id' => $user->id,
            'title' => 'Following Title',
            'body' => 'This is the following post. It is already changed.',
            'status' => '0'
        ];

        $this->post(route('post.show', $post->id), $following_content)->assertRedirect(route('login'));

        $this->actingAs($user)->post(route('post.show', $post->id), $following_content)->assertRedirect(route('post.show', $post->id));
        $this->assertDatabaseMissing('posts', $previous_content)->assertDatabaseHas('posts', $following_content);
    }

    /** @test */
    function z他人の記事は編集できない()
    {
        [$me, $other] = User::factory(2)->create();
        $other_post = Post::factory()->create(['user_id' => $other->id]);

        $this->actingAs($me)->post(route('post.show', $other_post->id), [])->assertForbidden();
    }
}
