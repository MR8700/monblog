@extends('layout.app')

@section('title', 'Contact')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-14">
  <div class="glass rounded-3xl p-8 md:p-10">
    <h1 class="text-3xl font-display text-primary mb-2">Contact</h1>
    <p class="text-slate-600 mb-6">Parlons de vos besoins ou d une collaboration.</p>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
      @csrf
      <div>
        <label class="block font-medium mb-1">Nom</label>
        <input type="text" name="name"
               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary focus:outline-none"
               value="{{ old('name') }}">
        @error('name') <span class="text-danger text-sm mt-1 block">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block font-medium mb-1">Email</label>
        <input type="email" name="email"
               class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary focus:outline-none"
               value="{{ old('email') }}">
        @error('email') <span class="text-danger text-sm mt-1 block">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block font-medium mb-1">Message</label>
        <textarea name="message"
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-secondary focus:outline-none"
                  rows="5">{{ old('message') }}</textarea>
        @error('message') <span class="text-danger text-sm mt-1 block">{{ $message }}</span> @enderror
      </div>

      <button type="submit" class="btn btn-primary rounded-full">Envoyer</button>
    </form>
  </div>
</section>
@endsection
