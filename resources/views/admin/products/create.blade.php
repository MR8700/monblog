@extends('layout.app')

@section('title', 'Ajouter un travail')

@section('content')
@if(Auth::guard('admin')->check())
<section class="max-w-4xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-heading mb-6">Ajouter un travail</h1>

  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="glass rounded-3xl p-6 space-y-4">
    @csrf
    <input type="text" name="title" value="{{ old('title') }}" placeholder="Titre" class="w-full rounded-xl border border-slate-200 px-4 py-2" required>
    <textarea name="description" rows="4" placeholder="Description" class="w-full rounded-xl border border-slate-200 px-4 py-2">{{ old('description') }}</textarea>
    <input type="number" name="price" step="0.01" value="{{ old('price') }}" placeholder="Prix" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <input type="file" name="image" class="w-full text-sm">

    <div class="grid gap-4 md:grid-cols-2">
      <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="WhatsApp" class="w-full rounded-xl border border-slate-200 px-4 py-2">
      <input type="url" name="facebook" value="{{ old('facebook') }}" placeholder="Lien Facebook" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    </div>
    <div class="grid gap-4 md:grid-cols-2">
      <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Telephone" class="w-full rounded-xl border border-slate-200 px-4 py-2">
      <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    </div>

    <div class="flex items-center gap-2">
      <input type="checkbox" name="published" id="published" class="rounded" {{ old('published') ? 'checked' : '' }}>
      <label for="published" class="text-sm">Publier</label>
    </div>

    <button type="submit" class="btn btn-primary rounded-full">Enregistrer</button>
  </form>
</section>
@else
<section class="max-w-3xl mx-auto px-6 py-12">
  <div class="glass rounded-3xl p-6 text-red-600">Acces interdit.</div>
</section>
@endif
@endsection
