<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostReactionController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        if (! $post->published) {
            abort(404, 'Article non disponible');
        }

        $visitorId = $request->cookie('visitor_id') ?: (string) Str::uuid();

        $reaction = PostReaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->where('visitor_id', $visitorId)
            ->first();

        if ($reaction) {
            $reaction->delete();
            $reacted = false;
        } else {
            PostReaction::create([
                'post_id' => $post->id,
                'type' => 'like',
                'visitor_id' => $visitorId,
            ]);
            $reacted = true;
        }

        $count = PostReaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->count();

        $response = response()->json([
            'reacted' => $reacted,
            'count' => $count,
        ]);

        if (! $request->cookie('visitor_id')) {
            $response->cookie('visitor_id', $visitorId, 60 * 24 * 365);
        }

        return $response;
    }
}
