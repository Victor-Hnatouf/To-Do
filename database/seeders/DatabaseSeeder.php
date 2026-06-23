<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the default test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Seed tasks for test user
        // 1. Overdue tasks
        \App\Models\Task::factory(3)->create([
            'user_id' => $testUser->id,
            'status' => 'pending',
            'due_date' => now()->subDays(rand(1, 5))->format('Y-m-d'),
        ]);

        // 2. Tasks due today
        \App\Models\Task::factory(3)->create([
            'user_id' => $testUser->id,
            'status' => 'pending',
            'due_date' => now()->format('Y-m-d'),
        ]);

        // 3. Tasks due tomorrow / future
        \App\Models\Task::factory(5)->create([
            'user_id' => $testUser->id,
            'due_date' => now()->addDays(rand(1, 10))->format('Y-m-d'),
        ]);

        // 4. Completed tasks
        \App\Models\Task::factory(4)->create([
            'user_id' => $testUser->id,
            'status' => 'completed',
            'completed_at' => now()->subHours(rand(1, 24)),
        ]);

        // Create other random users with tasks (verifying scoping)
        User::factory(3)->create()->each(function ($user) {
            \App\Models\Task::factory(5)->create(['user_id' => $user->id]);
        });
    }
}
