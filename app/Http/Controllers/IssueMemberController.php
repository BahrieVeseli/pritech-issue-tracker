<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageIssueMemberRequest;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IssueMemberController extends Controller
{
    public function store(ManageIssueMemberRequest $request, Issue $issue, User $user): JsonResponse
    {
        $issue->members()->syncWithoutDetaching([$user->id]);
        $issue->load(['members', 'project']);
        $members = User::orderBy('name')->get();

        return response()->json([
            'html' => view('issues.partials.members', compact('issue', 'members'))->render(),
        ]);
    }

    public function destroy(ManageIssueMemberRequest $request, Issue $issue, User $user): JsonResponse
    {
        $issue->members()->detach($user->id);
        $issue->load(['members', 'project']);
        $members = User::orderBy('name')->get();

        return response()->json([
            'html' => view('issues.partials.members', compact('issue', 'members'))->render(),
        ]);
    }
}
