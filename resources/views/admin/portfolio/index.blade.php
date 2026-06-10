@extends('layout.app')

@section('title', 'Portfolio admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-heading">Portfolio</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary rounded-full">Nouveau projet</a>
  </div>

  <!-- Filters -->
  <div class="glass p-6 rounded-3xl mb-8">
    <form action="{{ url()->current() }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-3 relative">
            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre, Rôle, Stack..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
        </div>
        <div class="flex gap-2">
            <select name="featured" class="flex-1 px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                <option value="">En vedette ?</option>
                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Non</option>
            </select>
            <button type="submit" class="px-6 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </form>
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
