<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VeryFirstTest extends TestCase
{
    /** @test */
    public function very_first_test()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertTrue(false);
    }
}
