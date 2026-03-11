@extends('layout.app')

@section('title', 'Portfolio admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-heading">Portfolio</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary rounded-full">Nouveau projet</a>
  </div>

  <div class="glass rounded-3xl overflow-hidden">
    <table class="w-full text-left text-sm">
      <thead class="bg-slate-50">
        <tr>
          <th class="px-6 py-3">Titre</th>
          <th class="px-6 py-3">Role</th>
          <th class="px-6 py-3">En vedette</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
          <tr class="border-t">
            <td class="px-6 py-4">{{ $item->title }}</td>
            <td class="px-6 py-4">{{ $item->role }}</td>
            <td class="px-6 py-4">{{ $item->featured ? 'Oui' : 'Non' }}</td>
            <td class="px-6 py-4 flex gap-2">
              <a href="{{ route('admin.portfolio.edit', $item) }}" class="text-secondary font-semibold">Editer</a>
              <form action="{{ route('admin.portfolio.destroy', $item) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Supprimer ce projet ?')" class="text-red-600 font-semibold">
                  Supprimer
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-6 text-slate-600">Aucun projet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-6">
    {{ $items->links() }}
  </div>
</section>
@endsection
