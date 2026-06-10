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
        if (! $post->is_published && ! auth()->guard('admin')->check()) {
            abort(404, 'Article non disponible');
        }

        $visitorId = $this->getVisitorId($request);

        $reaction = PostReaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->where('visitor_id', $visitorId)
            ->first();

        if ($reaction) {
            $reaction->delete();
            $reacted = false;
        } else {
            try {
                PostReaction::create([
                    'post_id' => $post->id,
                    'type' => 'like',
                    'visitor_id' => $visitorId,
                ]);
                $reacted = true;
            } catch (\Exception $e) {
                // Probablement une violation de contrainte unique, on considère que c'est déjà liké
                $reacted = false;
            }
        }

        $count = PostReaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->count();

        $response = response()->json([
            'reacted' => $reacted,
            'count' => $count,
        ]);

        // On rafraîchit le cookie pour qu'il dure plus longtemps
        return $response->cookie('visitor_id', $visitorId, 60 * 24 * 365);
    }

    /**
     * Identifie le visiteur de manière plus robuste (Cookie + IP + User Agent)
     */
    private function getVisitorId(Request $request): string
    {
        if (auth()->check()) {
            return 'user_' . auth()->id();
        }

        // Si on a déjà un cookie, on l'utilise
        if ($request->hasCookie('visitor_id')) {
            return $request->cookie('visitor_id');
        }

        // Sinon on génère une empreinte basée sur l'appareil (IP + Navigateur)
        return 'device_' . md5($request->ip() . $request->header('User-Agent'));
    }
}
