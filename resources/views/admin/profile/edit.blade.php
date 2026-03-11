@extends('layout.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="max-w-2xl mx-auto p-8 bg-white rounded-3xl shadow-md">

    <h1 class="text-3xl font-bold text-primary mb-6 text-center">Modifier mon profil</h1>

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                   class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                   class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Nouveau mot de passe (optionnel)</label>
            <input type="password" name="password"
                   class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation"
                   class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="text-center pt-4">
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-full shadow-md hover:shadow-lg hover:scale-[1.05] transition-all">
                💾 Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
