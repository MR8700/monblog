<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReaction;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('published', true)
            ->withCount(['comments' => function ($query) {
                $query->where('approved', true);
            }])
            ->withCount('reactions')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show(Request $request, Post $post)
    {
        if (! $post->published) {
            abort(404, 'Article non disponible');
        }

        $visitorId = $this->getVisitorId($request);

        $view = PostView::where('post_id', $post->id)
            ->where('visitor_id', $visitorId)
            ->first();

        if (! $view) {
            PostView::create([
                'post_id' => $post->id,
                'visitor_id' => $visitorId,
                'viewed_at' => now(),
            ]);

            $post->increment('views_count');
        }

        $reactionsCount = PostReaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->count();

        $hasReacted = PostReaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->where('visitor_id', $visitorId)
            ->exists();

        $response = response()->view('blog.show', compact('post', 'reactionsCount', 'hasReacted'));

        if (! $request->cookie('visitor_id')) {
            $response->cookie('visitor_id', $visitorId, 60 * 24 * 365);
        }

        return $response;
    }

    private function getVisitorId(Request $request): string
    {
        $existing = $request->cookie('visitor_id');
        if ($existing) {
            return $existing;
        }

        return (string) Str::uuid();
    }
}
