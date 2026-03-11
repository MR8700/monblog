@extends('layout.app')

@section('title', $product->title)

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
  <div class="glass rounded-3xl overflow-hidden">
    <img src="{{ $product->image ?? 'https://via.placeholder.com/1200x700' }}" alt="{{ $product->title }}" class="w-full h-64 object-cover">
    <div class="p-8 space-y-5">
      <h1 class="text-3xl font-display text-primary">{{ $product->title }}</h1>
      <p class="text-slate-600">{{ $product->description }}</p>
      <p class="text-xl font-semibold text-secondary">
        {{ $product->price ? number_format($product->price, 0, ',', ' ') . ' CFA' : 'Prix non defini' }}
      </p>

      <div class="flex flex-wrap gap-3">
        @if($product->whatsapp)
          <a href="https://wa.me/{{ $product->whatsapp }}" target="_blank" class="btn btn-primary rounded-full">WhatsApp</a>
        @endif
        @if($product->facebook)
          <a href="{{ $product->facebook }}" target="_blank" class="btn btn-secondary rounded-full">Facebook</a>
        @endif
        @if($product->phone)
          <a href="tel:{{ $product->phone }}" class="btn rounded-full border border-slate-200 bg-white">Appeler</a>
        @endif
        @if($product->email)
          <a href="mailto:{{ $product->email }}" class="btn rounded-full border border-slate-200 bg-white">Email</a>
        @endif
      </div>

      @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
        <div class="flex gap-3">
          <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary rounded-full">Modifier</a>
          <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer ce travail ?')" class="btn rounded-full border border-red-300 text-red-600 bg-white">Supprimer</button>
          </form>
        </div>
      @endif
    </div>
  </div>
</section>
@endsection
