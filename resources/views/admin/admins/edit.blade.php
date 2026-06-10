@extends('layout.app')

@section('title', 'Modifier l\'Administrateur - Admin')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-8">
        <div>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Modifier l'Admin</h1>
            <p class="text-slate-600">Mise à jour des informations de {{ $admin->name }}.</p>
        </div>

        <form action="{{ route('admin.admins.update', $admin) }}" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-100 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <label class="text-sm font-semibold text-slate-700">Photo de profil</label>
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-100 flex-none border border-slate-200 shadow-sm">
                        @if($admin->profile_picture)
                            <img src="{{ asset('storage/' . $admin->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="profile_picture" class="flex-1 text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-slate-100 file:text-slate-600 hover:file:bg-slate-200 transition-all">
                </div>
                @error('profile_picture') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Nom Complet</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                <p class="text-sm text-slate-500 mb-4">Laissez les champs de mot de passe vides si vous ne souhaitez pas les modifier.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Nouveau mot de passe</label>
                        <input type="password" name="password" class="w-full px-6 py-4 rounded-2xl bg-white border-transparent focus:ring-4 focus:ring-primary/5 transition-all font-medium shadow-sm">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="w-full px-6 py-4 rounded-2xl bg-white border-transparent focus:ring-4 focus:ring-primary/5 transition-all font-medium shadow-sm">
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-700">Rôle</label>
                <select name="role" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                    <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Administrateur standard</option>
                    <option value="super_admin" {{ old('role', $admin->role) == 'super_admin' ? 'selected' : '' }}>Super Administrateur (Accès total)</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-slate-50 flex gap-4">
                <a href="{{ route('admin.admins.index') }}" class="flex-1 px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold text-center hover:bg-slate-200 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-[2] px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark transition">
                    Mettre à jour l'Administrateur
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
