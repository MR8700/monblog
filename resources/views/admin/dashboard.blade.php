@php
if (!auth()->guard('admin')->check()) {
    abort(403);
}
@endphp

@extends('layout.app')

@section('title', 'Dashboard Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 space-y-10">
  <div class="text-center space-y-2">
    <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Admin</p>
    <h1 class="text-3xl font-display text-primary">Dashboard</h1>
  </div>

  <div class="flex flex-wrap justify-center gap-3">
    <a href="{{ route('admin.products.index') }}" class="btn btn-primary rounded-full">Gerer les travaux</a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary rounded-full">Gerer le blog</a>
    <a href="{{ route('admin.portfolio.index') }}" class="btn rounded-full border border-slate-200 bg-white">Gerer le portfolio</a>
    <a href="{{ route('admin.profile.index') }}" class="btn rounded-full border border-slate-200 bg-white">Mon profil</a>
  </div>

  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @php
      $stats = [
          ['label' => 'Travaux', 'value' => $totalProducts, 'tone' => 'bg-white'],
          ['label' => 'Travaux publies', 'value' => $publishedProducts, 'tone' => 'bg-green-50'],
          ['label' => 'Brouillons', 'value' => $unpublishedProducts, 'tone' => 'bg-yellow-50'],
          ['label' => 'Prix moyen', 'value' => number_format($avgPrice ?? 0, 0, ',', ' ') . ' CFA', 'tone' => 'bg-white'],
          ['label' => 'Total ventes', 'value' => $totalSales, 'tone' => 'bg-white'],
          ['label' => 'Articles', 'value' => $totalPosts, 'tone' => 'bg-white'],
          ['label' => 'Articles publies', 'value' => $publishedPosts, 'tone' => 'bg-green-50'],
          ['label' => 'Commentaires', 'value' => $totalComments, 'tone' => 'bg-white'],
          ['label' => 'Portfolio', 'value' => $portfolioCount, 'tone' => 'bg-white'],
          ['label' => 'Messages chat', 'value' => $chatMessages, 'tone' => 'bg-white'],
      ];
    @endphp

    @foreach($stats as $stat)
      <div class="glass rounded-2xl p-5 {{ $stat['tone'] }}">
        <p class="text-xs uppercase tracking-[0.3em] text-secondary">{{ $stat['label'] }}</p>
        <p class="text-2xl font-heading mt-2">{{ $stat['value'] }}</p>
      </div>
    @endforeach
  </div>

  <div class="grid gap-8 lg:grid-cols-2">
    <div class="glass rounded-3xl p-6">
      <h2 class="text-xl font-heading mb-4">Travaux recents</h2>
      @if($latestProducts->isEmpty())
        <p class="text-slate-600">Aucun travail recent.</p>
      @else
        <ul class="space-y-3">
          @foreach($latestProducts as $product)
            <li class="flex items-center justify-between text-sm">
              <span>{{ $product->title }}</span>
              <span class="text-slate-500">{{ $product->created_at->format('d/m/Y') }}</span>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    <div class="glass rounded-3xl p-6">
      <h2 class="text-xl font-heading mb-4">Travaux les plus chers</h2>
      @if($topProducts->isEmpty())
        <p class="text-slate-600">Aucun travail disponible.</p>
      @else
        <ul class="space-y-3">
          @foreach($topProducts as $product)
            <li class="flex items-center justify-between text-sm">
              <span>{{ $product->title }}</span>
              <span class="font-semibold">{{ $product->price ?? '-' }} CFA</span>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</section>
@endsection
