<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueCommentController extends Controller
{
    public function index(Request $request, Issue $issue): JsonResponse
    {
        $comments = $issue->comments()->latest()->paginate(5);

        return response()->json([
            'html' => view('comments.partials.list', compact('comments'))->render(),
            'has_more' => $comments->hasMorePages(),
            'next_page' => $comments->nextPageUrl(),
        ]);
    }

    public function store(StoreCommentRequest $request, Issue $issue): JsonResponse
    {
        $comment = $issue->comments()->create($request->validated());

        return response()->json([
            'html' => view('comments.partials.item', compact('comment'))->render(),
            'message' => 'Comment added successfully.',
        ], 201);
    }
}
