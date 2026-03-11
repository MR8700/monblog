@extends('layout.app')

@section('title', 'Connexion Admin')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center px-6 py-14">
  <div class="glass rounded-3xl p-8 w-full max-w-md">
    <h1 class="text-2xl font-display text-primary mb-6 text-center">Connexion admin</h1>

    @if(session('error'))
      <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-center">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block mb-1 text-sm font-semibold">Email</label>
        <input type="email" name="email" required
               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-secondary">
      </div>
      <div>
        <label class="block mb-1 text-sm font-semibold">Mot de passe</label>
        <input type="password" name="password" required
               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-secondary">
      </div>
      <button type="submit" class="btn btn-primary rounded-full w-full">Se connecter</button>
    </form>
  </div>
</section>
@endsection
