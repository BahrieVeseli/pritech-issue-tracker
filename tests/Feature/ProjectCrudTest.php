<?php

use App\Models\Project;
use App\Models\User;

test('authenticated user can create a project', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/projects', [
        'name' => 'Alpha Project',
        'description' => 'Project description',
        'start_date' => '2026-06-01',
        'deadline' => '2026-07-01',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('projects', [
        'name' => 'Alpha Project',
        'owner_id' => $user->id,
    ]);
});

test('project owner can update their project', function () {
    $owner = User::factory()->create();
    $project = Project::factory()->create([
        'owner_id' => $owner->id,
    ]);

    $response = $this->actingAs($owner)->put("/projects/{$project->id}", [
        'name' => 'Updated Project',
        'description' => 'Updated description',
        'start_date' => '2026-06-10',
        'deadline' => '2026-07-10',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'name' => 'Updated Project',
    ]);
});
