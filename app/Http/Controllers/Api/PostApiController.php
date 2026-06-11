<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostApiController extends Controller
{
    /**
     * GET /api/v1/posts
     */
    public function index(): JsonResponse
    {
        $posts = Post::where('published', true)
            ->with(['admin', 'comments', 'reactions', 'views'])
            ->orderByDesc('published_at')
            ->paginate(15);

        return response()->json($posts);
    }

    /**
     * GET /api/v1/posts/{post}
     */
    public function show(Post $post): JsonResponse
    {
        if (!$post->published) {
            abort(404);
        }

        $post->load(['admin', 'comments', 'reactions', 'views']);
        return response()->json($post);
    }

    /**
     * POST /api/v1/posts
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create([
            ...$request->validated(),
            'admin_id' => auth()->guard('admin')->id(),
        ]);

        return response()->json($post, 201);
    }

    /**
     * PUT /api/v1/posts/{post}
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());
        return response()->json($post);
    }

    /**
     * DELETE /api/v1/posts/{post}
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted'], 200);
    }
}
