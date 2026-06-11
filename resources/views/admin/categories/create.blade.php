@extends('layout.app')

@section('title', 'Nouvelle catégorie')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
  <div class="mb-8">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark transition">
      <i class="fas fa-chevron-left"></i> Retour
    </a>
  </div>

  <h1 class="text-3xl font-heading mb-8">Nouvelle catégorie</h1>

  <form method="POST" action="{{ route('admin.categories.store') }}" class="glass rounded-3xl p-8 space-y-6">
    @csrf

    <div>
      <label for="name" class="block text-sm font-semibold text-ink mb-2">
        <i class="fas fa-folder text-secondary mr-2"></i> Nom *
      </label>
      <input 
        type="text" 
        id="name"
        name="name" 
        class="w-full rounded-xl border {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }} px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition" 
        placeholder="Ex: Développement"
        value="{{ old('name') }}"
        required
      >
      @error('name')
        <p class="text-danger text-sm mt-2">
          <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
        </p>
      @enderror
    </div>

    <div>
      <label for="description" class="block text-sm font-semibold text-ink mb-2">
        <i class="fas fa-align-left text-secondary mr-2"></i> Description (optionnel)
      </label>
      <textarea 
        id="description"
        name="description" 
        rows="3"
        class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition" 
        placeholder="Décrivez cette catégorie..."
      >{{ old('description') }}</textarea>
      @error('description')
        <p class="text-danger text-sm mt-2">
          <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
        </p>
      @enderror
    </div>

    <div class="flex items-center gap-4">
      <button 
        type="submit" 
        class="px-6 py-3 rounded-full font-semibold bg-primary text-white hover:bg-primary-dark transition flex items-center gap-2 shadow-glow"
      >
        <i class="fas fa-save"></i> Créer la catégorie
      </button>
      <a 
        href="{{ route('admin.categories.index') }}" 
        class="px-6 py-3 rounded-full font-semibold bg-slate-100 text-ink hover:bg-slate-200 transition flex items-center gap-2"
      >
        <i class="fas fa-times"></i> Annuler
      </a>
    </div>
  </form>
</div>
@endsection
