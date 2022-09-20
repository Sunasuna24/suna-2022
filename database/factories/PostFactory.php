<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->title(),
            'body' => fake()->realText(),
            'status' => Post::PUBLISH
        ];
    }

    /**
     * 非公開の記事を作成する
     * 
     * @return static
     */
    public function draft()
    {
        return $this->state(fn (array $attributes) => [
            'status' => Post::DRAFT
        ]);
    }
}
