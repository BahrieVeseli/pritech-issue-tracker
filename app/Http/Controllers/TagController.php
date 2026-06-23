<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tags = Tag::withCount('issues')->latest()->paginate(10);
        $issues = Issue::with(['tags', 'project'])->orderBy('title')->get();

        return view('tags.index', compact('tags', 'issues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('tags.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $tag = Tag::create([
            'name' => $validated['name'],
            'color' => $validated['color'] ?? null,
        ]);

        if (! empty($validated['issue_id'])) {
            $issue = Issue::findOrFail($validated['issue_id']);
            $issue->tags()->syncWithoutDetaching([$tag->id]);
        }

        if (! empty($validated['issue_id'])) {
            return redirect()
                ->route('tags.index', ['issue_id' => $validated['issue_id']])
                ->with('success', 'Tag created successfully.');
        }

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): View
    {
        [$tag, $availableIssues] = $this->loadTagData($tag);

        return view('tags.show', compact('tag', 'availableIssues'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
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
