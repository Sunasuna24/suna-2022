<?php

namespace Tests\Feature;

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
        $this->from(route('register'))->post(route('register'), [])->assertRedirect(route('register'));
    }
}