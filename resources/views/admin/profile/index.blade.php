@extends('layout.app')

@section('title', 'Mon profil')

@section('content')
<div class="max-w-2xl mx-auto p-8 bg-white rounded-3xl shadow-md text-center">

    <h1 class="text-3xl font-bold text-primary mb-6">Mon profil</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <p class="mb-2"><strong>Nom :</strong> {{ $admin->name }}</p>
    <p class="mb-2"><strong>Email :</strong> {{ $admin->email }}</p>

    <a href="{{ route('admin.profile.edit') }}"
       class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-full shadow hover:bg-blue-700 transition">
       Modifier mon profil
    </a>
</div>
@endsection
