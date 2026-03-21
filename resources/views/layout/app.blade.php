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

<body class="bg-sand text-ink font-sans min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
  <div class="fixed inset-0 -z-10 bg-noise"></div>
  <div class="fixed inset-0 -z-20 bg-gradient-to-br from-white via-slate-50 to-blue-50"></div>

  <!-- Navigation Bar -->
  <nav class="glass sticky top-0 z-50 border-b border-primary-100/30">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="text-2xl font-heading tracking-tight flex items-center gap-2 shrink-0">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary text-white shadow-glow text-sm font-bold">M</span>
        <span class="hidden sm:inline">Mon Espace Pro</span>
      </a>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center gap-2">
        @if(Auth::guard('admin')->check())
          <a href="{{ route('admin.dashboard') }}" class="nav-pill {{ request()->routeIs('admin.dashboard') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-chart-line"></i> Dashboard
          </a>
          <a href="{{ route('admin.posts.index') }}" class="nav-pill {{ request()->routeIs('admin.posts.*') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-pen"></i> Articles
          </a>
          <a href="{{ route('admin.products.index') }}" class="nav-pill {{ request()->routeIs('admin.products.*') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-briefcase"></i> Travaux
          </a>
          <a href="{{ route('admin.portfolio.index') }}" class="nav-pill {{ request()->routeIs('admin.portfolio.*') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-folder"></i> Portfolio
          </a>
          <a href="{{ route('admin.profile.index') }}" class="nav-pill">
            <i class="fas fa-user"></i> Profil
          </a>
          <form action="{{ route('admin.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="nav-pill text-danger hover:bg-danger/10">
              <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
          </form>
        @else
          <a href="{{ route('home') }}" class="nav-pill {{ request()->routeIs('home') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-home"></i> Accueil
          </a>
          <a href="{{ route('blog.index') }}" class="nav-pill {{ request()->routeIs('blog.*') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-blog"></i> Blog
          </a>
          <a href="{{ route('portfolio.index') }}" class="nav-pill {{ request()->routeIs('portfolio.*') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-briefcase"></i> Portfolio
          </a>
          <a href="{{ route('chat.index') }}" class="nav-pill {{ request()->routeIs('chat.*') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-comments"></i> Chat
          </a>
          <a href="{{ route('contact') }}" class="nav-pill {{ request()->routeIs('contact') ? 'nav-pill-active' : '' }}">
            <i class="fas fa-envelope"></i> Contact
          </a>
          <a href="{{ route('admin.login') }}" class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-white shadow-glow hover:bg-primary-dark transition">
            <i class="fas fa-lock"></i> Admin
          </a>
        @endif
      </div>

      <!-- Mobile Menu Button -->
      <button 
        @click="mobileMenuOpen = !mobileMenuOpen"
        class="md:hidden p-2 rounded-lg hover:bg-primary-50 transition"
        aria-label="Toggle menu"
      >
        <i class="fas fa-bars text-xl text-primary"></i>
      </button>
    </div>

    <!-- Mobile Drawer Menu -->
    <div 
      x-show="mobileMenuOpen"
      x-transition
      class="md:hidden bg-white/95 backdrop-blur border-t border-primary-100/30"
    >
      <div class="max-w-7xl mx-auto px-6 py-4 space-y-2 flex flex-col">
        @if(Auth::guard('admin')->check())
          <a href="{{ route('admin.dashboard') }}" class="drawer-item {{ request()->routeIs('admin.dashboard') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-chart-line w-5"></i>
            <span>Dashboard</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.posts.index') }}" class="drawer-item {{ request()->routeIs('admin.posts.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-pen w-5"></i>
            <span>Articles</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.products.index') }}" class="drawer-item {{ request()->routeIs('admin.products.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-briefcase w-5"></i>
            <span>Travaux</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.portfolio.index') }}" class="drawer-item {{ request()->routeIs('admin.portfolio.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-folder w-5"></i>
            <span>Portfolio</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.profile.index') }}" class="drawer-item" @click="mobileMenuOpen = false">
            <i class="fas fa-user w-5"></i>
            <span>Profil</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <hr class="my-2 border-primary-100">
          <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="drawer-item w-full text-danger hover:bg-danger/10 justify-start">
              <i class="fas fa-sign-out-alt w-5"></i>
              <span>Déconnexion</span>
              <i class="fas fa-chevron-right ml-auto text-danger/30"></i>
            </button>
          </form>
        @else
          <a href="{{ route('home') }}" class="drawer-item {{ request()->routeIs('home') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-home w-5"></i>
            <span>Accueil</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('blog.index') }}" class="drawer-item {{ request()->routeIs('blog.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-blog w-5"></i>
            <span>Blog</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('portfolio.index') }}" class="drawer-item {{ request()->routeIs('portfolio.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-briefcase w-5"></i>
            <span>Portfolio</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('chat.index') }}" class="drawer-item {{ request()->routeIs('chat.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-comments w-5"></i>
            <span>Chat direct</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('contact') }}" class="drawer-item {{ request()->routeIs('contact') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-envelope w-5"></i>
            <span>Contact</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <hr class="my-2 border-primary-100">
          <a href="{{ route('admin.login') }}" class="drawer-item bg-primary text-white hover:bg-primary-dark" @click="mobileMenuOpen = false">
            <i class="fas fa-lock w-5"></i>
            <span>Espace Admin</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
        @endif
      </div>
    </div>
  </nav>

  <main class="flex-1">
    @yield('content')
  </main>

  <!-- Global Toast Notifications -->
  @if($errors->any())
    @foreach($errors->all() as $error)
      <x-alert type="danger" title="Erreur">{{ $error }}</x-alert>
    @endforeach
  @endif

  @if(session('success'))
    <x-alert type="success" title="Succès">{{ session('success') }}</x-alert>
  @endif

  @if(session('error'))
    <x-alert type="danger" title="Erreur">{{ session('error') }}</x-alert>
  @endif

  @if(session('warning'))
    <x-alert type="warning" title="Attention">{{ session('warning') }}</x-alert>
  @endif

  @if(session('info'))
    <x-alert type="info" title="Information">{{ session('info') }}</x-alert>
  @endif

  <!-- Global Confirmation Modal -->
  <x-confirm-modal />

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
