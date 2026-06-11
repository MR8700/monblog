<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostTagRequest;
use App\Http\Resources\PostTagResource;
use App\Models\PostTag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminTagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lister tous les tags
     */
    public function index(): View
    {
        $tags = PostTag::withCount('posts')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        return view('admin.tags.create');
    }

    /**
     * Sauvegarder un tag
     */
    public function store(PostTagRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        PostTag::create($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag créé avec succès !');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(PostTag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Mettre à jour un tag
     */
    public function update(PostTagRequest $request, PostTag $tag): RedirectResponse
    {
        $validated = $request->validated();

        $tag->update($validated);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag mis à jour avec succès !');
    }

    /**
     * Supprimer un tag
     */
    public function destroy(PostTag $tag): RedirectResponse
    {
        $tag->delete();

        return back()->with('success', 'Tag supprimé avec succès.');
    }
}
