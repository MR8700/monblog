<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Enums\PostVisibility;
use App\Events\PostCreated;
use App\Events\PostPublished;
use App\Events\PostUpdated;
use App\Http\Requests\BlogPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\PostMedia;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Liste des articles (admin)
     */
    public function index(Request $request): View
    {
        $this->authorize('create', Post::class);

        $posts = Post::withRelations()
            ->filter($request->all())
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Créer un article
     */
    public function create(): View
    {
        $this->authorize('create', Post::class);

        $categories = PostCategory::ordered()->get();
        $tags = PostTag::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Sauvegarder un nouvel article
     */
    public function store(BlogPostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $validated = $request->validated();
        $validated['admin_id'] = Auth::guard('admin')->id();

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        }

        // Créer l'article
        $post = Post::create($validated);

        // Attacher les tags
        if (!empty($validated['tags'] ?? [])) {
            $post->tags()->sync($validated['tags']);
        }

        // Sauvegarder les médias
        if ($request->hasFile('medias')) {
            $this->storeMedias($post, $request->file('medias'));
        }

        // Dispatche l'event
        PostCreated::dispatch($post);

        if ($post->status === PostStatus::PUBLISHED) {
            PostPublished::dispatch($post);
        }

        return redirect()
            ->route('admin.posts.show', $post)
            ->with('success', 'Article créé avec succès !');
    }

    /**
     * Afficher un article (vue prévisualisation admin)
     */
    public function show(Post $post): View
    {
        $this->authorize('view', $post);

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Éditer un article
     */
    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        $categories = PostCategory::ordered()->get();
        $tags = PostTag::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Mettre à jour un article
     */
    public function update(BlogPostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validated();

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image
            if ($post->cover_image && Storage::exists($post->cover_image)) {
                Storage::delete($post->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        }

        $post->update($validated);

        // Attacher les tags
        if (!empty($validated['tags'] ?? [])) {
            $post->tags()->sync($validated['tags']);
        } else {
            $post->tags()->detach();
        }

        // Sauvegarder les nouveaux médias
        if ($request->hasFile('medias')) {
            $this->storeMedias($post, $request->file('medias'));
        }

        PostUpdated::dispatch($post);

        return redirect()
            ->route('admin.posts.show', $post)
            ->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Supprimer un article
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        // Supprimer l'image de couverture
        if ($post->cover_image && Storage::exists($post->cover_image)) {
            Storage::delete($post->cover_image);
        }

        // Supprimer les médias (le model se charge via le boot event)
        $post->medias()->each(function (PostMedia $media) {
            $media->delete();
        });

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    /**
     * Changer le statut de l'article
     */
    public function toggleVisibility(Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $nextStatus = match($post->status) {
            PostStatus::DRAFT => PostStatus::PUBLISHED,
            PostStatus::PUBLISHED => PostStatus::ARCHIVED,
            PostStatus::ARCHIVED => PostStatus::DRAFT,
            default => PostStatus::DRAFT,
        };

        $updateData = ['status' => $nextStatus];

        if ($nextStatus === PostStatus::PUBLISHED && !$post->published_at) {
            $updateData['published_at'] = now();
        } elseif ($nextStatus === PostStatus::ARCHIVED) {
            $updateData['archived_at'] = now();
        }

        $post->update($updateData);

        if ($nextStatus === PostStatus::PUBLISHED) {
            PostPublished::dispatch($post);
        }

        return back()->with('success', "Article marqué comme: {$nextStatus->label()}");
    }

    /**
     * Sauvegarder les médias
     */
    private function storeMedias(Post $post, $files): void
    {
        $order = $post->medias()->max('display_order') ?? 0;

        foreach ($files as $file) {
            $order++;
            $filename = $file->hashName();
            $path = $file->store('post-medias', 'public');

            PostMedia::create([
                'post_id' => $post->id,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'type' => PostMedia::getTypeFromMime($file->getClientMimeType()),
                'display_order' => $order,
            ]);
        }
    }
}
