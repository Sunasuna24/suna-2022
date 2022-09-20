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
}
