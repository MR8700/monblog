@extends('layout.app')

@section('title', 'Nouvel article')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
  <div class="mb-8">
    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark transition">
      <i class="fas fa-chevron-left"></i> Retour
    </a>
  </div>

  <h1 class="text-3xl font-heading mb-8">Nouvel article</h1>

  <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <!-- Main Content -->
    <div class="glass rounded-3xl p-8 space-y-6">
      <div>
        <label for="title" class="block text-sm font-semibold text-ink mb-2">
          <i class="fas fa-heading text-secondary mr-2"></i> Titre *
        </label>
        <input 
          type="text" 
          id="title"
          name="title" 
          class="w-full rounded-xl border {{ $errors->has('title') ? 'border-danger' : 'border-slate-200' }} px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition" 
          placeholder="Entrez le titre..."
          value="{{ old('title') }}"
          required
        >
        @error('title')
          <p class="text-danger text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="excerpt" class="block text-sm font-semibold text-ink mb-2">
          <i class="fas fa-quote-left text-secondary mr-2"></i> Résumé (optionnel)
        </label>
        <textarea 
          id="excerpt"
          name="excerpt" 
          rows="2"
          class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition" 
          placeholder="Un court résumé de l'article..."
        >{{ old('excerpt') }}</textarea>
      </div>

      <div>
        <label for="body" class="block text-sm font-semibold text-ink mb-2">
          <i class="fas fa-file-alt text-secondary mr-2"></i> Contenu *
        </label>
        <textarea 
          id="body"
          name="body" 
          rows="12"
          class="w-full rounded-xl border {{ $errors->has('body') ? 'border-danger' : 'border-slate-200' }} px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition font-mono text-sm" 
          placeholder="Écrivez votre article..."
          required
        >{{ old('body') }}</textarea>
        @error('body')
          <p class="text-danger text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="cover_image" class="block text-sm font-semibold text-ink mb-2">
          <i class="fas fa-image text-secondary mr-2"></i> Image de couverture
        </label>
        <input 
          type="file" 
          id="cover_image"
          name="cover_image" 
          accept="image/*"
          class="w-full"
        >
        <p class="text-xs text-slate-500 mt-2">JPG, PNG ou GIF. Max 5MB</p>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="md:col-span-2">
        <!-- Category & Tags -->
        <div class="glass rounded-3xl p-8 space-y-6">
          <div>
            <label for="category_id" class="block text-sm font-semibold text-ink mb-2">
              <i class="fas fa-folder text-secondary mr-2"></i> Catégorie
            </label>
            <select 
              id="category_id"
              name="category_id" 
              class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition"
            >
              <option value="">Sélectionner une catégorie...</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label for="tags" class="block text-sm font-semibold text-ink mb-2">
              <i class="fas fa-tag text-secondary mr-2"></i> Tags
            </label>
            <div class="max-h-32 overflow-y-auto p-3 border border-slate-200 rounded-xl">
              @foreach($tags as $tag)
                <label class="flex items-center gap-2 mb-2 last:mb-0">
                  <input 
                    type="checkbox" 
                    name="tags[]" 
                    value="{{ $tag->id }}"
                    class="rounded"
                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                  >
                  <span class="flex items-center gap-1">
                    <i class="fas fa-tag text-xs text-secondary"></i>
                    {{ $tag->name }}
                    @if($tag->color)
                      <code class="text-[10px] text-slate-500">{{ $tag->color }}</code>
                    @endif
                  </span>
                </label>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div>
        <!-- Status & Options -->
        <div class="glass rounded-3xl p-8 space-y-6 sticky top-24">
          <div>
            <label for="status" class="block text-sm font-semibold text-ink mb-2">
              <i class="fas fa-circle text-secondary mr-2"></i> Statut
            </label>
            <select 
              id="status"
              name="status" 
              class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition"
            >
              @foreach(\App\Enums\PostStatus::cases() as $status)
                <option value="{{ $status->value }}" {{ old('status', \App\Enums\PostStatus::DRAFT->value) == $status->value ? 'selected' : '' }}>
                  {{ $status->label() }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label for="visibility" class="block text-sm font-semibold text-ink mb-2">
              <i class="fas fa-eye text-secondary mr-2"></i> Visibilité
            </label>
            <select 
              id="visibility"
              name="visibility" 
              class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition"
            >
              @foreach(\App\Enums\PostVisibility::cases() as $visibility)
                <option value="{{ $visibility->value }}" {{ old('visibility', \App\Enums\PostVisibility::PUBLIC->value) == $visibility->value ? 'selected' : '' }}>
                  {{ $visibility->label() }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label for="published_at" class="block text-sm font-semibold text-ink mb-2">
              <i class="fas fa-calendar text-secondary mr-2"></i> Date de publication
            </label>
            <input 
              type="datetime-local" 
              id="published_at"
              name="published_at"
              class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition"
              value="{{ old('published_at') }}"
            >
          </div>

          <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg">
            <input 
              type="checkbox"
              id="featured"
              name="featured"
              class="rounded"
              {{ old('featured') ? 'checked' : '' }}
            >
            <label for="featured" class="text-sm font-medium">
              <i class="fas fa-star text-amber-500 mr-1"></i> En vedette
            </label>
          </div>

          <div class="flex items-center gap-2">
            <button 
              type="submit"
              class="flex-1 px-4 py-3 rounded-full font-semibold bg-primary text-white hover:bg-primary-dark transition flex items-center justify-center gap-2 shadow-glow"
            >
              <i class="fas fa-save"></i> Créer l'article
            </button>
            <a 
              href="{{ route('admin.posts.index') }}"
              class="px-4 py-3 rounded-full font-semibold bg-slate-100 text-ink hover:bg-slate-200 transition"
            >
              <i class="fas fa-times"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
