<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if (! $post->published) {
            abort(404, 'Article non disponible');
        }

        $data = $request->validate([
            'name' => 'nullable|string|max:120',
            'email' => 'nullable|email|max:255',
            'body' => 'required|string|max:2000',
        ]);

        $isAdmin = auth()->guard('admin')->check();

        $data['name'] = $data['name'] ?: ($isAdmin ? auth()->guard('admin')->user()->name : 'Invité');
        $data['is_admin'] = $isAdmin;
        $data['approved'] = true;

        $post->comments()->create($data);

        return back()->with('success', 'Merci pour votre commentaire.');
    }
}
