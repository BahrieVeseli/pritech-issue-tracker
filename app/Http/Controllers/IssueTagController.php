<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueTagController extends Controller
{
    public function manager(Issue $issue): JsonResponse
    {
        $issue->load('tags');
        $tags = Tag::orderBy('name')->get();

        return response()->json([
            'html' => view('issues.partials.tags-manager', compact('issue', 'tags'))->render(),
        ]);
    }

    public function store(Request $request, Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->syncWithoutDetaching([$tag->id]);
        $issue->load('tags');
        $tags = Tag::orderBy('name')->get();

        return response()->json([
            'html' => view('issues.partials.tags-manager', compact('issue', 'tags'))->render(),
        ]);
    }

    public function destroy(Issue $issue, Tag $tag): JsonResponse
    {
        $issue->tags()->detach($tag->id);
        $issue->load('tags');
        $tags = Tag::orderBy('name')->get();

        return response()->json([
            'html' => view('issues.partials.tags-manager', compact('issue', 'tags'))->render(),
        ]);
    }
}
