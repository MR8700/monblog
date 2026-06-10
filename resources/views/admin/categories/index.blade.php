@extends('layout.app')

@section('title', 'Catégories')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-heading">Catégories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-full">
      <i class="fas fa-plus mr-2"></i> Nouvelle catégorie
    </a>
  </div>

  @if($categories->isEmpty())
    <div class="glass rounded-3xl p-12 text-center">
      <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
      <p class="text-slate-600">Aucune catégorie créée</p>
      <p class="text-sm text-slate-500 mt-2">Commencez par créer une catégorie pour organiser vos articles</p>
    </div>
  @else
    <div class="glass rounded-3xl overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-primary/5 border-b border-primary-100">
          <tr>
            <th class="px-6 py-3 text-left font-semibold text-primary">Nom</th>
            <th class="px-6 py-3 text-left font-semibold text-primary">Slug</th>
            <th class="px-6 py-3 text-center font-semibold text-primary">Articles</th>
            <th class="px-6 py-3 text-right font-semibold text-primary">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          @foreach($categories as $category)
            <tr class="hover:bg-primary/2 transition">
              <td class="px-6 py-3 font-medium text-ink">
                <i class="fas fa-folder text-secondary mr-2"></i>
                {{ $category->name }}
              </td>
              <td class="px-6 py-3 text-slate-600">
                <code class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $category->slug }}</code>
              </td>
              <td class="px-6 py-3 text-center">
                <span class="inline-flex items-center gap-1 text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">
                  <i class="fas fa-file"></i> {{ $category->posts_count }}
                </span>
              </td>
              <td class="px-6 py-3 text-right space-x-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-xs font-semibold">
                  <i class="fas fa-edit mr-1"></i> Éditer
                </a>
                <button 
                  type="button"
                  @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                    detail: {
                      title: 'Supprimer catégorie ?',
                      message: 'Cette action est irréversible. {{ $category->posts_count }} article(s) sera/seront affecté(s).',
                      confirmText: 'Supprimer',
                      cancelText: 'Annuler',
                      type: 'danger',
                      callback: () => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("admin.categories.destroy", $category) }}';
                        form.innerHTML = '<input type=\'hidden\' name=\'_token\' value=\'{{ csrf_token() }}\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'><button type=\'submit\'></button>';
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
    </div>
  @endif
</div>
@endsection
