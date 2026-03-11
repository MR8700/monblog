<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Accueil - Portfolio & Blog')</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Source+Sans+3:wght@400;500;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-sand text-ink font-sans min-h-screen flex flex-col">
  <div class="fixed inset-0 -z-10 bg-noise"></div>
  <div class="fixed inset-0 -z-20 bg-gradient-to-br from-white via-slate-50 to-blue-50"></div>

  <nav class="glass sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <a href="{{ route('home') }}" class="text-2xl font-heading tracking-tight flex items-center gap-2">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary text-white shadow-glow">M</span>
        <span>Mon Espace Pro</span>
      </a>

      @php
        $active = 'bg-primary text-white shadow-glow';
        $pill = 'px-4 py-2 rounded-full text-sm font-semibold border border-slate-200 bg-white/70 hover:bg-white transition';
      @endphp

      <div class="flex flex-wrap items-center gap-3">
        @if(Auth::guard('admin')->check())
          <a href="{{ route('admin.dashboard') }}" class="{{ $pill }} {{ request()->routeIs('admin.dashboard') ? $active : '' }}">Dashboard</a>
          <a href="{{ route('admin.posts.index') }}" class="{{ $pill }} {{ request()->routeIs('admin.posts.*') ? $active : '' }}">Articles</a>
          <a href="{{ route('admin.products.index') }}" class="{{ $pill }} {{ request()->routeIs('admin.products.*') ? $active : '' }}">Travaux</a>
          <a href="{{ route('admin.portfolio.index') }}" class="{{ $pill }} {{ request()->routeIs('admin.portfolio.*') ? $active : '' }}">Portfolio</a>
          <a href="{{ route('admin.profile.index') }}" class="{{ $pill }}">Profil</a>
          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-full text-sm font-semibold border border-red-300 text-red-600 bg-white hover:bg-red-600 hover:text-white transition">
              Deconnexion
            </button>
          </form>
        @else
          <a href="{{ route('home') }}" class="{{ $pill }} {{ request()->routeIs('home') ? $active : '' }}">Accueil</a>
          <a href="{{ route('blog.index') }}" class="{{ $pill }} {{ request()->routeIs('blog.*') ? $active : '' }}">Blog</a>
          <a href="{{ route('portfolio.index') }}" class="{{ $pill }} {{ request()->routeIs('portfolio.*') ? $active : '' }}">Portfolio</a>
          <a href="{{ route('chat.index') }}" class="{{ $pill }} {{ request()->routeIs('chat.*') ? $active : '' }}">Chat</a>
          <a href="{{ route('contact') }}" class="{{ $pill }} {{ request()->routeIs('contact') ? $active : '' }}">Contact</a>
          <a href="{{ route('admin.login') }}" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white shadow-glow hover:bg-primary-light transition">
            Admin
          </a>
        @endif
      </div>
    </div>
  </nav>

  <main class="flex-1">
    @yield('content')
  </main>

  <footer class="mt-16 bg-primary text-white">
    <div class="max-w-7xl mx-auto px-6 py-10 grid gap-6 md:grid-cols-3 bg-white/10 border border-white/10 rounded-3xl">
      <div class="space-y-3">
        <h3 class="font-heading text-lg">Presence pro</h3>
        <p class="text-sm text-white/80">Un espace pour mes travaux, articles et conversations en direct.</p>
      </div>
      <div class="space-y-2 text-sm">
        <p class="font-semibold">Contact rapide</p>
        <p>WhatsApp: +226 00 00 00 00</p>
        <p>Email: contact@monsite.com</p>
      </div>
      <div class="space-y-2 text-sm">
        <p class="font-semibold">Suivre</p>
        <div class="flex gap-3">
          <a href="https://facebook.com/monpage" target="_blank" class="hover:text-secondary">Facebook</a>
          <a href="https://wa.me/22600000000" target="_blank" class="hover:text-secondary">WhatsApp</a>
          <a href="{{ route('blog.index') }}" class="hover:text-secondary">Blog</a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
