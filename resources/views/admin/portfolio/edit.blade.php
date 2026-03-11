@extends('layout.app')

@section('title', 'Modifier projet')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-heading mb-6">Modifier projet</h1>

  <form method="POST" action="{{ route('admin.portfolio.update', $item) }}" enctype="multipart/form-data" class="glass rounded-3xl p-6 space-y-4">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $item->title }}" class="w-full rounded-xl border border-slate-200 px-4 py-2" required>
    <input type="text" name="role" value="{{ $item->role }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <input type="text" name="stack" value="{{ $item->stack }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <textarea name="summary" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-2">{{ $item->summary }}</textarea>
    <input type="url" name="link" value="{{ $item->link }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <input type="file" name="cover_image" class="w-full text-sm">
    <div class="grid gap-4 md:grid-cols-2">
      <input type="date" name="started_at" value="{{ optional($item->started_at)->format('Y-m-d') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
      <input type="date" name="ended_at" value="{{ optional($item->ended_at)->format('Y-m-d') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    </div>
    <div class="grid gap-4 md:grid-cols-3">
      <div class="flex items-center gap-2">
        <input type="checkbox" name="is_current" id="is_current" class="rounded" {{ $item->is_current ? 'checked' : '' }}>
        <label for="is_current" class="text-sm">En cours</label>
      </div>
      <div class="flex items-center gap-2">
        <input type="checkbox" name="featured" id="featured" class="rounded" {{ $item->featured ? 'checked' : '' }}>
        <label for="featured" class="text-sm">En vedette</label>
      </div>
      <input type="number" name="sort_order" min="0" value="{{ $item->sort_order }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    </div>
    <button type="submit" class="btn btn-primary rounded-full">Mettre a jour</button>
  </form>
</section>
@endsection
