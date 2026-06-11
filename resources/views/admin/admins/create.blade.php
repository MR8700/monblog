@extends('layout.app')

@section('title', 'Créer un Administrateur - Admin')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-8">
        <div>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Nouvel Administrateur</h1>
            <p class="text-slate-600">Ajoutez un nouveau membre à votre équipe de gestion.</p>
        </div>

        <form action="{{ route('admin.admins.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-100 space-y-6">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Photo de profil</label>
                <input type="file" name="profile_picture" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                @error('profile_picture') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Nom Complet</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Mot de passe</label>
                    <input type="password" name="password" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Rôle</label>
                <select name="role" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                    <option value="admin">Administrateur standard</option>
                    <option value="super_admin">Super Administrateur (Accès total)</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-slate-50 flex gap-4">
                <a href="{{ route('admin.admins.index') }}" class="flex-1 px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold text-center hover:bg-slate-200 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-[2] px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark transition">
                    Créer l'Administrateur
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
