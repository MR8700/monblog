@extends('layout.app')

@section('title', $post->title . ' - Admin')

@section('content')
@php
  $statusClasses = $post->status === \App\Enums\PostStatus::PUBLISHED
      ? 'bg-green-100 text-green-700'
      : 'bg-yellow-100 text-yellow-700';

  $visibilityClasses = $post->visibility === \App\Enums\PostVisibility::PUBLIC
      ? 'bg-blue-100 text-blue-700'
      : 'bg-purple-100 text-purple-700';

  $featureButtonClasses = $post->featured
      ? 'bg-slate-100 text-slate-700 hover:bg-slate-200'
      : 'bg-amber-100 text-amber-700 hover:bg-amber-200';
@endphp
<div class="max-w-4xl mx-auto px-6 py-12">
  <!-- Header avec actions -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <a href="{{ route('admin.posts.index') }}" class="text-primary hover:text-primary-dark transition mb-2 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Retour aux articles
      </a>
      <h1 class="text-3xl font-heading">{{ $post->title }}</h1>
      <p class="text-slate-600 mt-1">
        <span class="text-sm">
          <i class="fas fa-calendar mr-1"></i>
          {{ $post->published_at?->format('d M Y') ?? 'Non publié' }}
        </span>
      </p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary rounded-full">
        <i class="fas fa-edit mr-1"></i> Modifier
      </a>
      <button 
        onclick="confirmDelete()"
        class="btn bg-red-600 text-white hover:bg-red-700 rounded-full"
      >
        <i class="fas fa-trash mr-1"></i> Supprimer
      </button>
    </div>
  </div>

  <!-- Status badges -->
  <div class="flex flex-wrap gap-2 mb-8">
    <span class="px-3 py-1 text-sm rounded-full font-medium {{ $statusClasses }}">
      <i class="fas fa-circle text-xs mr-1"></i>
      {{ $post->status->label() }}
    </span>
    <span class="px-3 py-1 text-sm rounded-full font-medium {{ $visibilityClasses }}">
      <i class="fas fa-eye text-xs mr-1"></i>
      {{ $post->visibility->label() }}
    </span>
    @if($post->featured)
      <span class="px-3 py-1 text-sm rounded-full font-medium bg-amber-100 text-amber-700">
        <i class="fas fa-star text-xs mr-1"></i> En vedette
      </span>
    @endif
    @if($post->is_premium)
      <span class="px-3 py-1 text-sm rounded-full font-medium bg-blue-100 text-blue-700">
        <i class="fas fa-crown text-xs mr-1"></i> Premium
      </span>
    @endif
    @if($post->price > 0)
      <span class="px-3 py-1 text-sm rounded-full font-medium bg-green-100 text-green-700">
        <i class="fas fa-tag text-xs mr-1"></i> {{ number_format($post->price, 0, ',', ' ') }} CFA
      </span>
    @endif
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Cover Image -->
      @if($post->cover_image)
        <div class="glass rounded-2xl overflow-hidden">
          <img 
            src="{{ $post->cover_image }}" 
            alt="{{ $post->title }}"
            class="w-full h-80 object-cover"
          >
        </div>
      @endif

      <!-- Excerpt -->
      @if($post->excerpt)
        <div class="glass rounded-2xl p-6">
          <h3 class="font-semibold mb-2">Résumé</h3>
          <p class="text-slate-700">{{ $post->excerpt }}</p>
        </div>
      @endif

      <!-- Content -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-semibold mb-4">Contenu</h3>
        <div class="prose prose-sm max-w-none text-slate-800 leading-relaxed">
          {!! nl2br(e($post->body)) !!}
        </div>
      </div>

      <!-- Medias -->
      @if($post->medias->count() > 0)
        <div class="glass rounded-2xl p-6">
          <h3 class="font-semibold mb-4">
            <i class="fas fa-images mr-2"></i> Médias ({{ $post->medias->count() }})
          </h3>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @foreach($post->medias as $media)
              <div class="relative group rounded-lg overflow-hidden bg-slate-100 aspect-square">
                @if($media->is_image)
                  <img 
                    src="{{ $media->url }}" 
                    alt="Media"
                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                  >
                @else
                  <div class="w-full h-full flex items-center justify-center bg-slate-200">
                    <i class="fas {{ $media->icon() }} text-2xl text-slate-600"></i>
                  </div>
                @endif
                
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                  <a 
                    href="{{ $media->url }}" 
                    target="_blank"
                    class="p-2 bg-white rounded-lg text-slate-700 hover:text-primary transition"
                    title="Aperçu"
                  >
                    <i class="fas fa-external-link-alt"></i>
                  </a>
                  <button 
                    type="button"
                    class="p-2 bg-white rounded-lg text-red-600 hover:bg-red-50 transition"
                    data-media-id="{{ $media->id }}"
                    onclick="deleteMedia(this.dataset.mediaId)"
                    title="Supprimer"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </div>

                <!-- File size -->
                <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                  {{ $media->sizeFormatted() }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <!-- Sidebar Stats -->
    <div class="space-y-4">
      <!-- Post Stats -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-semibold mb-4">Statistiques</h3>
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-slate-600 flex items-center gap-2">
              <i class="fas fa-eye text-primary"></i> Vues
            </span>
            <span class="font-semibold text-lg">{{ number_format($post->views_count ?? 0) }}</span>
          </div>
          <div class="flex items-center justify-between border-t pt-3">
            <span class="text-slate-600 flex items-center gap-2">
              <i class="fas fa-comments text-blue-500"></i> Commentaires
            </span>
            <span class="font-semibold text-lg">{{ $post->comments_count ?? 0 }}</span>
          </div>
          <div class="flex items-center justify-between border-t pt-3">
            <span class="text-slate-600 flex items-center gap-2">
              <i class="fas fa-heart text-red-500"></i> Réactions
            </span>
            <span class="font-semibold text-lg">{{ $post->reactions_count ?? 0 }}</span>
          </div>
          <div class="flex items-center justify-between border-t pt-3">
            <span class="text-slate-600 flex items-center gap-2">
              <i class="fas fa-clock text-amber-500"></i> Lecture
            </span>
            <span class="font-semibold">{{ $post->reading_time_formatted }}</span>
          </div>
        </div>
      </div>

      <!-- Meta Information -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-semibold mb-4">Informations</h3>
        <div class="space-y-3 text-sm">
          @if($post->category)
            <div>
              <span class="text-slate-600 block mb-1">Catégorie</span>
              <a href="{{ route('admin.categories.edit', $post->category) }}" class="text-primary hover:underline">
                {{ $post->category->name }}
              </a>
            </div>
          @endif

          @if($post->tags->count() > 0)
            <div class="border-t pt-3">
              <span class="text-slate-600 block mb-2">Tags</span>
              <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                  <span class="px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $tag->name }}
                    @if($tag->color)
                      <span class="ml-1 font-mono text-[10px] text-slate-500">{{ $tag->color }}</span>
                    @endif
                  </span>
                @endforeach
              </div>
            </div>
          @endif

          <div class="border-t pt-3">
            <span class="text-slate-600 block mb-1">Slug</span>
            <code class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-700">{{ $post->slug }}</code>
          </div>

          <div class="border-t pt-3">
            <span class="text-slate-600 block mb-1">Auteur</span>
            <p>{{ $post->admin->name ?? 'Inconnu' }}</p>
          </div>

          <div class="border-t pt-3">
            <span class="text-slate-600 block mb-1">Créé le</span>
            <p>{{ $post->created_at->format('d/m/Y H:i') }}</p>
          </div>

          <div class="border-t pt-3">
            <span class="text-slate-600 block mb-1">Modifié le</span>
            <p>{{ $post->updated_at->format('d/m/Y H:i') }}</p>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="glass rounded-2xl p-6 space-y-2">
        <h3 class="font-semibold mb-3">Actions</h3>
        <a 
          href="{{ route('blog.show', $post) }}" 
          target="_blank"
          class="w-full px-4 py-2 text-sm rounded-lg border border-primary text-primary hover:bg-primary/5 transition flex items-center justify-center gap-2"
        >
          <i class="fas fa-external-link-alt"></i> Voir en ligne
        </a>
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="w-full">
          @csrf
          @method('PUT')
          <input type="hidden" name="featured" value="{{ (int)!$post->featured }}">
          <button 
            type="submit"
            class="w-full px-4 py-2 text-sm rounded-lg font-medium transition {{ $featureButtonClasses }}"
          >
            <i class="fas fa-star mr-1"></i> {{ $post->featured ? 'Enlever de vedette' : 'Mettre en vedette' }}
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete form (hidden) -->
  <form id="deleteForm" action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>
</div>

<script>
function confirmDelete() {
  window.dispatchEvent(new CustomEvent('open-confirm', {
    detail: {
      title: 'Supprimer cet article ?',
      message: 'Cette action est irréversible. L\'article et tous ses commentaires seront supprimés.',
      confirmText: 'Supprimer',
      type: 'danger',
      callback: () => document.getElementById('deleteForm').submit()
    }
  }));
}

function deleteMedia(mediaId) {
  window.dispatchEvent(new CustomEvent('open-confirm', {
    detail: {
      title: 'Supprimer ce média ?',
      message: 'Le média sera supprimé de cet article.',
      confirmText: 'Supprimer',
      type: 'danger',
      callback: () => {
        // Requête AJAX pour supprimer le média
        return fetch(`/admin/medias/${mediaId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            'Accept': 'application/json'
          }
        }).then(r => r.json()).then(data => {
          if (data.success) {
            location.reload();
          }
        });
      }
    }
  }));
}
</script>
@endsection
