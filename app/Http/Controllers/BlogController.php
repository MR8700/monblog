<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Enums\PostVisibility;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostReaction;
use App\Models\PostTag;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Liste des articles publiés
     */
    public function index(Request $request): View
    {
        $query = Post::published()
            ->withRelations()
            ->filter($request->only(['search', 'category', 'tag', 'date_from', 'date_to']));

        $posts = $query->orderByDesc('featured')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->appends($request->query());

        $categories = PostCategory::active()->ordered()->get();
        $tags = PostTag::active()->popular(10)->get();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Afficher un article détaillé
     */
    public function show(Request $request, Post $post): View
    {
        // Vérifier la visibilité
        if (!$this->canViewPost($post)) {
            abort(404, 'Article non disponible');
        }

        // Tracer la vue
        $this->trackView($request, $post);

        // Charger les relations
        $post->load([
            'category',
            'admin',
            'tags',
            'medias' => fn($q) => $q->ordered(),
            'comments' => fn($q) => $q->where('approved', true)->latest(),
        ]);

        // Compter les réactions
        $reactionsCount = $post->reactions()
            ->where('type', 'like')
            ->count();

        $visitorId = $this->getVisitorId($request);
        $hasReacted = PostReaction::query()
            ->where('post_id', $post->id)
            ->where('type', 'like')
            ->where('visitor_id', $visitorId)
            ->exists();

        // Articles connexes (même catégorie ou tags)
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                if ($post->category_id) {
                    $q->orWhere('category_id', $post->category_id);
                }
                if ($post->tags->isNotEmpty()) {
                    $q->orWhereHas('tags', fn($query) => 
                        $query->whereIn('post_tags.id', $post->tags->pluck('id'))
                    );
                }
            })
            ->limit(4)
            ->get();

        return view('blog.show', compact(
            'post',
            'reactionsCount',
            'hasReacted',
            'relatedPosts'
        ));
    }

    /**
     * Vue par catégorie
     */
    public function category(PostCategory $category): View
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->withRelations()
            ->orderByDesc('featured')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('blog.category', compact('posts', 'category'));
    }

    /**
     * Vue par tag
     */
    public function tag(PostTag $tag): View
    {
        $posts = Post::published()
            ->whereHas('tags', fn($q) => $q->where('post_tags.id', $tag->id))
            ->withRelations()
            ->orderByDesc('featured')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('blog.tag', compact('posts', 'tag'));
    }

    /**
     * Vérifier si l'utilisateur peut voir l'article
     */
    private function canViewPost(Post $post): bool
    {
        // Les articles publics et visibles sont accessibles à tous
        if ($post->status === PostStatus::PUBLISHED && 
            $post->visibility === PostVisibility::PUBLIC) {
            return true;
        }

        // Les admins peuvent voir les leurs
        if (Auth::guard('admin')->check() && Auth::guard('admin')->id() === $post->admin_id) {
            return true;
        }

        return false;
    }

    /**
     * Tracer les vues
     */
    private function trackView(Request $request, Post $post): void
    {
        $visitorId = $this->getVisitorId($request);

        $viewExists = PostView::where('post_id', $post->id)
            ->where('visitor_id', $visitorId)
            ->exists();

        if (!$viewExists) {
            PostView::create([
                'post_id' => $post->id,
                'visitor_id' => $visitorId,
                'viewed_at' => now(),
            ]);
            $post->increment('views_count');
        }
    }

    /**
     * Obtenir l'identifiant du visiteur
     */
    private function getVisitorId(Request $request): string
    {
        if (Auth::check()) {
            return 'user_' . Auth::id();
        }

        if ($request->hasCookie('visitor_id')) {
            return $request->cookie('visitor_id');
        }

        return 'guest_' . $request->ip() . '_' . $request->header('User-Agent');
    }
}
