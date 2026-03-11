@extends('layout.app')

@section('title', auth()->guard('admin')->check() ? 'Gestion des travaux' : 'Travaux')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Travaux</p>
      <h1 class="text-3xl font-display text-primary">
        {{ auth()->guard('admin')->check() ? 'Gestion des travaux' : 'Travaux recents' }}
      </h1>
    </div>
    @if(auth()->guard('admin')->check())
      <div class="flex gap-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-full">Ajouter</a>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary rounded-full">Profil</a>
      </div>
    @endif
  </div>

  @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
      {{ session('success') }}
    </div>
  @endif

  @if($products->isEmpty())
    <div class="glass rounded-3xl p-6 text-slate-600">
      {{ auth()->guard('admin')->check() ? 'Aucun travail pour le moment.' : 'Aucun travail disponible.' }}
    </div>
  @else
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @foreach($products as $product)
        <div class="glass rounded-3xl overflow-hidden flex flex-col">
          <img src="{{ $product->image ?? 'https://via.placeholder.com/800x600' }}" alt="{{ $product->title }}" class="w-full h-44 object-cover">
          <div class="p-6 flex flex-col gap-3 flex-1">
            <div class="flex items-center justify-between text-xs text-slate-500">
              <span>{{ $product->published ? 'Publie' : 'Brouillon' }}</span>
              <span>{{ $product->created_at->format('d/m/Y') }}</span>
            </div>
            <h2 class="text-xl font-heading">{{ $product->title }}</h2>
            <p class="text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
            <div class="flex items-center justify-between mt-auto">
              <span class="text-secondary font-semibold">
                {{ $product->price ? number_format($product->price, 0, ',', ' ') . ' CFA' : 'Prix non defini' }}
              </span>
              <a href="{{ route('products.show', $product->slug) }}" class="text-sm font-semibold text-secondary">Voir</a>
            </div>
            @if(auth()->guard('admin')->check())
              <div class="flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="text-sm font-semibold text-primary">Editer</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Supprimer ce travail ?')" class="text-sm font-semibold text-red-600">
                    Supprimer
                  </button>
                </form>
              </div>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-8">
      {{ $products->links() }}
    </div>
  @endif
</section>
@endsection
