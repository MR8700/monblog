<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCategoryRequest;
use App\Http\Resources\PostCategoryResource;
use App\Models\PostCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lister toutes les catégories
     */
    public function index(): View
    {
        $categories = PostCategory::withCount('posts')
            ->ordered()
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Sauvegarder une catégorie
     */
    public function store(PostCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        PostCategory::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Formulaire d'édition
     */
    public function edit(PostCategory $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(PostCategoryRequest $request, PostCategory $category): RedirectResponse
    {
        $validated = $request->validated();

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(PostCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }
}
