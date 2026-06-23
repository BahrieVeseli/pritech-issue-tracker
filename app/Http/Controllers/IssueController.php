<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $issues = $this->issueQuery($request)->paginate(10)->withQueryString();
        $projects = Project::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        if ($request->boolean('ajax') || $request->wantsJson()) {
            return response()->json([
                'html' => view('issues.partials.results', compact('issues'))->render(),
            ]);
        }

        return view('issues.index', compact('issues', 'projects', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $projects = Project::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $members = User::orderBy('name')->get();

        return view('issues.create', compact('projects', 'tags', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $issue = Issue::create($request->validated());

        $issue->tags()->sync($request->input('tag_ids', []));
        $issue->members()->sync($request->input('member_ids', []));

        return redirect()->route('issues.show', $issue)->with('success', 'Issue created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Issue $issue): View
    {
        $issue->load(['project', 'tags', 'members']);
        $tags = Tag::orderBy('name')->get();
        $members = User::orderBy('name')->get();

        return view('issues.show', compact('issue', 'tags', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Issue $issue): View
    {
        $projects = Project::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $members = User::orderBy('name')->get();
        $issue->load(['tags', 'members']);

        return view('issues.edit', compact('issue', 'projects', 'tags', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());
        $issue->tags()->sync($request->input('tag_ids', []));
        $issue->members()->sync($request->input('member_ids', []));

        return redirect()->route('issues.show', $issue)->with('success', 'Issue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()->route('issues.index')->with('success', 'Issue deleted successfully.');
    }

    public function search(Request $request): JsonResponse
    {
        $issues = $this->issueQuery($request)->paginate(10)->withQueryString();

        return response()->json([
            'html' => view('issues.partials.results', compact('issues'))->render(),
        ]);
    }

    private function issueQuery(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $status = trim((string) $request->input('status', ''));
        $priority = trim((string) $request->input('priority', ''));
        $tagId = (int) $request->input('tag');

        return Issue::query()
            ->with(['project', 'tags', 'members'])
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($priority !== '', fn ($query) => $query->where('priority', $priority))
            ->when($tagId > 0, fn ($query) => $query->whereHas('tags', fn ($tagQuery) => $tagQuery->whereKey($tagId)))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });
    }
}
