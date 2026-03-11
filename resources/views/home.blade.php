@extends('layout.app')

@section('title', 'Accueil')

@section('content')
<section class="relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24 grid gap-10 lg:grid-cols-2 items-center">
    <div class="space-y-6">
      <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Portfolio + Blog + Chat</p>
      <h1 class="text-4xl md:text-5xl font-display leading-tight text-primary">
        Un espace pro pour publier mes travaux, articles et echanger en direct.
      </h1>
      <p class="text-lg text-slate-600">
        Articles de fond, projets, retours, commentaires et reactions. Ici, tout est connecte.
      </p>
      <div class="flex flex-wrap gap-3">
        <a href="{{ route('blog.index') }}" class="btn btn-primary rounded-full">Lire le blog</a>
        <a href="{{ route('portfolio.index') }}" class="btn btn-secondary rounded-full">Voir le portfolio</a>
        <a href="{{ route('chat.index') }}" class="btn rounded-full border border-slate-200 bg-white">Discuter en direct</a>
      </div>
    </div>
    <div class="relative">
      <div class="glass p-8 rounded-3xl shadow-glow">
        <h2 class="font-heading text-2xl mb-4">Ce que vous trouverez</h2>
        <ul class="space-y-3 text-slate-700">
          <li class="flex gap-3"><span class="text-secondary">●</span>Articles structures avec commentaires et likes.</li>
          <li class="flex gap-3"><span class="text-secondary">●</span>Portfolio clair, CV pro et liens directs.</li>
          <li class="flex gap-3"><span class="text-secondary">●</span>Chat temps reel avec pieces jointes et video.</li>
        </ul>
      </div>
      <div class="absolute -bottom-8 -right-6 w-40 h-40 bg-secondary/20 blur-2xl rounded-full"></div>
    </div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-heading">Articles recents</h2>
    <a href="{{ route('blog.index') }}" class="text-sm font-semibold">Tout voir</a>
  </div>
  <div class="grid gap-6 md:grid-cols-3">
    @forelse($latestPosts as $post)
      <article class="glass rounded-3xl p-6 flex flex-col gap-4">
        <p class="text-xs uppercase tracking-[0.3em] text-secondary">Blog</p>
        <h3 class="text-xl font-heading">{{ $post->title }}</h3>
        <p class="text-sm text-slate-600">{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p>
        <a href="{{ route('blog.show', $post) }}" class="text-sm font-semibold text-secondary">Lire</a>
      </article>
    @empty
      <div class="glass rounded-3xl p-6 text-slate-600">Pas encore d articles.</div>
    @endforelse
  </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-heading">Portfolio en vedette</h2>
    <a href="{{ route('portfolio.index') }}" class="text-sm font-semibold">Voir le portfolio</a>
  </div>
  <div class="grid gap-6 md:grid-cols-3">
    @forelse($featuredPortfolio as $item)
      <div class="glass rounded-3xl p-6">
        <h3 class="text-xl font-heading">{{ $item->title }}</h3>
        <p class="text-sm text-slate-600 mt-2">{{ $item->summary }}</p>
        @if($item->link)
          <a href="{{ $item->link }}" target="_blank" class="text-sm font-semibold text-secondary mt-4 inline-block">Voir le projet</a>
        @endif
      </div>
    @empty
      <div class="glass rounded-3xl p-6 text-slate-600">Ajoutez vos projets pour remplir cette section.</div>
    @endforelse
  </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-heading">Travaux recents</h2>
    <a href="{{ route('products.publicIndex') }}" class="text-sm font-semibold">Tout voir</a>
  </div>
  <div class="grid gap-6 md:grid-cols-3">
    @forelse ($products as $product)
      <div class="glass rounded-3xl overflow-hidden">
        <img src="{{ $product->image ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $product->title }}" class="w-full h-44 object-cover">
        <div class="p-5 space-y-3">
          <h3 class="font-heading text-lg">{{ $product->title }}</h3>
          <p class="text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
          <a href="{{ route('products.show', $product) }}" class="text-sm font-semibold text-secondary">Voir</a>
        </div>
      </div>
    @empty
      <div class="glass rounded-3xl p-6 text-slate-600">Ajoutez vos travaux pour afficher cette section.</div>
    @endforelse
  </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-16">
  <div class="glass rounded-3xl p-8 md:p-12 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
      <h2 class="text-2xl font-heading">Discutons en direct</h2>
      <p class="text-slate-600 mt-2">Chat temps reel, reactions, documents et video via Jitsi.</p>
    </div>
    <a href="{{ route('chat.index') }}" class="btn btn-primary rounded-full">Ouvrir le chat</a>
  </div>
</section>
@endsection
