@extends('layout.app')

@section('title', 'À Propos - DigitalSpace')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-20 space-y-24">
    <!-- Hero Section -->
    <div class="text-center space-y-8">
        <h1 class="text-6xl md:text-8xl font-black text-slate-900 tracking-tighter">
            Votre Partenaire <br>
            <span class="text-primary italic font-display">Digital de Confiance</span>
        </h1>
        <p class="text-xl text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
            Nous transformons vos idées en réalité numérique. De la conception à la mise en ligne, DigitalSpace est à vos côtés pour bâtir l'avenir de votre entreprise.
        </p>
    </div>

    <!-- Site Advantages -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="space-y-6 p-10 bg-white rounded-[3rem] border border-slate-100 shadow-soft hover:border-primary transition-all group">
            <div class="w-16 h-16 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-3xl group-hover:bg-primary group-hover:text-white transition-all">
                <i class="fas fa-rocket"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900">Expertise Technique</h3>
            <p class="text-slate-500 leading-relaxed">
                Nos solutions sont basées sur les technologies les plus modernes et performantes (Laravel, React, AWS) pour garantir rapidité et sécurité.
            </p>
        </div>

        <div class="space-y-6 p-10 bg-white rounded-[3rem] border border-slate-100 shadow-soft hover:border-secondary transition-all group">
            <div class="w-16 h-16 bg-secondary/5 text-secondary rounded-2xl flex items-center justify-center text-3xl group-hover:bg-secondary group-hover:text-white transition-all">
                <i class="fas fa-paint-brush"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900">Design Intuitif</h3>
            <p class="text-slate-500 leading-relaxed">
                Nous créons des interfaces qui ne sont pas seulement belles, mais surtout centrées sur l'utilisateur pour maximiser vos conversions.
            </p>
        </div>

        <div class="space-y-6 p-10 bg-white rounded-[3rem] border border-slate-100 shadow-soft hover:border-indigo-500 transition-all group">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-indigo-500 group-hover:text-white transition-all">
                <i class="fas fa-headset"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900">Accompagnement</h3>
            <p class="text-slate-500 leading-relaxed">
                Notre équipe est disponible 24/7 pour répondre à vos besoins et assurer la maintenance continue de vos plateformes digitales.
            </p>
        </div>
    </div>

    <!-- Admin Section -->
    <div class="space-y-16">
        <div class="text-center space-y-4">
            <h2 class="text-4xl font-black text-slate-900">L'Équipe <span class="text-primary">Derrière le Code</span></h2>
            <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Des talents passionnés à votre service</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach($admins as $admin)
                <div class="bg-slate-900 p-12 rounded-[4rem] text-white flex flex-col md:flex-row gap-10 items-center md:items-start group hover:bg-slate-800 transition-all">
                    <div class="w-48 h-48 rounded-[3rem] overflow-hidden border-4 border-white/10 flex-none group-hover:scale-105 transition-transform">
                        @if($admin->profile_picture)
                            <img src="{{ asset('storage/' . $admin->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-6xl font-black">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="space-y-6 text-center md:text-left">
                        <div>
                            <h3 class="text-3xl font-black italic font-display">{{ $admin->name }}</h3>
                            <p class="text-primary font-bold">{{ $admin->specialty }}</p>
                        </div>
                        <p class="text-slate-400 leading-relaxed">
                            {{ $admin->bio }}
                        </p>
                        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                            @if($admin->skills)
                                @foreach($admin->skills as $skill)
                                    <span class="px-4 py-2 bg-white/10 rounded-xl text-xs font-bold">{{ $skill }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Site Benefits Call to Action -->
    <div class="bg-gradient-to-br from-primary to-primary-dark p-16 rounded-[4rem] text-center text-white space-y-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48"></div>
        <div class="relative space-y-6">
            <h2 class="text-4xl md:text-5xl font-black tracking-tight">Prêt à lancer votre projet ?</h2>
            <p class="text-xl text-white/80 max-w-2xl mx-auto font-medium">
                Rejoignez des centaines d'entreprises qui nous font déjà confiance pour leur présence en ligne. Profitez de notre expertise et de nos outils premium.
            </p>
            <div class="flex flex-col md:flex-row gap-6 justify-center pt-4">
                <a href="{{ route('services.request') }}" class="px-10 py-5 bg-white text-primary rounded-3xl font-black shadow-2xl hover:bg-slate-900 hover:text-white transition-all">
                    Demander un Devis
                </a>
                <a href="{{ route('products.publicIndex') }}" class="px-10 py-5 bg-primary-dark text-white rounded-3xl font-black shadow-2xl hover:bg-white hover:text-primary transition-all">
                    Voir la Boutique
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
