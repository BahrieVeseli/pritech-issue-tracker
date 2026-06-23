<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
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
        $owner = User::factory()->create([
            'name' => 'Project Owner',
            'email' => 'owner@example.com',
        ]);

        $member = User::factory()->create([
            'name' => 'Team Member',
            'email' => 'member@example.com',
        ]);

        $tags = collect([
            Tag::factory()->create(['name' => 'Bug', 'color' => '#ef4444']),
            Tag::factory()->create(['name' => 'Feature', 'color' => '#3b82f6']),
            Tag::factory()->create(['name' => 'Backend', 'color' => '#10b981']),
            Tag::factory()->create(['name' => 'Frontend', 'color' => '#8b5cf6']),
            Tag::factory()->create(['name' => 'Urgent', 'color' => '#f59e0b']),
            Tag::factory()->create(['name' => 'Design', 'color' => '#ec4899']),
        ]);

        $projects = collect([
            Project::factory()->create([
                'name' => 'Atlas Portal',
                'description' => 'Customer portal and internal dashboard.',
                'owner_id' => $owner->id,
            ]),
            Project::factory()->create([
                'name' => 'Nova Admin',
                'description' => 'Administration tools for the support team.',
                'owner_id' => $owner->id,
            ]),
            Project::factory()->create([
                'name' => 'Beacon Mobile',
                'description' => 'Mobile app for field operations.',
                'owner_id' => $owner->id,
            ]),
        ]);

        $issueTemplates = [
            ['title' => 'Login page validation', 'status' => 'open', 'priority' => 'high'],
            ['title' => 'Improve project summary cards', 'status' => 'in_progress', 'priority' => 'medium'],
            ['title' => 'Fix tag filter edge case', 'status' => 'open', 'priority' => 'low'],
            ['title' => 'Add comment pagination', 'status' => 'closed', 'priority' => 'medium'],
        ];

        $projects->each(function (Project $project) use ($tags, $member, $issueTemplates) {
            foreach ($issueTemplates as $template) {
                $issue = Issue::factory()->create([
                    'project_id' => $project->id,
                    'title' => $template['title'] . ' - ' . $project->name,
                    'status' => $template['status'],
                    'priority' => $template['priority'],
                ]);

                $issue->tags()->attach($tags->random(rand(1, 3))->pluck('id')->all());
                $issue->members()->attach([$member->id]);

                Comment::factory()->count(2)->create([
                    'issue_id' => $issue->id,
                ]);
            }
        });
    }
}
