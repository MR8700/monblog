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

  <!-- Search & Filters -->
  <div class="mt-12 bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50">
    <form action="{{ route('blog.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2 relative">
            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un article..." class="w-full pl-14 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
        </div>
        <div>
            <select name="category" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-primary text-white rounded-2xl font-bold py-4 px-8 hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
            Filtrer
        </button>
    </form>
  </div>

  <div class="grid gap-8 md:grid-cols-3 mt-12">
    @forelse($posts as $post)
      <article class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 flex flex-col relative">
        @if($post->is_premium)
          <div class="absolute top-5 right-5 z-10 bg-amber-400 text-amber-950 text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1.5">
            <i class="fas fa-crown"></i> Premium
          </div>
        @endif
        
        <div class="relative h-56 overflow-hidden">
          <img src="{{ $post->cover_image ? asset('storage/' . $post->cover_image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800' }}" 
               alt="{{ $post->title }}" 
               class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>

        <div class="p-8 space-y-4 flex-1 flex flex-col">
          <div class="flex items-center gap-3">
            @if($post->category)
              <span class="text-[10px] font-bold uppercase tracking-widest text-secondary bg-secondary/10 px-3 py-1 rounded-full">
                {{ $post->category->name }}
              </span>
            @endif
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
              {{ $post->published_at ? $post->published_at->diffForHumans() : 'Récemment' }}
            </span>
          </div>

          <h2 class="text-xl font-bold text-slate-900 group-hover:text-primary transition-colors leading-tight">
            {{ $post->title }}
          </h2>
          
          <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
            {{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}
          </p>

          <div class="pt-4 mt-auto border-t border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3 text-[11px] font-medium text-slate-400">
              <span class="flex items-center gap-1"><i class="far fa-eye"></i> {{ $post->views_count }}</span>
              <span class="flex items-center gap-1"><i class="far fa-comment"></i> {{ $post->comments_count }}</span>
            </div>

            @if($post->price > 0)
              <div class="text-primary font-bold">
                {{ number_format($post->price, 0, ',', ' ') }} <span class="text-[10px] opacity-70">CFA</span>
              </div>
            @else
              <div class="text-green-500 font-bold text-[10px] uppercase tracking-widest">
                Gratuit
              </div>
            @endif
          </div>

          <a href="{{ route('blog.show', $post) }}" class="absolute inset-0 z-0"></a>
        </div>
      </article>
    @empty
      <div class="col-span-full py-20 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-300 mb-4 text-3xl">
          <i class="fas fa-newspaper"></i>
        </div>
        <p class="text-slate-500">Aucun article n'a été publié pour le moment.</p>
      </div>
    @endforelse
  </div>

  <div class="mt-10">
    {{ $posts->links() }}
  </div>
</section>
@endsection
