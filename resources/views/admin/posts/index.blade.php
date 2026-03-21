@extends('layout.app')

@section('title', 'Articles admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-heading">Articles</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary rounded-full">
      <i class="fas fa-plus mr-2"></i> Nouvel article
    </a>
  </div>

  @if($posts->isEmpty())
    <div class="glass rounded-3xl p-12 text-center">
      <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
      <p class="text-slate-600">Aucun article créé</p>
      <p class="text-sm text-slate-500 mt-2">Commencez par créer un nouvel article</p>
    </div>
  @else
    <div class="glass rounded-3xl overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-primary/5 border-b border-primary-100">
          <tr>
            <th class="px-6 py-3 text-left font-semibold text-primary">Titre</th>
            <th class="px-6 py-3 text-left font-semibold text-primary">Statut</th>
            <th class="px-6 py-3 text-center font-semibold text-primary">Visibilité</th>
            <th class="px-6 py-3 text-center font-semibold text-primary">Vues</th>
            <th class="px-6 py-3 text-left font-semibold text-primary">Date</th>
            <th class="px-6 py-3 text-right font-semibold text-primary">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          @foreach($posts as $post)
            @php
              $statusColor = match ($post->status) {
                  \App\Enums\PostStatus::PUBLISHED => 'green',
                  \App\Enums\PostStatus::ARCHIVED => 'red',
                  default => 'yellow',
              };

              $visibilityColor = match ($post->visibility) {
                  \App\Enums\PostVisibility::PUBLIC => 'blue',
                  \App\Enums\PostVisibility::PRIVATE => 'purple',
                  default => 'slate',
              };

              $statusClasses = match ($post->status) {
                  default => 'bg-' . $statusColor . '-100 text-' . $statusColor . '-700',
              };

              $visibilityClasses = match ($post->visibility) {
                  default => 'bg-' . $visibilityColor . '-100 text-' . $visibilityColor . '-700',
              };
            @endphp
            <tr class="hover:bg-primary/2 transition">
              <td class="px-6 py-4 font-medium text-ink">
                <a href="{{ route('admin.posts.show', $post) }}" class="hover:text-primary transition">
                  {{ $post->title }}
                </a>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full font-semibold {{ $statusClasses }}">
                  <i class="fas fa-circle text-xs"></i>
                  {{ $post->status->label() }}
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full font-semibold {{ $visibilityClasses }}">
                  <i class="fas fa-eye text-xs"></i>
                  {{ $post->visibility->label() }}
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <span class="inline-flex items-center gap-1 text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">
                  <i class="fas fa-eye"></i> {{ $post->views_count ?? 0 }}
                </span>
              </td>
              <td class="px-6 py-4 text-slate-600 text-xs">
                {{ $post->published_at?->format('d M Y') ?? 'Non définie' }}
              </td>
              <td class="px-6 py-4 text-right space-x-2">
                <a href="{{ route('admin.posts.show', $post) }}" class="inline-block px-3 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-xs font-semibold">
                  <i class="fas fa-eye mr-1"></i> Voir
                </a>
                <a href="{{ route('admin.posts.edit', $post) }}" class="inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-xs font-semibold">
                  <i class="fas fa-edit mr-1"></i> Éditer
                </a>
                <button 
                  type="button"
                  @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                    detail: {
                      title: 'Supprimer l\'article ?',
                      message: '{{ addslashes($post->title) }}',
                      confirmText: 'Supprimer',
                      cancelText: 'Annuler',
                      type: 'danger',
                      callback: () => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route(\"admin.posts.destroy\", $post) }}';
                        form.innerHTML = '@csrf @method(\"DELETE\")<button type=\"submit\"></button>';
                        document.body.appendChild(form);
                        return new Promise(resolve => {
                          form.addEventListener('submit', (e) => {
                            form.submit();
                            resolve();
                          });
                          form.querySelector('button').click();
                        });
                      }
                    }
                  }))"
                  class="inline-block px-3 py-1 rounded-lg bg-danger/10 text-danger hover:bg-danger/20 transition text-xs font-semibold"
                >
                  <i class="fas fa-trash mr-1"></i> Supprimer
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
          {{ $posts->links() }}
        </div>
      @endif
    </div>
  @endif
</section>
@endsection
