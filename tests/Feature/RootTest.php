<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RootTest extends TestCase
{
    /** @test */
    function rootにアクセスするとTOP画面が表示される()
    {
        // $this->get(route('top'))->assertViewIs('top');
        $this->get('/')->assertOk();
    }
}
