@extends('layout.app')

@section('title', 'Éditer tag: ' . $tag->name)

@section('content')
<div class="max-w-2xl mx-auto px-6 py-12">
  <div class="mb-8">
    <a href="{{ route('admin.tags.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark transition">
      <i class="fas fa-chevron-left"></i> Retour
    </a>
  </div>

  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-heading">Éditer tag</h1>
    <span class="inline-flex items-center gap-1 text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">
      <i class="fas fa-file"></i> {{ $tag->posts_count ?? 0 }} article(s)
    </span>
  </div>

  <form method="POST" action="{{ route('admin.tags.update', $tag) }}" class="glass rounded-3xl p-8 space-y-6">
    @csrf
    @method('PUT')

    <div>
      <label for="name" class="block text-sm font-semibold text-ink mb-2">
        <i class="fas fa-tag text-secondary mr-2"></i> Nom *
      </label>
      <input 
        type="text" 
        id="name"
        name="name" 
        class="w-full rounded-xl border {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }} px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition" 
        placeholder="Ex: Laravel"
        value="{{ old('name', $tag->name) }}"
        required
      >
      @error('name')
        <p class="text-danger text-sm mt-2">
          <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
        </p>
      @enderror
    </div>

    <div>
      <label for="color" class="block text-sm font-semibold text-ink mb-2">
        <i class="fas fa-palette text-secondary mr-2"></i> Couleur
      </label>
      <div class="flex items-center gap-3">
        <input 
          type="color" 
          id="color"
          name="color" 
          class="rounded-lg cursor-pointer w-12 h-12" 
          value="{{ old('color', $tag->color ?? '#6366f1') }}"
        >
        <input 
          type="text" 
          class="flex-1 rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition text-sm"
          placeholder="#6366f1"
          readonly
          id="colorText"
        >
      </div>
      <p class="text-xs text-slate-500 mt-2">
        <i class="fas fa-info-circle mr-1"></i> Choisissez une couleur pour identifier ce tag
      </p>
    </div>

    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
      <p class="text-xs text-slate-600">
        <i class="fas fa-info-circle text-secondary mr-2"></i>
        <strong>Slug:</strong> <code>{{ $tag->slug }}</code>
      </p>
    </div>

    <script>
      document.getElementById('color').addEventListener('input', (e) => {
        document.getElementById('colorText').value = e.target.value.toUpperCase();
      });
      document.getElementById('colorText').value = document.getElementById('color').value.toUpperCase();
    </script>

    <div class="flex items-center gap-4">
      <button 
        type="submit" 
        class="px-6 py-3 rounded-full font-semibold bg-primary text-white hover:bg-primary-dark transition flex items-center gap-2 shadow-glow"
      >
        <i class="fas fa-save"></i> Enregistrer les modifications
      </button>
      <a 
        href="{{ route('admin.tags.index') }}" 
        class="px-6 py-3 rounded-full font-semibold bg-slate-100 text-ink hover:bg-slate-200 transition flex items-center gap-2"
      >
        <i class="fas fa-times"></i> Annuler
      </a>
    </div>
  </form>
</div>
@endsection
