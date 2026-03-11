@extends('layout.app')

@section('title', 'Nouveau projet')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-heading mb-6">Nouveau projet</h1>

  <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data" class="glass rounded-3xl p-6 space-y-4">
    @csrf
    <input type="text" name="title" placeholder="Titre" class="w-full rounded-xl border border-slate-200 px-4 py-2" required>
    <input type="text" name="role" placeholder="Role" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <input type="text" name="stack" placeholder="Stack (ex: Laravel, Vue)" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <textarea name="summary" rows="4" placeholder="Resume" class="w-full rounded-xl border border-slate-200 px-4 py-2"></textarea>
    <input type="url" name="link" placeholder="Lien du projet" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <input type="file" name="cover_image" class="w-full text-sm">
    <div class="grid gap-4 md:grid-cols-2">
      <input type="date" name="started_at" class="w-full rounded-xl border border-slate-200 px-4 py-2">
      <input type="date" name="ended_at" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    </div>
    <div class="grid gap-4 md:grid-cols-3">
      <div class="flex items-center gap-2">
        <input type="checkbox" name="is_current" id="is_current" class="rounded">
        <label for="is_current" class="text-sm">En cours</label>
      </div>
      <div class="flex items-center gap-2">
        <input type="checkbox" name="featured" id="featured" class="rounded">
        <label for="featured" class="text-sm">En vedette</label>
      </div>
      <input type="number" name="sort_order" min="0" placeholder="Ordre" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    </div>
    <button type="submit" class="btn btn-primary rounded-full">Enregistrer</button>
  </form>
</section>
@endsection
