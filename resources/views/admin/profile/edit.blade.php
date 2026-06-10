@extends('layout.app')

@section('title', 'Mon Profil Administrateur')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12 space-y-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Gestion du <span class="text-primary italic font-display">Profil</span></h1>
            <p class="text-slate-500">Mettez à jour vos informations personnelles et vos paramètres de sécurité.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all text-xs">
            <i class="fas fa-arrow-left"></i> Retour Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-3xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Sidebar Navigation -->
        <div class="space-y-4">
            <div class="bg-white p-4 rounded-[2.5rem] border border-slate-100 shadow-soft">
                <div class="flex flex-col items-center p-6 text-center space-y-4 border-b border-slate-50 mb-4">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden shadow-2xl shadow-primary/20 border-4 border-white">
                            @if(Auth::guard('admin')->user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_picture) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white text-5xl">
                                    {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900">{{ Auth::guard('admin')->user()->name }}</h3>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary bg-primary/5 px-4 py-1.5 rounded-full inline-block mt-2">
                            {{ Auth::guard('admin')->user()->role }}
                        </p>
                    </div>
                </div>
                
                <nav class="space-y-1">
                    <a href="#personal" class="flex items-center gap-3 p-4 rounded-2xl bg-primary text-white font-bold transition-all shadow-lg shadow-primary/20">
                        <i class="fas fa-id-card w-5"></i> Informations
                    </a>
                    <a href="#security" class="flex items-center gap-3 p-4 rounded-2xl text-slate-400 hover:bg-slate-50 hover:text-slate-600 font-bold transition-all">
                        <i class="fas fa-shield-halved w-5"></i> Sécurité
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Info Card -->
            <div id="personal" class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-soft space-y-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-xl">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900">Infos <span class="text-primary italic">Perso</span></h2>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Upload Photo -->
                    <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-white shadow-sm flex-none">
                             @if(Auth::guard('admin')->user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_picture) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                    <i class="fas fa-camera text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 space-y-1">
                            <p class="text-sm font-bold text-slate-900">Photo de profil</p>
                            <p class="text-xs text-slate-500">JPG, PNG ou GIF. Max 2MB.</p>
                            <input type="file" name="profile_picture" class="mt-2 text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-primary file:text-white hover:file:bg-primary-dark transition-all">
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Nom complet</label>
                            <input type="text" name="name" value="{{ old('name', Auth::guard('admin')->user()->name) }}" required
                                   class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700 shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Adresse Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::guard('admin')->user()->email) }}" required
                                   class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700 shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Confirmation par mot de passe</label>
                        <input type="password" name="current_password" required placeholder="Tapez votre mot de passe actuel pour valider"
                               class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-red-400/5 transition-all font-bold text-slate-700 shadow-sm">
                    </div>

                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[2rem] font-black text-lg shadow-2xl shadow-slate-900/20 hover:bg-primary transition-all">
                        Sauvegarder mon profil
                    </button>
                </form>
            </div>

            <!-- Security Card -->
            <div id="security" class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-soft space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-secondary/5 text-secondary rounded-2xl flex items-center justify-center text-xl">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900">Sécurité <span class="text-secondary italic">& Accès</span></h2>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Mot de passe actuel</label>
                        <input type="password" name="current_password" required
                               class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-secondary/5 transition-all font-bold text-slate-700 shadow-sm">
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Nouveau mot de passe</label>
                            <input type="password" name="password" required
                                   class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-secondary/5 transition-all font-bold text-slate-700 shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Confirmer le nouveau</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-secondary/5 transition-all font-bold text-slate-700 shadow-sm">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-white text-secondary border-2 border-secondary/20 rounded-[2rem] font-black text-lg shadow-xl shadow-secondary/5 hover:bg-secondary hover:text-white transition-all">
                        Mettre à jour le mot de passe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
