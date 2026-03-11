@extends('layout.app')

@section('title', 'Articles admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-heading">Articles</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary rounded-full">Nouvel article</a>
  </div>

  <div class="glass rounded-3xl overflow-hidden">
    <table class="w-full text-left text-sm">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3">Titre</th>
          <th class="px-6 py-3">Statut</th>
          <th class="px-6 py-3">Vues</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
          <tr class="border-t">
            <td class="px-6 py-4">{{ $post->title }}</td>
            <td class="px-6 py-4">
              <span class="px-2 py-1 text-xs rounded-full {{ $post->published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $post->published ? 'Publie' : 'Brouillon' }}
              </span>
            </td>
            <td class="px-6 py-4">{{ $post->views_count }}</td>
            <td class="px-6 py-4 flex gap-2">
              <a href="{{ route('admin.posts.edit', $post) }}" class="text-secondary font-semibold">Editer</a>
              <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Supprimer cet article ?')" class="text-red-600 font-semibold">
                  Supprimer
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-6 text-slate-600">Aucun article.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $posts->links() }}
  </div>
</section>
@endsection
