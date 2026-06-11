@extends('layout.app')

@section('title', $post->title)

@section('content')
<section class="max-w-5xl mx-auto px-6 py-14">
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">
      <i class="fas fa-arrow-left"></i> Retour au blog
    </a>
    
    <div class="flex items-center gap-4">
      <div class="text-xs font-bold uppercase tracking-widest text-slate-400">
        {{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : 'Non publié' }}
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-2 space-y-10">
      <article class="bg-white rounded-[3rem] overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50">
        <div class="relative h-[400px]">
          <img src="{{ $post->cover_image ? asset('storage/' . $post->cover_image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=1200' }}" 
               alt="{{ $post->title }}" 
               class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
          
          <div class="absolute bottom-10 left-10 right-10">
            @if($post->category)
              <span class="inline-block bg-primary text-white text-[10px] font-bold uppercase tracking-[0.2em] px-4 py-1.5 rounded-full mb-4">
                {{ $post->category->name }}
              </span>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight">
              {{ $post->title }}
            </h1>
          </div>

          @if($post->is_premium)
            <div class="absolute top-8 right-8 bg-amber-400 text-amber-950 text-xs font-bold uppercase tracking-widest px-5 py-2.5 rounded-full shadow-2xl flex items-center gap-2">
              <i class="fas fa-crown"></i> Article Premium
            </div>
          @endif
        </div>

        <div class="p-10 md:p-14">
          <div class="flex items-center justify-between mb-10 pb-10 border-b border-slate-50">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                <i class="fas fa-user"></i>
              </div>
              <div>
                <p class="text-sm font-bold text-slate-900">{{ $post->admin->name ?? 'Auteur' }}</p>
                <p class="text-xs text-slate-400">Auteur expert</p>
              </div>
            </div>

            <div class="flex items-center gap-6 text-slate-400">
              <div class="text-center">
                <p class="text-lg font-bold text-slate-900">{{ $post->views_count }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest">Vues</p>
              </div>
              <div class="text-center">
                <p class="text-lg font-bold text-slate-900" id="like-count">{{ $reactionsCount }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest">Likes</p>
              </div>
            </div>
          </div>

          <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">
            @if($post->is_premium && !Auth::guard('admin')->check())
              <div class="relative">
                <div class="opacity-30 blur-sm select-none">
                  {!! nl2br(e(\Illuminate\Support\Str::limit($post->body, 500))) !!}
                </div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-10 bg-white/60 rounded-[2rem] border border-white backdrop-blur-sm">
                  <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mb-6 text-3xl shadow-inner">
                    <i class="fas fa-lock"></i>
                  </div>
                  <h3 class="text-2xl font-bold text-slate-900 mb-2">Contenu Premium</h3>
                  <p class="text-slate-500 mb-8 max-w-sm">Cet article est réservé à nos membres premium. Obtenez un accès complet pour découvrir toute l'analyse.</p>
                  
                  @if($post->price > 0)
                    <button class="bg-primary text-white px-10 py-4 rounded-full font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-transform flex items-center gap-3">
                      Accéder pour {{ number_format($post->price, 0, ',', ' ') }} CFA
                    </button>
                  @else
                    <a href="{{ route('admin.login') }}" class="bg-primary text-white px-10 py-4 rounded-full font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-transform">
                      Se connecter pour lire
                    </a>
                  @endif
                </div>
              </div>
            @else
              {!! nl2br(e($post->body)) !!}
            @endif
          </div>

          <div class="mt-14 pt-10 border-t border-slate-100 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-2">
              @foreach($post->tags as $tag)
                <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg">
                  #{{ $tag->name }}
                </span>
              @endforeach
            </div>

            <button id="like-button"
                    data-reacted="{{ $hasReacted ? '1' : '0' }}"
                    class="group flex items-center gap-3 px-6 py-3 rounded-full border-2 transition-all {{ $hasReacted ? 'border-danger bg-danger/5 text-danger' : 'border-slate-100 hover:border-danger/20 hover:text-danger' }}">
              <i class="{{ $hasReacted ? 'fas' : 'far' }} fa-heart transition-transform group-hover:scale-125"></i>
              <span class="text-sm font-bold uppercase tracking-widest" id="like-text">
                {{ $hasReacted ? 'Aimé' : 'J\'aime' }}
              </span>
            </button>
          </div>
        </div>
      </article>

      <!-- Section Commentaires -->
      <div class="bg-slate-50 rounded-[3rem] p-10 md:p-14">
        <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
          Commentaires <span class="bg-white px-3 py-1 rounded-full text-sm text-slate-400 border border-slate-200">{{ $post->comments->where('approved', true)->count() }}</span>
        </h2>

        <form method="POST" action="{{ route('blog.comments.store', $post) }}" class="mb-12">
          @csrf
          <div class="bg-white rounded-[2rem] p-3 shadow-sm border border-slate-100 focus-within:ring-2 focus-within:ring-primary/20 transition-all">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
              <input type="text" name="name" placeholder="Votre nom" required
                     class="w-full bg-slate-50 rounded-xl px-5 py-3 text-sm focus:outline-none focus:bg-white transition-colors">
              <input type="email" name="email" placeholder="Email (optionnel)"
                     class="w-full bg-slate-50 rounded-xl px-5 py-3 text-sm focus:outline-none focus:bg-white transition-colors">
            </div>
            <textarea name="body" rows="3" placeholder="Partagez votre avis..." required
                      class="w-full bg-slate-50 rounded-xl px-5 py-3 text-sm focus:outline-none focus:bg-white transition-colors mb-3"></textarea>
            <div class="flex justify-end">
              <button type="submit" class="bg-primary text-white px-8 py-3 rounded-full text-sm font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                Commenter
              </button>
            </div>
          </div>
        </form>

        <div class="space-y-6">
          @forelse($post->comments->where('approved', true)->sortByDesc('created_at') as $comment)
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
              @if($comment->is_admin)
                <div class="absolute top-0 right-0 bg-secondary text-white text-[8px] font-bold uppercase tracking-widest px-3 py-1 rounded-bl-xl">
                  Admin
                </div>
              @endif
              <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-400 font-bold text-xs">
                  {{ strtoupper(substr($comment->name, 0, 1)) }}
                </div>
                <div>
                  <p class="text-sm font-bold text-slate-900">{{ $comment->name }}</p>
                  <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
              </div>
              <p class="text-slate-600 text-sm leading-relaxed">{{ $comment->body }}</p>
            </div>
          @empty
            <div class="text-center py-10 bg-white rounded-3xl border border-dashed border-slate-200">
              <p class="text-slate-400 text-sm">Aucun commentaire pour le moment. Soyez le premier !</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-10">
      <!-- Widget Prix / Achat -->
      @if($post->price > 0)
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40 sticky top-10">
          <div class="text-center space-y-4">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/5 text-primary rounded-full mb-2">
              <i class="fas fa-shopping-bag text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Accès à l'article</h3>
            <div class="text-4xl font-black text-primary">
              {{ number_format($post->price, 0, ',', ' ') }} <span class="text-sm font-bold opacity-50">CFA</span>
            </div>
            <p class="text-xs text-slate-400 leading-relaxed px-4">
              Obtenez un accès permanent à ce contenu exclusif et supportez notre travail.
            </p>
            
            <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="products[0][id]" value="{{ $post->id }}">
                <input type="hidden" name="products[0][type]" value="post">
                <input type="hidden" name="products[0][quantity]" value="1">
                
                <div class="space-y-2">
                  <input type="text" name="user_name" placeholder="Votre nom" required class="w-full text-xs bg-slate-50 border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/20">
                  <input type="email" name="user_email" placeholder="Email" required class="w-full text-xs bg-slate-50 border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/20">
                  <input type="text" name="user_phone" placeholder="Téléphone" required class="w-full text-xs bg-slate-50 border-none rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/20">
                </div>

                <button type="submit" class="w-full bg-primary text-white py-4 rounded-full font-bold shadow-xl shadow-primary/20 hover:bg-primary-dark hover:scale-[1.02] transition-all flex items-center justify-center gap-3">
                  <i class="fas fa-rocket"></i> Acheter maintenant
                </button>
            </form>
            
            <div class="flex items-center justify-center gap-4 pt-4">
              <i class="fab fa-cc-visa text-slate-300 text-xl"></i>
              <i class="fab fa-cc-mastercard text-slate-300 text-xl"></i>
              <div class="w-px h-4 bg-slate-100"></div>
              <span class="text-[10px] font-bold uppercase tracking-widest text-slate-300">Paiement Sécurisé</span>
            </div>
          </div>
        </div>
      @endif

      <!-- Articles Connexes -->
      <div class="space-y-6">
        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
          <span class="w-2 h-2 bg-secondary rounded-full"></span> À lire aussi
        </h3>
        <div class="grid gap-6">
          @foreach($relatedPosts as $related)
            <a href="{{ route('blog.show', $related) }}" class="group flex gap-4 bg-white p-3 rounded-2xl border border-slate-50 hover:border-primary/20 transition-all shadow-sm">
              <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                <img src="{{ $related->cover_image ? asset('storage/' . $related->cover_image) : 'https://via.placeholder.com/150' }}" 
                     alt="{{ $related->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="flex-1 min-w-0 py-1">
                <h4 class="text-sm font-bold text-slate-900 group-hover:text-primary transition-colors line-clamp-2 leading-tight">
                  {{ $related->title }}
                </h4>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-2">
                  {{ $related->published_at ? $related->published_at->diffForHumans() : 'Récemment' }}
                </p>
              </div>
            </a>
          @endforeach
        </div>
      </div>
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
