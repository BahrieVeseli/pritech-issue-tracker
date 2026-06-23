<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagIssueController extends Controller
{
    public function manager(Tag $tag): JsonResponse
    {
        [$tag, $availableIssues] = $this->loadTagData($tag);

        return response()->json([
            'html' => view('tags.partials.detail', compact('tag', 'availableIssues'))->render(),
        ]);
    }

    public function store(Tag $tag, Issue $issue): JsonResponse
    {
        $tag->issues()->syncWithoutDetaching([$issue->id]);

        return $this->manager($tag);
    }

    public function destroy(Tag $tag, Issue $issue): JsonResponse
    {
        $tag->issues()->detach($issue->id);

        return $this->manager($tag);
    }

    private function loadTagData(Tag $tag): array
    {
        $tag->load(['issues.project']);
        $availableIssues = Issue::with('project')
            ->orderBy('title')
            ->get()
            ->reject(fn (Issue $issue) => $tag->issues->contains('id', $issue->id))
            ->values();

        return [$tag, $availableIssues];
    }
}
