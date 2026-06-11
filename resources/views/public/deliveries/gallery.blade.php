@extends('layout.app')

@section('title', 'E-Vitrine - Nos Réalisations')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="text-center space-y-4 mb-16">
        <h1 class="text-5xl font-black text-slate-900 tracking-tight">Notre <span class="text-primary italic">E-Vitrine</span></h1>
        <p class="text-slate-500 text-lg max-w-2xl mx-auto font-medium">Découvrez les projets réalisés pour nos clients. Qualité, créativité et satisfaction garanties.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($deliveries as $delivery)
            <div class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-xl hover:shadow-2xl transition-all duration-500">
                <div class="aspect-video relative overflow-hidden bg-slate-100">
                    @if($delivery->preview_path)
                        <img src="{{ asset('storage/' . $delivery->preview_path) }}" alt="{{ $delivery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <i class="fas fa-image text-5xl"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                        <a href="{{ route('deliveries.show', $delivery->secure_token) }}" class="w-full bg-white text-slate-900 py-3 rounded-xl font-bold text-center transform translate-y-4 group-hover:translate-y-0 transition-transform">
                            Voir le projet
                        </a>
                    </div>
                </div>
                <div class="p-8 space-y-4">
                    <div class="flex justify-between items-start">
                        <h3 class="text-xl font-bold text-slate-900 leading-tight">{{ $delivery->title }}</h3>
                        <div class="flex gap-2">
                            <span class="text-xs font-bold text-slate-400 flex items-center gap-1">
                                <i class="fas fa-heart text-red-400"></i> {{ $delivery->reactions['like'] ?? 0 }}
                            </span>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm line-clamp-2 font-medium">{{ $delivery->description }}</p>
                    <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Livré le {{ $delivery->created_at->format('d/m/Y') }}</span>
                        <i class="fas fa-arrow-right text-primary opacity-0 group-hover:opacity-100 transform translate-x-[-10px] group-hover:translate-x-0 transition-all"></i>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <i class="fas fa-box-open text-6xl text-slate-200 mb-6"></i>
                <p class="text-slate-500 font-medium">La vitrine est actuellement vide.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $deliveries->links() }}
    </div>
</section>
@endsection
