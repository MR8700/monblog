<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Accueil - Portfolio & Blog')</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Source+Sans+3:wght@400;500;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-[#FBFDFF] text-slate-900 font-sans min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
  <!-- Decorative background elements -->
  <div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden">
    <div class="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] bg-primary/5 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-secondary/5 blur-[100px] rounded-full"></div>
  </div>

  <!-- Navigation Bar Premium -->
  <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 transition-all duration-300" 
       :class="{ 'py-2 shadow-sm': window.scrollY > 20, 'py-4': window.scrollY <= 20 }">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center gap-3 group">
        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-xl shadow-primary/20 group-hover:rotate-6 transition-transform">
          <i class="fas fa-cube text-white" style="color: white !important; display: inline-block !important;"></i>
        </div>
        <span class="text-xl font-bold tracking-tight text-slate-900">Digital<span class="text-primary">Space</span></span>
      </a>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center gap-4 bg-slate-50/50 p-1 rounded-full border border-slate-100">
        @if(Auth::guard('admin')->check())
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : '' }}">
            <i class="fas fa-chart-line mr-1.5 text-[10px]"></i> Dashboard
          </a>
          <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-shopping-cart mr-1.5 text-[10px]"></i> Commandes
          </a>
          <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-users mr-1.5 text-[10px]"></i> Clients
          </a>
          <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-hand-holding-heart mr-1.5 text-[10px]"></i> Services
          </a>
          <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'nav-link-active' : '' }}">
            <i class="fas fa-file-invoice-dollar mr-1.5 text-[10px]"></i> Ventes
          </a>
          <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-pen mr-1.5 text-[10px]"></i> Articles
          </a>
          <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-briefcase mr-1.5 text-[10px]"></i> Marketplace
          </a>
          <a href="{{ route('admin.portfolio.index') }}" class="nav-link {{ request()->routeIs('admin.portfolio.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-folder mr-1.5 text-[10px]"></i> Portfolio
          </a>
          <a href="{{ route('admin.chat.index') }}" class="nav-link {{ request()->routeIs('admin.chat.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-comments mr-1.5 text-[10px]"></i> Chat
          </a>
          <!-- Profile Button -->
          <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-3 pl-4 pr-1 py-1 rounded-full border border-slate-100 hover:bg-white hover:shadow-lg transition-all group">
            <span class="text-[11px] font-black uppercase tracking-widest text-slate-400 group-hover:text-primary transition-colors">{{ Auth::guard('admin')->user()->name }}</span>
            <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-primary/20 shadow-sm">
                @if(Auth::guard('admin')->user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_picture) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-[10px] font-black">
                        {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
          </a>
        @else
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
            <i class="fas fa-home mr-1.5 text-[10px]"></i> Accueil
          </a>
          <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-blog mr-1.5 text-[10px]"></i> Blog
          </a>
          <a href="{{ route('products.publicIndex') }}" class="nav-link {{ request()->routeIs('products.publicIndex') ? 'nav-link-active' : '' }}">
            <i class="fas fa-shopping-bag mr-1.5 text-[10px]"></i> Boutique
          </a>
          <a href="{{ route('portfolio.index') }}" class="nav-link {{ request()->routeIs('portfolio.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-briefcase mr-1.5 text-[10px]"></i> Portfolio
          </a>
          <a href="{{ route('services.request') }}" class="nav-link {{ request()->routeIs('services.request') ? 'nav-link-active' : '' }}">
            <i class="fas fa-magic mr-1.5 text-[10px]"></i> Services
          </a>
          <a href="{{ route('deliveries.gallery') }}" class="nav-link {{ request()->routeIs('deliveries.gallery') ? 'nav-link-active' : '' }}">
            <i class="fas fa-star mr-1.5 text-[10px]"></i> E-Vitrine
          </a>
          <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'nav-link-active' : '' }}">
            <i class="fas fa-comments mr-1.5 text-[10px]"></i> Chat
          </a>
        @endif
      </div>

  <style>
    .nav-link {
      @apply px-5 py-2.5 rounded-full text-[13px] font-bold text-slate-600 hover:text-primary hover:bg-primary/5 transition-all duration-300 flex items-center;
    }
    .nav-link-active {
      @apply bg-primary text-white shadow-lg shadow-primary/25 ring-0 !important;
    }
    .nav-link-active i {
      @apply text-white !important;
    }
    .drawer-item {
      @apply flex items-center gap-4 p-4 rounded-2xl text-slate-600 font-bold hover:bg-slate-50 transition-all;
    }
    .drawer-item-active {
      @apply bg-primary/5 text-primary;
    }
  </style>

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
          <a href="{{ route('admin.orders.index') }}" class="drawer-item {{ request()->routeIs('admin.orders.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-shopping-cart w-5"></i>
            <span>Commandes</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.customers.index') }}" class="drawer-item {{ request()->routeIs('admin.customers.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-users w-5"></i>
            <span>Clients</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.services.index') }}" class="drawer-item {{ request()->routeIs('admin.services.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-hand-holding-heart w-5"></i>
            <span>Services</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.reports.sales') }}" class="drawer-item {{ request()->routeIs('admin.reports.sales') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-file-invoice-dollar w-5"></i>
            <span>Ventes</span>
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
          <a href="{{ route('admin.chat.index') }}" class="drawer-item {{ request()->routeIs('admin.chat.*') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-comments w-5"></i>
            <span>Chat Clients</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('admin.profile.index') }}" class="drawer-item" @click="mobileMenuOpen = false">
            <div class="w-10 h-10 rounded-xl overflow-hidden border border-primary/20 flex-none">
                @if(Auth::guard('admin')->user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_picture) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-[10px] font-black">
                        {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <span>Mon Profil</span>
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
          <a href="{{ route('services.request') }}" class="drawer-item {{ request()->routeIs('services.request') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-magic w-5"></i>
            <span>Services</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="{{ route('deliveries.gallery') }}" class="drawer-item {{ request()->routeIs('deliveries.gallery') ? 'drawer-item-active' : '' }}" @click="mobileMenuOpen = false">
            <i class="fas fa-star w-5"></i>
            <span>E-Vitrine</span>
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

  <footer class="mt-20 bg-[#0B0F19] text-white py-24 rounded-t-[4rem] md:rounded-t-[6rem] relative overflow-hidden border-t border-white/5">
    <!-- Sophisticated Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-secondary/5 blur-[150px] rounded-full"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid gap-16 md:grid-cols-4 mb-20">
            <!-- Brand & Mission -->
            <div class="md:col-span-2 space-y-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-4 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-primary-dark rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-primary/20 group-hover:rotate-6 transition-all duration-500">
                        <i class="fas fa-cube text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-tight block">Digital<span class="text-primary">Space</span></span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500">Premium Digital Agency</span>
                    </div>
                </a>
                
                <p class="text-slate-300 text-lg leading-relaxed max-w-md">
                    Façonner le futur numérique avec <span class="text-white font-semibold">audace</span> et <span class="text-white font-semibold">précision</span>. Nous créons des expériences qui ne se contentent pas de connecter, elles convertissent.
                </p>

                <div class="flex gap-4">
                    <a href="#" aria-label="Facebook" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-primary hover:border-primary hover:-translate-y-1 transition-all duration-300 group">
                        <i class="fab fa-facebook-f text-slate-400 group-hover:text-white transition-colors"></i>
                    </a>
                    <a href="#" aria-label="WhatsApp" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-green-500 hover:border-green-500 hover:-translate-y-1 transition-all duration-300 group">
                        <i class="fab fa-whatsapp text-slate-400 group-hover:text-white transition-colors"></i>
                    </a>
                    <a href="#" aria-label="YouTube" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-red-600 hover:border-red-600 hover:-translate-y-1 transition-all duration-300 group">
                        <i class="fab fa-youtube text-slate-400 group-hover:text-white transition-colors"></i>
                    </a>
                    <a href="#" aria-label="TikTok" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-black hover:border-white/20 hover:-translate-y-1 transition-all duration-300 group">
                        <i class="fab fa-tiktok text-slate-400 group-hover:text-white transition-colors"></i>
                    </a>
                </div>
            </div>

            <!-- Fast Links -->
            <div class="space-y-8">
                <h4 class="text-xs font-black uppercase tracking-[0.4em] text-primary">Exploration</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Accueil</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Articles & Blog</a></li>
                    <li><a href="{{ route('products.publicIndex') }}" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Boutique</a></li>
                    <li><a href="{{ route('portfolio.index') }}" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Portfolio</a></li>
                </ul>
            </div>

            <!-- Contact & HQ -->
            <div class="space-y-8">
                <h4 class="text-xs font-black uppercase tracking-[0.4em] text-secondary">Connexion</h4>
                <div class="space-y-6">
                    <a href="mailto:contact@monsite.com" class="block group">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 block mb-1">Email expert</span>
                        <span class="text-slate-200 group-hover:text-primary transition-colors font-medium">contact@monsite.com</span>
                    </a>
                    <div class="block">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 block mb-1">Siège social</span>
                        <span class="text-slate-200 font-medium">Ouagadougou, Zone 1<br>Burkina Faso</span>
                    </div>
                    <div class="pt-4">
                        <div class="inline-flex items-center gap-3 px-4 py-2 bg-white/5 rounded-full border border-white/10">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-300">Support en ligne</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
                <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                    © {{ date('Y') }} <span class="text-slate-300">DigitalSpace</span>. Propulsion Numérique.
                </div>
                @unless(Auth::guard('admin')->check())
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 hover:text-primary transition-colors group">
                        <i class="fas fa-lock text-[8px] group-hover:animate-pulse"></i> Accès Sécurisé
                    </a>
                @endunless
            </div>
            
            <div class="flex items-center gap-8">
                <a href="{{ route('privacy') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 hover:text-white transition-colors">Confidentialité</a>
                <a href="{{ route('terms') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 hover:text-white transition-colors">Conditions</a>
                <div class="w-px h-4 bg-white/10 hidden md:block"></div>
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-colors shadow-inner">
                    <i class="fas fa-arrow-up text-xs text-slate-400"></i>
                </button>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
