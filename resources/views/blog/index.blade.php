@extends('layout.app')

@section('title', 'Blog')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-14">
  <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
    <div>
      <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Blog</p>
      <h1 class="text-3xl md:text-4xl font-display text-primary">Articles et analyses</h1>
      <p class="text-slate-600 mt-2">Publier, commenter, aimer et suivre les vues en temps reel.</p>
    </div>
  </div>

  <div class="grid gap-6 md:grid-cols-3 mt-10">
    @forelse($posts as $post)
      <article class="glass rounded-3xl overflow-hidden flex flex-col">
        <img src="{{ $post->cover_image ?? 'https://via.placeholder.com/900x600' }}" alt="{{ $post->title }}" class="w-full h-44 object-cover">
        <div class="p-6 space-y-3 flex-1 flex flex-col">
          <h2 class="text-xl font-heading">{{ $post->title }}</h2>
          <p class="text-sm text-slate-600">{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 140) }}</p>
          <div class="text-xs text-slate-500 flex gap-4">
            <span>{{ $post->views_count }} vues</span>
            <span>{{ $post->comments_count }} commentaires</span>
            <span>{{ $post->reactions_count }} likes</span>
          </div>
          <a href="{{ route('blog.show', $post) }}" class="mt-auto text-sm font-semibold text-secondary">Lire l article</a>
        </div>
      </article>
    @empty
      <div class="glass rounded-3xl p-6 text-slate-600">Aucun article pour le moment.</div>
    @endforelse
  </div>

  <div class="mt-10">
    {{ $posts->links() }}
  </div>
</section>
@endsection
