@extends('layout.app')

@section('title', 'Modifier article')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
  <h1 class="text-2xl font-heading mb-6">Modifier article</h1>

  <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="glass rounded-3xl p-6 space-y-4">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $post->title }}" class="w-full rounded-xl border border-slate-200 px-4 py-2" required>
    <input type="text" name="excerpt" value="{{ $post->excerpt }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <textarea name="body" rows="8" class="w-full rounded-xl border border-slate-200 px-4 py-2" required>{{ $post->body }}</textarea>
    <input type="file" name="cover_image" class="w-full text-sm">
    <div class="flex items-center gap-2">
      <input type="checkbox" name="published" id="published" class="rounded" {{ $post->published ? 'checked' : '' }}>
      <label for="published" class="text-sm">Publier</label>
    </div>
    <input type="date" name="published_at" value="{{ optional($post->published_at)->format('Y-m-d') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2">
    <button type="submit" class="btn btn-primary rounded-full">Mettre a jour</button>
  </form>
</section>
@endsection
