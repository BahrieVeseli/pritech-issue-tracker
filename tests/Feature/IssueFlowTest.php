<?php

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;

test('issues search filters by status priority tag and search', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $tag = Tag::factory()->create(['name' => 'urgent']);

    $matchingIssue = Issue::factory()->create([
        'project_id' => $project->id,
        'title' => 'NEW ISSUE',
        'status' => 'open',
        'priority' => 'low',
    ]);
    $matchingIssue->tags()->attach($tag->id);

    Issue::factory()->create([
        'project_id' => $project->id,
        'title' => 'Other issue',
        'status' => 'closed',
        'priority' => 'high',
    ]);

    $response = $this->actingAs($user)->get('/issues/search?search=NEW%20ISSUE&status=open&priority=low&tag=' . $tag->id . '&ajax=1');

    $response->assertOk();
    $response->assertSee('NEW ISSUE');
    $response->assertDontSee('Other issue');
});

test('issue comments can be created via ajax endpoint', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id]);

    $response = $this->actingAs($user)->post("/issues/{$issue->id}/comments", [
        'author_name' => 'Jane Doe',
        'body' => 'Nice issue',
    ]);

    $response->assertCreated();

    $this->assertDatabaseHas('comments', [
        'issue_id' => $issue->id,
        'author_name' => 'Jane Doe',
        'body' => 'Nice issue',
    ]);
});

test('tags can be attached and detached from an issue', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id]);
    $tag = Tag::factory()->create(['name' => 'backend']);

    $attachResponse = $this->actingAs($user)->post("/issues/{$issue->id}/tags/{$tag->id}");
    $attachResponse->assertOk();
    $this->assertDatabaseHas('issue_tag', [
        'issue_id' => $issue->id,
        'tag_id' => $tag->id,
    ]);

    $detachResponse = $this->actingAs($user)->delete("/issues/{$issue->id}/tags/{$tag->id}");
    $detachResponse->assertOk();
    $this->assertDatabaseMissing('issue_tag', [
        'issue_id' => $issue->id,
        'tag_id' => $tag->id,
    ]);
});

test('tags manager endpoint returns the selected issue tags', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id, 'title' => 'Tagged issue']);
    $tag = Tag::factory()->create(['name' => 'ui']);
    $issue->tags()->attach($tag->id);

    $response = $this->actingAs($user)->get("/issues/{$issue->id}/tags-manager");

    $response->assertOk();
    $response->assertSee('Tagged issue');
    $response->assertSee('ui');
});

test('a tag can be created with an optional issue attachment', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id]);

    $response = $this->actingAs($user)->post('/tags', [
        'name' => 'frontend',
        'color' => '#ff6600',
        'issue_id' => $issue->id,
    ]);

    $response->assertRedirect(route('tags.index', ['issue_id' => $issue->id]));

    $tag = Tag::where('name', 'frontend')->first();

    expect($tag)->not->toBeNull();
    $this->assertDatabaseHas('issue_tag', [
        'issue_id' => $issue->id,
        'tag_id' => $tag->id,
    ]);
});

test('a tag can be created without attaching to an issue', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/tags', [
        'name' => 'standalone',
        'color' => '#123456',
    ]);

    $response->assertRedirect(route('tags.index'));

    $tag = Tag::where('name', 'standalone')->first();

    expect($tag)->not->toBeNull();
    $this->assertDatabaseMissing('issue_tag', [
        'tag_id' => $tag->id,
    ]);
});

test('tag detail page shows attached issues', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $issue = Issue::factory()->create([
        'project_id' => $project->id,
        'title' => 'Frontend issue',
    ]);
    $tag = Tag::factory()->create(['name' => 'ui']);
    $tag->issues()->attach($issue->id);

    $response = $this->actingAs($user)->get("/tags/{$tag->id}");

    $response->assertOk();
    $response->assertSee('Attached issues');
    $response->assertSee('Frontend issue');
    $response->assertSee('Detach');
});

test('tag detail page can attach and detach issues via ajax', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $user->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id, 'title' => 'Backend task']);
    $tag = Tag::factory()->create(['name' => 'backend']);

    $attachResponse = $this->actingAs($user)->post("/tags/{$tag->id}/issues/{$issue->id}");
    $attachResponse->assertOk();
    expect($attachResponse->json('html'))->toContain('Backend task');
    expect($attachResponse->json('html'))->toContain('Detach');

    $this->assertDatabaseHas('issue_tag', [
        'issue_id' => $issue->id,
        'tag_id' => $tag->id,
    ]);

    $detachResponse = $this->actingAs($user)->delete("/tags/{$tag->id}/issues/{$issue->id}");
    $detachResponse->assertOk();
    expect($detachResponse->json('html'))->toContain('No issues attached yet.');

    $this->assertDatabaseMissing('issue_tag', [
        'issue_id' => $issue->id,
        'tag_id' => $tag->id,
    ]);
});

test('project owner can attach and detach issue members via ajax', function () {
    $owner = User::factory()->create();
    $member = User::factory()->create(['name' => 'Team Member']);
    $project = Project::factory()->create(['owner_id' => $owner->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id, 'title' => 'Member issue']);

    $attachResponse = $this->actingAs($owner)->post("/issues/{$issue->id}/members/{$member->id}");
    $attachResponse->assertOk();
    expect($attachResponse->json('html'))->toContain('Team Member');
    expect($attachResponse->json('html'))->toContain('Attach member');

    $this->assertDatabaseHas('issue_user', [
        'issue_id' => $issue->id,
        'user_id' => $member->id,
    ]);

    $detachResponse = $this->actingAs($owner)->delete("/issues/{$issue->id}/members/{$member->id}");
    $detachResponse->assertOk();
    expect($detachResponse->json('html'))->toContain('No members assigned.');

    $this->assertDatabaseMissing('issue_user', [
        'issue_id' => $issue->id,
        'user_id' => $member->id,
    ]);
});

test('non owner cannot manage issue members', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $member = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $owner->id]);
    $issue = Issue::factory()->create(['project_id' => $project->id]);

    $this->actingAs($otherUser)->post("/issues/{$issue->id}/members/{$member->id}")
        ->assertForbidden();

    $this->actingAs($otherUser)->delete("/issues/{$issue->id}/members/{$member->id}")
        ->assertForbidden();
});
