@extends('layout.app')

@section('title', 'Mon Portfolio - Créations & Expertise')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="grid gap-16 lg:grid-cols-3 items-start">
    <!-- Sidebar Bio -->
    <div class="lg:col-span-1 space-y-10 lg:sticky lg:top-32">
      <div class="space-y-4">
        <span class="text-secondary font-bold uppercase tracking-[0.3em] text-[10px]">Expertise & Expérience</span>
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight">Mon <span class="text-primary italic font-display">Portfolio</span></h1>
        <p class="text-lg text-slate-500 leading-relaxed">
          Un aperçu sélectif de mes travaux les plus impactants, alliant design soigné et performances techniques.
        </p>
      </div>

      <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40 space-y-6">
        <div class="flex items-center gap-4">
          <div class="w-16 h-16 rounded-2xl bg-primary/5 flex items-center justify-center text-primary text-2xl">
            <i class="fas fa-id-card"></i>
          </div>
          <div>
            <p class="text-sm font-bold text-slate-900">Disponibilité</p>
            <p class="text-xs text-green-500 font-bold uppercase tracking-widest">Ouvert aux projets</p>
          </div>
        </div>
        
        <div class="space-y-4 pt-4 border-t border-slate-50">
          <div class="flex items-center justify-between text-sm">
            <span class="text-slate-400 font-medium">Email</span>
            <span class="text-slate-900 font-bold">contact@monsite.com</span>
          </div>
          <div class="flex items-center justify-between text-sm">
            <span class="text-slate-400 font-medium">Localisation</span>
            <span class="text-slate-900 font-bold">Burkina Faso</span>
          </div>
        </div>

        <a href="{{ route('contact') }}" class="w-full py-4 bg-slate-900 text-white rounded-full font-bold flex items-center justify-center gap-2 hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10">
          <i class="fas fa-envelope"></i> Me contacter
        </a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-16">
      <!-- Featured Work -->
      <div class="space-y-8">
        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
          <span class="w-8 h-px bg-primary"></span> Projets en vedette
        </h2>
        <div class="grid gap-8 md:grid-cols-2">
          @forelse($featured as $item)
            <div class="group relative bg-white rounded-[3rem] p-8 border border-slate-100 hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500 overflow-hidden">
              <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/5 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
              
              <div class="relative z-10 space-y-5">
                <span class="text-[10px] font-bold uppercase tracking-widest text-secondary bg-secondary/5 px-3 py-1 rounded-full">
                  Featured Project
                </span>
                <h3 class="text-2xl font-bold text-slate-900 leading-tight">{{ $item->title }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $item->summary }}</p>
                
                @if($item->stack)
                  <div class="flex flex-wrap gap-2 pt-2">
                    @foreach(explode(',', $item->stack) as $tech)
                      <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">#{{ trim($tech) }}</span>
                    @endforeach
                  </div>
                @endif

                @if($item->link)
                  <a href="{{ $item->link }}" target="_blank" class="inline-flex items-center gap-3 text-sm font-bold text-primary group-hover:gap-5 transition-all pt-4">
                    Voir le projet <i class="fas fa-external-link-alt text-xs"></i>
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="col-span-full py-16 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-200">
              <p class="text-slate-400">Aucun projet mis en avant pour le moment.</p>
            </div>
          @endforelse
        </div>
      </div>

      <!-- All Projects List -->
      <div class="space-y-8">
        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
          <span class="w-8 h-px bg-secondary"></span> Autres réalisations
        </h2>
        <div class="space-y-6">
          @forelse($items as $item)
            <div class="group bg-white rounded-3xl p-6 border border-slate-100 hover:border-slate-200 hover:shadow-lg transition-all flex flex-col md:flex-row md:items-center justify-between gap-6">
              <div class="space-y-2">
                <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary transition-colors">{{ $item->title }}</h3>
                <p class="text-sm text-slate-500 max-w-xl">{{ $item->summary }}</p>
                @if($item->stack)
                  <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $item->stack }}</p>
                @endif
              </div>
              @if($item->link)
                <a href="{{ $item->link }}" target="_blank" class="w-full md:w-auto px-6 py-3 bg-slate-50 text-slate-900 rounded-full text-xs font-bold hover:bg-primary hover:text-white transition-all text-center">
                  Explorer
                </a>
              @endif
            </div>
          @empty
            <p class="text-slate-400 italic">D'autres projets arriveront bientôt.</p>
          @endforelse
        </div>
        
        <div class="mt-12">
            {{ $items->links() }}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

