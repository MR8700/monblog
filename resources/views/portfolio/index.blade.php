@extends('layout.app')

@section('title', 'Portfolio')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-14">
  <div class="grid gap-10 lg:grid-cols-3 items-start">
    <div class="lg:col-span-1 space-y-6">
      <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Portfolio</p>
      <h1 class="text-3xl md:text-4xl font-display text-primary">Profil et CV</h1>
      <p class="text-slate-600">Une selection de travaux, experiences et competences.</p>
      <div class="glass rounded-2xl p-5 space-y-2 text-sm">
        <p class="font-semibold">Disponible pour collaborations</p>
        <p>Email: contact@monsite.com</p>
        <p>Localisation: Burkina Faso</p>
      </div>
    </div>

    <div class="lg:col-span-2 space-y-8">
      <div class="grid gap-6 md:grid-cols-2">
        @forelse($featured as $item)
          <div class="glass rounded-3xl p-6">
            <p class="text-xs uppercase tracking-[0.3em] text-secondary">En vedette</p>
            <h2 class="text-xl font-heading mt-2">{{ $item->title }}</h2>
            <p class="text-sm text-slate-600 mt-2">{{ $item->summary }}</p>
            @if($item->link)
              <a href="{{ $item->link }}" target="_blank" class="text-sm font-semibold text-secondary mt-4 inline-block">Voir le projet</a>
            @endif
          </div>
        @empty
          <div class="glass rounded-3xl p-6 text-slate-600">Ajoutez des projets en vedette.</div>
        @endforelse
      </div>

      <div class="space-y-4">
        <h2 class="text-2xl font-heading">Tous les projets</h2>
        <div class="grid gap-4">
          @forelse($items as $item)
            <div class="glass rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <div>
                <h3 class="font-heading text-lg">{{ $item->title }}</h3>
                <p class="text-sm text-slate-600">{{ $item->summary }}</p>
                @if($item->stack)
                  <p class="text-xs text-slate-500 mt-2">Stack: {{ $item->stack }}</p>
                @endif
              </div>
              @if($item->link)
                <a href="{{ $item->link }}" target="_blank" class="text-sm font-semibold text-secondary">Voir</a>
              @endif
            </div>
          @empty
            <div class="glass rounded-2xl p-5 text-slate-600">Pas encore de portfolio.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
