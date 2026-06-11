<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title', 'Accueil - Portfolio & Blog'); ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Source+Sans+3:wght@400;500;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <style>[x-cloak] { display: none !important; }</style>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between">
      <!-- Logo -->
      <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 sm:gap-3 group">
        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-xl shadow-primary/20 group-hover:rotate-6 transition-transform">
          <i class="fas fa-cube text-white" style="color: white !important; display: inline-block !important;"></i>
        </div>
        <span class="text-lg sm:text-xl font-bold tracking-tight text-slate-900">Digital<span class="text-primary">Space</span></span>
      </a>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center gap-4 bg-slate-50/50 p-1 rounded-full border border-slate-100">
        <?php if(Auth::guard('admin')->check()): ?>
          <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-chart-line mr-1.5 text-[10px]"></i> Dashboard
          </a>
          <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-shopping-cart mr-1.5 text-[10px]"></i> Commandes
          </a>
          <a href="<?php echo e(route('admin.customers.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.customers.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-users mr-1.5 text-[10px]"></i> Clients
          </a>
          <a href="<?php echo e(route('admin.services.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.services.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-hand-holding-heart mr-1.5 text-[10px]"></i> Services
          </a>
          <a href="<?php echo e(route('admin.reports.sales')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.reports.sales') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-file-invoice-dollar mr-1.5 text-[10px]"></i> Ventes
          </a>
          <a href="<?php echo e(route('admin.posts.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.posts.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-pen mr-1.5 text-[10px]"></i> Articles
          </a>
          <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-briefcase mr-1.5 text-[10px]"></i> Marketplace
          </a>
          <a href="<?php echo e(route('admin.portfolio.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.portfolio.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-folder mr-1.5 text-[10px]"></i> Portfolio
          </a>
          <a href="<?php echo e(route('admin.chat.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.chat.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-comments mr-1.5 text-[10px]"></i> Chat
          </a>
          <!-- Profile Button -->
          <a href="<?php echo e(route('admin.profile.index')); ?>" class="flex items-center gap-3 pl-4 pr-1 py-1 rounded-full border border-slate-100 hover:bg-white hover:shadow-lg transition-all group">
            <span class="text-[11px] font-black uppercase tracking-widest text-slate-400 group-hover:text-primary transition-colors"><?php echo e(Auth::guard('admin')->user()->name); ?></span>
            <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-primary/20 shadow-sm">
                <?php if(Auth::guard('admin')->user()->profile_picture): ?>
                    <img src="<?php echo e(asset('storage/' . Auth::guard('admin')->user()->profile_picture)); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-[10px] font-black">
                        <?php echo e(strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>
            </div>
          </a>
        <?php else: ?>
          <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->routeIs('home') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-home mr-1.5 text-[10px]"></i> Accueil
          </a>
          <a href="<?php echo e(route('blog.index')); ?>" class="nav-link <?php echo e(request()->routeIs('blog.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-blog mr-1.5 text-[10px]"></i> Blog
          </a>
          <a href="<?php echo e(route('products.publicIndex')); ?>" class="nav-link <?php echo e(request()->routeIs('products.publicIndex') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-shopping-bag mr-1.5 text-[10px]"></i> Boutique
          </a>
          <a href="<?php echo e(route('portfolio.index')); ?>" class="nav-link <?php echo e(request()->routeIs('portfolio.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-briefcase mr-1.5 text-[10px]"></i> Portfolio
          </a>
          <a href="<?php echo e(route('services.request')); ?>" class="nav-link <?php echo e(request()->routeIs('services.request') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-magic mr-1.5 text-[10px]"></i> Services
          </a>
          <a href="<?php echo e(route('deliveries.gallery')); ?>" class="nav-link <?php echo e(request()->routeIs('deliveries.gallery') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-star mr-1.5 text-[10px]"></i> E-Vitrine
          </a>
          <a href="<?php echo e(route('chat.index')); ?>" class="nav-link <?php echo e(request()->routeIs('chat.*') ? 'nav-link-active' : ''); ?>">
            <i class="fas fa-comments mr-1.5 text-[10px]"></i> Chat
          </a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <button 
        @click="mobileMenuOpen = !mobileMenuOpen" 
        class="md:hidden w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 border border-slate-100 text-slate-600 hover:text-primary hover:bg-primary/5 transition-all"
        :class="{ 'bg-primary/10 text-primary border-primary/20': mobileMenuOpen }"
      >
        <div class="relative w-6 h-5">
          <span 
            class="absolute left-0 block w-6 h-0.5 bg-current rounded-full transition-all duration-300"
            :class="{ 'top-2 rotate-45': mobileMenuOpen, 'top-0': !mobileMenuOpen }"
          ></span>
          <span 
            class="absolute left-0 top-2 block w-6 h-0.5 bg-current rounded-full transition-all duration-300"
            :class="{ 'opacity-0 translate-x-4': mobileMenuOpen, 'opacity-100': !mobileMenuOpen }"
          ></span>
          <span 
            class="absolute left-0 block w-6 h-0.5 bg-current rounded-full transition-all duration-300"
            :class="{ 'top-2 -rotate-45': mobileMenuOpen, 'top-4': !mobileMenuOpen }"
          ></span>
        </div>
      </button>

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
      x-cloak
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 -translate-y-4"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-4"
      class="md:hidden bg-white/95 backdrop-blur border-t border-slate-100 shadow-2xl"
    >
      <div class="max-w-7xl mx-auto px-6 py-4 space-y-2 flex flex-col">
        <?php if(Auth::guard('admin')->check()): ?>
          <a href="<?php echo e(route('admin.dashboard')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.dashboard') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-chart-line w-5"></i>
            <span>Dashboard</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.orders.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.orders.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-shopping-cart w-5"></i>
            <span>Commandes</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.customers.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.customers.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-users w-5"></i>
            <span>Clients</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.services.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.services.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-hand-holding-heart w-5"></i>
            <span>Services</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.reports.sales')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.reports.sales') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-file-invoice-dollar w-5"></i>
            <span>Ventes</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.posts.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.posts.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-pen w-5"></i>
            <span>Articles</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.products.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.products.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-briefcase w-5"></i>
            <span>Travaux</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.portfolio.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.portfolio.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-folder w-5"></i>
            <span>Portfolio</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.chat.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('admin.chat.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-comments w-5"></i>
            <span>Chat Clients</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('admin.profile.index')); ?>" class="drawer-item" @click="mobileMenuOpen = false">
            <div class="w-10 h-10 rounded-xl overflow-hidden border border-primary/20 flex-none">
                <?php if(Auth::guard('admin')->user()->profile_picture): ?>
                    <img src="<?php echo e(asset('storage/' . Auth::guard('admin')->user()->profile_picture)); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-[10px] font-black">
                        <?php echo e(strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>
            </div>
            <span>Mon Profil</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <hr class="my-2 border-primary-100">
          <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="w-full">
            <?php echo csrf_field(); ?>
            <button type="submit" class="drawer-item w-full text-danger hover:bg-danger/10 justify-start">
              <i class="fas fa-sign-out-alt w-5"></i>
              <span>Déconnexion</span>
              <i class="fas fa-chevron-right ml-auto text-danger/30"></i>
            </button>
          </form>
        <?php else: ?>
          <a href="<?php echo e(route('home')); ?>" class="drawer-item <?php echo e(request()->routeIs('home') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-home w-5"></i>
            <span>Accueil</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('blog.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('blog.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-blog w-5"></i>
            <span>Blog</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('portfolio.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('portfolio.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-briefcase w-5"></i>
            <span>Portfolio</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('services.request')); ?>" class="drawer-item <?php echo e(request()->routeIs('services.request') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-magic w-5"></i>
            <span>Services</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('deliveries.gallery')); ?>" class="drawer-item <?php echo e(request()->routeIs('deliveries.gallery') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-star w-5"></i>
            <span>E-Vitrine</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('chat.index')); ?>" class="drawer-item <?php echo e(request()->routeIs('chat.*') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-comments w-5"></i>
            <span>Chat direct</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <a href="<?php echo e(route('contact')); ?>" class="drawer-item <?php echo e(request()->routeIs('contact') ? 'drawer-item-active' : ''); ?>" @click="mobileMenuOpen = false">
            <i class="fas fa-envelope w-5"></i>
            <span>Contact</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
          <hr class="my-2 border-primary-100">
          <a href="<?php echo e(route('admin.login')); ?>" class="drawer-item bg-primary text-white hover:bg-primary-dark" @click="mobileMenuOpen = false">
            <i class="fas fa-lock w-5"></i>
            <span>Espace Admin</span>
            <i class="fas fa-chevron-right ml-auto text-primary-300"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="flex-1">
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  <!-- Global Toast Notifications -->
  <?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'danger','title' => 'Erreur']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','title' => 'Erreur']); ?><?php echo e($error); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>

  <?php if(session('success')): ?>
    <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success','title' => 'Succès']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','title' => 'Succès']); ?><?php echo e(session('success')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
  <?php endif; ?>

  <?php if(session('error')): ?>
    <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'danger','title' => 'Erreur']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger','title' => 'Erreur']); ?><?php echo e(session('error')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
  <?php endif; ?>

  <?php if(session('warning')): ?>
    <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'warning','title' => 'Attention']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning','title' => 'Attention']); ?><?php echo e(session('warning')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
  <?php endif; ?>

  <?php if(session('info')): ?>
    <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'info','title' => 'Information']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','title' => 'Information']); ?><?php echo e(session('info')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
  <?php endif; ?>

  <!-- Global Confirmation Modal -->
  <?php if (isset($component)) { $__componentOriginal2cfaf2d8c559a20e3495c081df2d0b10 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2cfaf2d8c559a20e3495c081df2d0b10 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirm-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2cfaf2d8c559a20e3495c081df2d0b10)): ?>
<?php $attributes = $__attributesOriginal2cfaf2d8c559a20e3495c081df2d0b10; ?>
<?php unset($__attributesOriginal2cfaf2d8c559a20e3495c081df2d0b10); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2cfaf2d8c559a20e3495c081df2d0b10)): ?>
<?php $component = $__componentOriginal2cfaf2d8c559a20e3495c081df2d0b10; ?>
<?php unset($__componentOriginal2cfaf2d8c559a20e3495c081df2d0b10); ?>
<?php endif; ?>

  <footer class="mt-20 bg-[#0B0F19] text-white py-24 rounded-t-[4rem] md:rounded-t-[6rem] relative overflow-hidden border-t border-white/5">
    <!-- Sophisticated Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-secondary/5 blur-[150px] rounded-full"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid gap-12 sm:gap-16 md:grid-cols-4 mb-20">
            <!-- Brand & Mission -->
            <div class="md:col-span-2 space-y-8">
                <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-3 sm:gap-4 group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-primary to-primary-dark rounded-2xl flex items-center justify-center text-white shadow-2xl shadow-primary/20 group-hover:rotate-6 transition-all duration-500">
                        <i class="fas fa-cube text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-bold tracking-tight block">Digital<span class="text-primary">Space</span></span>
                        <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500">Premium Digital Agency</span>
                    </div>
                </a>
                
                <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-md">
                    Façonner le futur numérique avec <span class="text-white font-semibold">audace</span> et <span class="text-white font-semibold">précision</span>. Nous créons des expériences qui ne se contentent pas de connecter, elles convertissent.
                </p>

                <div class="flex flex-wrap gap-3 sm:gap-4">
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
                    <li><a href="<?php echo e(route('home')); ?>" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Accueil</a></li>
                    <li><a href="<?php echo e(route('blog.index')); ?>" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Articles & Blog</a></li>
                    <li><a href="<?php echo e(route('products.publicIndex')); ?>" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Boutique</a></li>
                    <li><a href="<?php echo e(route('portfolio.index')); ?>" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>Portfolio</a></li>
                    <li><a href="<?php echo e(route('about')); ?>" class="text-slate-400 hover:text-white flex items-center gap-2 group transition-colors"><span class="w-1.5 h-1.5 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>À Propos</a></li>
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
        <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
                <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                    © <?php echo e(date('Y')); ?> <span class="text-slate-300">DigitalSpace</span>. Propulsion Numérique.
                </div>
                <?php if (! (Auth::guard('admin')->check())): ?>
                    <a href="<?php echo e(route('admin.login')); ?>" class="inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 hover:text-primary transition-colors group">
                        <i class="fas fa-lock text-[8px] group-hover:animate-pulse"></i> Accès Sécurisé
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="flex items-center gap-8">
                <a href="<?php echo e(route('privacy')); ?>" class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 hover:text-white transition-colors">Confidentialité</a>
                <a href="<?php echo e(route('terms')); ?>" class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 hover:text-white transition-colors">Conditions</a>
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
<?php /**PATH /var/www/monblog/resources/views/layout/app.blade.php ENDPATH**/ ?>