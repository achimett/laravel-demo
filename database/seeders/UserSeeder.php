<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(10)
            ->has(Post::factory()->count(10))
            ->has(Comment::factory()->count(20))
            ->create();

        User::factory()
            ->count(1)
            ->state(['role' => 'ADMIN'])
            ->create();
    }
}
