<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $posts = Post::latest()->paginate(12);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $this->validateData($request);
        $data['admin_id'] = Auth::guard('admin')->id();
        $data['slug'] = Str::slug($data['title']) . '-' . time();
        if ($data['published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = '/storage/' . $request->file('cover_image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Article créé.');
    }

    public function edit(Post $post)
    {
        $this->authorizeAdmin();
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeAdmin();

        $data = $this->validateData($request);
        if ($data['published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = '/storage/' . $request->file('cover_image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Article mis à jour.');
    }

    public function destroy(Post $post)
    {
        $this->authorizeAdmin();
        $post->delete();

        return back()->with('success', 'Article supprimé.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'body' => 'required|string',
            'cover_image' => 'nullable|image|max:4096',
            'published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $data['published'] = $request->filled('published');

        return $data;
    }

    private function authorizeAdmin(): void
    {
        if (! Auth::guard('admin')->check()) {
            abort(403, 'Accès interdit');
        }
    }
}
