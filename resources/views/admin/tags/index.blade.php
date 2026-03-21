@extends('layout.app')

@section('title', 'Tags')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-heading">Tags</h1>
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary rounded-full">
      <i class="fas fa-plus mr-2"></i> Nouveau tag
    </a>
  </div>

  @if($tags->isEmpty())
    <div class="glass rounded-3xl p-12 text-center">
      <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
      <p class="text-slate-600">Aucun tag créé</p>
      <p class="text-sm text-slate-500 mt-2">Commencez par créer un tag pour catégoriser vos articles</p>
    </div>
  @else
    <div class="glass rounded-3xl overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-primary/5 border-b border-primary-100">
          <tr>
            <th class="px-6 py-3 text-left font-semibold text-primary">Nom</th>
            <th class="px-6 py-3 text-left font-semibold text-primary">Couleur</th>
            <th class="px-6 py-3 text-left font-semibold text-primary">Slug</th>
            <th class="px-6 py-3 text-center font-semibold text-primary">Articles</th>
            <th class="px-6 py-3 text-right font-semibold text-primary">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          @foreach($tags as $tag)
            @php($tagColor = $tag->color ?? '#6366f1')
            <tr class="hover:bg-primary/2 transition">
              <td class="px-6 py-3 font-medium text-ink">
                <i class="fas fa-tag mr-2 text-secondary"></i>
                {{ $tag->name }}
              </td>
              <td class="px-6 py-3">
                <div class="flex items-center gap-2">
                  <div class="w-4 h-4 rounded-full bg-slate-200 border border-slate-300"></div>
                  <code class="text-xs">{{ $tagColor }}</code>
                </div>
              </td>
              <td class="px-6 py-3 text-slate-600">
                <code class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $tag->slug }}</code>
              </td>
              <td class="px-6 py-3 text-center">
                <span class="inline-flex items-center gap-1 text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">
                  <i class="fas fa-file"></i> {{ $tag->posts_count }}
                </span>
              </td>
              <td class="px-6 py-3 text-right space-x-2">
                <a href="{{ route('admin.tags.edit', $tag) }}" class="inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-xs font-semibold">
                  <i class="fas fa-edit mr-1"></i> Éditer
                </a>
                <button 
                  type="button"
                  @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                    detail: {
                      title: 'Supprimer tag ?',
                      message: 'Cette action est irréversible. {{ $tag->posts_count }} article(s) sera/seront affecté(s).',
                      confirmText: 'Supprimer',
                      cancelText: 'Annuler',
                      type: 'danger',
                      callback: () => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route(\"admin.tags.destroy\", $tag) }}';
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

      @if($tags->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
          {{ $tags->links() }}
        </div>
      @endif
    </div>
  @endif
</div>
@endsection
