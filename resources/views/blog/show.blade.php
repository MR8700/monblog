@extends('layout.app')

@section('title', $post->title)

@section('content')
<section class="max-w-4xl mx-auto px-6 py-14">
  <div class="glass rounded-3xl overflow-hidden">
    <img src="{{ $post->cover_image ?? 'https://via.placeholder.com/1200x700' }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
    <div class="p-8 space-y-5">
      <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Article</p>
      <h1 class="text-3xl md:text-4xl font-display text-primary">{{ $post->title }}</h1>
      <div class="text-sm text-slate-500 flex gap-4">
        <span>{{ $post->views_count }} vues</span>
        <span id="like-count">{{ $reactionsCount }} likes</span>
      </div>
      <div class="prose max-w-none">{!! nl2br(e($post->body)) !!}</div>
      <button id="like-button"
              data-reacted="{{ $hasReacted ? '1' : '0' }}"
              class="px-5 py-2 rounded-full text-sm font-semibold border border-slate-200 bg-white hover:bg-slate-50">
        <span id="like-text">{{ $hasReacted ? 'Retirer le like' : 'Liker' }}</span>
      </button>
    </div>
  </div>

  <div class="mt-10 space-y-6">
    <h2 class="text-2xl font-heading">Commentaires</h2>
    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-3 rounded-xl">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('blog.comments.store', $post) }}" class="glass rounded-3xl p-6 space-y-4">
      @csrf
      <div class="grid gap-4 md:grid-cols-2">
        <input type="text" name="name" placeholder="Votre nom" class="w-full rounded-xl border border-slate-200 px-4 py-2">
        <input type="email" name="email" placeholder="Votre email (optionnel)" class="w-full rounded-xl border border-slate-200 px-4 py-2">
      </div>
      <textarea name="body" rows="4" placeholder="Votre commentaire" class="w-full rounded-xl border border-slate-200 px-4 py-2"></textarea>
      <button type="submit" class="btn btn-primary rounded-full">Envoyer</button>
    </form>

    <div class="space-y-4">
      @forelse($post->comments()->where('approved', true)->latest()->get() as $comment)
        <div class="glass rounded-2xl p-5">
          <div class="flex items-center gap-2 text-sm font-semibold">
            <span>{{ $comment->name }}</span>
            @if($comment->is_admin)
              <span class="px-2 py-1 text-xs rounded-full bg-secondary/20 text-secondary">Admin</span>
            @endif
          </div>
          <p class="text-sm text-slate-600 mt-2">{{ $comment->body }}</p>
        </div>
      @empty
        <div class="glass rounded-2xl p-5 text-slate-600">Soyez le premier a commenter.</div>
      @endforelse
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('like-button');
    if (!button) return;

    button.addEventListener('click', async () => {
      const response = await fetch("{{ route('blog.reactions.toggle', $post) }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        }
      });

      if (!response.ok) {
        return;
      }

      const data = await response.json();
      document.getElementById('like-count').textContent = data.count + ' likes';
      document.getElementById('like-text').textContent = data.reacted ? 'Retirer le like' : 'Liker';
    });
  });
</script>
@endsection
