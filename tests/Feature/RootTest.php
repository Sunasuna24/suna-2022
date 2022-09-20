<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RootTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function rootにアクセスするとTOP画面が表示される()
    {
        $this->get(route('top'))->assertViewIs('top');
    }

    /** @test */
    function 認証済みのユーザーはTOP画面にアクセスできない()
    {
        User::factory()->create();
        $user = User::find(1);
        $this->actingAs($user)->get(route('top'))->assertRedirect(route('home'));
    }
}
