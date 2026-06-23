<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unauthenticated users are redirected to login.
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Authenticated users can view their own tasks on dashboard.
     */
    public function test_authenticated_user_can_view_tasks(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Test Task',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('My Test Task');
    }

    /**
     * Users cannot see other users' tasks.
     */
    public function test_user_cannot_view_other_users_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $taskB = Task::factory()->create([
            'user_id' => $userB->id,
            'title' => 'Task of User B',
        ]);

        $response = $this->actingAs($userA)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertDontSee('Task of User B');
    }

    /**
     * Users can create new tasks.
     */
    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'New Unique Task',
            'description' => 'A descriptive text here',
            'priority' => 'high',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'New Unique Task',
            'priority' => 'high',
        ]);
    }

    /**
     * Task title is required.
     */
    public function test_task_creation_validation_rules(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => '',
            'priority' => 'invalid-priority',
            'due_date' => now()->subDay()->format('Y-m-d'), // due date in past
        ]);

        $response->assertSessionHasErrors(['title', 'priority', 'due_date']);
    }

    /**
     * Users can view details of their tasks as JSON.
     */
    public function test_user_can_view_task_details_json(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Detail Task',
        ]);

        $response = $this->actingAs($user)->get("/tasks/{$task->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $task->id,
            'title' => 'Detail Task',
        ]);
    }

    /**
     * Users cannot view other users' tasks details.
     */
    public function test_user_cannot_view_other_users_task_details(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $taskB = Task::factory()->create([
            'user_id' => $userB->id,
        ]);

        $response = $this->actingAs($userA)->get("/tasks/{$taskB->id}");

        $response->assertStatus(403);
    }

    /**
     * Users can update their tasks.
     */
    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Old Title',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated desc',
            'priority' => 'low',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => 'completed',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'status' => 'completed',
        ]);
    }

    /**
     * Users cannot update other users' tasks.
     */
    public function test_user_cannot_update_other_users_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $taskB = Task::factory()->create([
            'user_id' => $userB->id,
            'title' => 'B Title',
        ]);

        $response = $this->actingAs($userA)->put("/tasks/{$taskB->id}", [
            'title' => 'Hack Attempt',
            'priority' => 'high',
            'status' => 'completed',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', [
            'id' => $taskB->id,
            'title' => 'B Title',
        ]);
    }

    /**
     * Users can delete their own tasks.
     */
    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    /**
     * Users cannot delete other users' tasks.
     */
    public function test_user_cannot_delete_other_users_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $taskB = Task::factory()->create([
            'user_id' => $userB->id,
        ]);

        $response = $this->actingAs($userA)->delete("/tasks/{$taskB->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', [
            'id' => $taskB->id,
        ]);
    }

    /**
     * Users can toggle task status via PATCH toggle endpoint.
     */
    public function test_user_can_toggle_task_status(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'completed_at' => null,
        ]);

        // Toggle to completed
        $response = $this->actingAs($user)->patch("/tasks/{$task->id}/toggle");
        $response->assertRedirect();
        
        $task->refresh();
        $this->assertEquals('completed', $task->status);
        $this->assertNotNull($task->completed_at);

        // Toggle back to pending
        $this->actingAs($user)->patch("/tasks/{$task->id}/toggle");
        $task->refresh();
        $this->assertEquals('pending', $task->status);
        $this->assertNull($task->completed_at);
    }

    /**
     * Users can filter tasks by status.
     */
    public function test_user_can_filter_tasks_by_status(): void
    {
        $user = User::factory()->create();
        $pendingTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Pending Task',
            'status' => 'pending',
        ]);
        $completedTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Completed Task',
            'status' => 'completed',
        ]);

        // Filter by completed
        $response = $this->actingAs($user)->get('/dashboard?status=completed');
        $response->assertSee('Completed Task');
        $response->assertDontSee('Pending Task');

        // Filter by pending
        $response = $this->actingAs($user)->get('/dashboard?status=pending');
        $response->assertSee('Pending Task');
        $response->assertDontSee('Completed Task');
    }

    /**
     * Users can filter tasks by priority.
     */
    public function test_user_can_filter_tasks_by_priority(): void
    {
        $user = User::factory()->create();
        $highTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'High Priority Task',
            'status' => 'pending',
            'priority' => 'high',
        ]);
        $lowTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Low Priority Task',
            'status' => 'pending',
            'priority' => 'low',
        ]);

        $response = $this->actingAs($user)->get('/dashboard?priority=high');
        $response->assertSee('High Priority Task');
        $response->assertDontSee('Low Priority Task');
    }

    /**
     * Users can search tasks.
     */
    public function test_user_can_search_tasks(): void
    {
        $user = User::factory()->create();
        $matchTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Find Me Task',
            'status' => 'pending',
        ]);
        $otherTask = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Ignore Task',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/dashboard?search=Find+Me');
        $response->assertSee('Find Me Task');
        $response->assertDontSee('Ignore Task');
    }

    /**
     * Users can sort tasks by priority and due date.
     */
    public function test_user_can_sort_tasks(): void
    {
        $user = User::factory()->create();
        
        $taskLow = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Low Priority Sort',
            'status' => 'pending',
            'priority' => 'low',
            'due_date' => '2026-07-02',
        ]);
        $taskHigh = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'High Priority Sort',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => '2026-07-01',
        ]);

        // Priority sort ascending (high should be first, i.e. high=1, medium=2, low=3)
        $response = $this->actingAs($user)->get('/dashboard?sort_by=priority&sort_order=asc');
        $response->assertSeeInOrder(['High Priority Sort', 'Low Priority Sort']);

        // Priority sort descending
        $response = $this->actingAs($user)->get('/dashboard?sort_by=priority&sort_order=desc');
        $response->assertSeeInOrder(['Low Priority Sort', 'High Priority Sort']);

        // Due date sort
        $response = $this->actingAs($user)->get('/dashboard?sort_by=due_date&sort_order=asc');
        $response->assertSeeInOrder(['High Priority Sort', 'Low Priority Sort']);
    }
}

