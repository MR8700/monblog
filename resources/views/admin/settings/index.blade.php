@extends('layout.app')

@section('title', 'Paramètres - Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-12">
        <!-- Header -->
        <div>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Paramètres du Site</h1>
            <p class="text-slate-600">Gérez l'identité visuelle, la configuration email et la maintenance du site.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Navigation des onglets -->
            <div class="lg:col-span-1">
                <nav class="flex flex-col gap-2 sticky top-24">
                    <a href="#visual" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-white border border-slate-100 text-slate-600 hover:bg-slate-50 transition font-semibold shadow-sm shadow-slate-200/50 group active:bg-primary active:text-white">
                        <i class="fas fa-palette"></i>
                        Identité Visuelle
                    </a>
                    <a href="#email" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-white border border-slate-100 text-slate-600 hover:bg-slate-50 transition font-semibold shadow-sm shadow-slate-200/50 group">
                        <i class="fas fa-envelope"></i>
                        Configuration Email
                    </a>
                    <a href="#services" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-white border border-slate-100 text-slate-600 hover:bg-slate-50 transition font-semibold shadow-sm shadow-slate-200/50 group">
                        <i class="fas fa-concierge-bell"></i>
                        Types de Service
                    </a>
                    <a href="#maintenance" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-white border border-slate-100 text-slate-600 hover:bg-slate-50 transition font-semibold shadow-sm shadow-slate-200/50 group">
                        <i class="fas fa-tools"></i>
                        Maintenance & Backup
                    </a>
                </nav>
            </div>

            <!-- Contenu des onglets -->
            <div class="lg:col-span-2 space-y-12">
                
                <!-- Identité Visuelle -->
                <div id="visual" class="bg-white p-8 md:p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-100 scroll-mt-24">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fas fa-palette text-primary"></i>
                        Identité Visuelle
                    </h2>
                    
                    <form action="{{ route('admin.settings.visual') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Nom du Site</label>
                                <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name') }}" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition" placeholder="Mon Blog">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Couleur Primaire</label>
                                <div class="flex gap-2">
                                    <input type="color" name="primary_color" value="{{ \App\Models\Setting::get('primary_color', '#000000') }}" class="h-12 w-12 rounded-lg border-none">
                                    <input type="text" readonly value="{{ \App\Models\Setting::get('primary_color', '#000000') }}" class="flex-1 px-5 py-3 rounded-2xl border-slate-200 bg-slate-50 text-slate-500">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Logo</label>
                                <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                @if($logo = \App\Models\Setting::get('site_logo'))
                                    <div class="mt-2 p-2 bg-slate-50 rounded-xl inline-block">
                                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10">
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Favicon</label>
                                <input type="file" name="favicon" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                @if($favicon = \App\Models\Setting::get('site_favicon'))
                                    <div class="mt-2 p-2 bg-slate-50 rounded-xl inline-block">
                                        <img src="{{ asset('storage/' . $favicon) }}" alt="Favicon" class="h-8 w-8">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <div class="flex flex-col gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-red-600 flex items-center gap-2">
                                        <i class="fas fa-lock text-xs"></i> Confirmation requise
                                    </label>
                                    <input type="password" name="current_password" required class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-red-400 focus:ring-red-400 transition" placeholder="Votre mot de passe actuel">
                                </div>
                                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-4 px-8 rounded-2xl transition shadow-lg shadow-primary/20">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Configuration Email -->
                <div id="email" class="bg-white p-8 md:p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-100 scroll-mt-24">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fas fa-envelope text-primary"></i>
                        Configuration Email
                    </h2>
                    
                    <form action="{{ route('admin.settings.email') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Serveur SMTP</label>
                                <input type="text" name="mail_host" value="{{ \App\Models\Setting::get('mail_host') }}" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition" placeholder="smtp.mailtrap.io">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Port SMTP</label>
                                <input type="number" name="mail_port" value="{{ \App\Models\Setting::get('mail_port') }}" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition" placeholder="2525">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Utilisateur SMTP</label>
                                <input type="text" name="mail_username" value="{{ \App\Models\Setting::get('mail_username') }}" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Mot de passe SMTP</label>
                                <input type="password" name="mail_password" value="{{ \App\Models\Setting::get('mail_password') }}" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Chiffrement</label>
                                <select name="mail_encryption" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition">
                                    <option value="" {{ \App\Models\Setting::get('mail_encryption') == '' ? 'selected' : '' }}>Aucun</option>
                                    <option value="tls" {{ \App\Models\Setting::get('mail_encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ \App\Models\Setting::get('mail_encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Email Expéditeur</label>
                                <input type="email" name="mail_from_address" value="{{ \App\Models\Setting::get('mail_from_address') }}" class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition" placeholder="admin@example.com">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <div class="flex flex-col gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-red-600 flex items-center gap-2">
                                        <i class="fas fa-lock text-xs"></i> Confirmation requise
                                    </label>
                                    <input type="password" name="current_password" required class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-red-400 focus:ring-red-400 transition" placeholder="Votre mot de passe actuel">
                                </div>
                                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-4 px-8 rounded-2xl transition shadow-lg shadow-primary/20">
                                    Enregistrer la configuration email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Types de Service -->
                <div id="services" class="bg-white p-8 md:p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-100 scroll-mt-24">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fas fa-concierge-bell text-primary"></i>
                        Types de Service
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Liste des services existants -->
                        <div class="grid gap-4">
                            @forelse($serviceTypes as $type)
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="flex items-center gap-4">
                                        <div class="w-2 h-2 rounded-full {{ $type->is_active ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        <span class="font-bold {{ $type->is_active ? 'text-slate-900' : 'text-slate-400' }}">{{ $type->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.settings.service-types.toggle', $type) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold px-3 py-1 rounded-full {{ $type->is_active ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition">
                                                {{ $type->is_active ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.settings.service-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Supprimer ce type de service ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold px-3 py-1 bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 italic">Aucun type de service enregistré.</p>
                            @endforelse
                        </div>

                        <!-- Formulaire d'ajout -->
                        <form action="{{ route('admin.settings.service-types') }}" method="POST" class="pt-6 border-t border-slate-100 space-y-4">
                            @csrf
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Nom du nouveau type</label>
                                    <input type="text" name="name" required class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-primary focus:ring-primary transition" placeholder="Ex: Développement Web">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-red-600 flex items-center gap-2">
                                        <i class="fas fa-lock text-xs"></i> Confirmation requise
                                    </label>
                                    <input type="password" name="current_password" required class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-red-400 focus:ring-red-400 transition" placeholder="Votre mot de passe actuel">
                                </div>
                                <button type="submit" class="w-full bg-slate-900 text-white px-6 py-4 rounded-2xl font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-900/10">
                                    Ajouter le type de service
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Maintenance & Backup -->
                <div id="maintenance" class="bg-white p-8 md:p-10 rounded-[3rem] shadow-xl shadow-slate-200/60 border border-slate-100 scroll-mt-24">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fas fa-tools text-primary"></i>
                        Maintenance & Backup
                    </h2>
                    
                    <div class="p-6 bg-yellow-50 rounded-3xl border border-yellow-100 mb-8">
                        <div class="flex gap-4">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            <div>
                                <h4 class="font-bold text-yellow-800">Attention</h4>
                                <p class="text-sm text-yellow-700">La sauvegarde de la base de données peut prendre quelques instants. Ne fermez pas votre navigateur pendant l'opération.</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.settings.backup') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="flex flex-col gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-red-600 flex items-center gap-2">
                                    <i class="fas fa-lock text-xs"></i> Confirmation requise
                                </label>
                                <input type="password" name="current_password" required class="w-full px-5 py-3 rounded-2xl border-slate-200 focus:border-red-400 focus:ring-red-400 transition" placeholder="Votre mot de passe actuel">
                            </div>
                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-8 rounded-2xl transition shadow-lg flex items-center justify-center gap-3">
                                <i class="fas fa-database"></i>
                                Lancer une sauvegarde complète
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
