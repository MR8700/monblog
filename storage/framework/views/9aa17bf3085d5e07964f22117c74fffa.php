<?php $__env->startSection('title', 'Bienvenue sur Mon Espace Digital'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section Premium -->
<section class="relative pt-20 pb-32 overflow-hidden">
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-primary/5 blur-[120px] rounded-full -z-10"></div>
  
  <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
    <div class="space-y-8 animate-fade-in">
      <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-soft border border-slate-100">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
        </span>
        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Disponible pour de nouveaux projets</span>
      </div>

      <h1 class="text-5xl md:text-7xl font-bold leading-[1.1] text-slate-900">
        Solutions <span class="text-primary italic font-display">Numériques</span> de Haute Qualité.
      </h1>
      
      <p class="text-xl text-slate-500 leading-relaxed max-w-xl">
        Découvrez mes créations, apprenez via mon blog premium et collaborez avec moi en direct pour propulser votre business.
      </p>

      <div class="flex flex-wrap gap-4 pt-4">
        <a href="<?php echo e(route('products.publicIndex')); ?>" class="px-8 py-4 bg-primary text-white rounded-full font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-transform flex items-center gap-3">
          <i class="fas fa-shopping-cart"></i> Voir mes produits
        </a>
        <a href="<?php echo e(route('portfolio.index')); ?>" class="px-8 py-4 bg-white text-slate-900 rounded-full font-bold shadow-soft border border-slate-100 hover:bg-slate-50 transition-colors flex items-center gap-3">
          <i class="fas fa-layer-group"></i> Portfolio
        </a>
      </div>

      <div class="flex items-center gap-8 pt-8 border-t border-slate-100">
        <div>
          <p class="text-2xl font-bold text-slate-900">50+</p>
          <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Projets livrés</p>
        </div>
        <div class="w-px h-8 bg-slate-100"></div>
        <div>
          <p class="text-2xl font-bold text-slate-900">100%</p>
          <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Satisfaction</p>
        </div>
        <div class="w-px h-8 bg-slate-100"></div>
        <div class="flex -space-x-3">
          <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-200"></div>
          <div class="w-10 h-10 rounded-full border-2 border-white bg-primary/20"></div>
          <div class="w-10 h-10 rounded-full border-2 border-white bg-secondary/20"></div>
        </div>
      </div>
    </div>

    <div class="relative lg:block hidden">
      <div class="relative z-10 bg-white p-4 rounded-[3rem] shadow-glow border border-white/50 animate-float">
        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800" 
             alt="Interface" class="rounded-[2.5rem] shadow-inner">
      </div>
      <!-- Floating elements -->
      <div class="absolute -top-10 -right-10 bg-secondary p-6 rounded-3xl shadow-xl text-white animate-bounce-slow">
        <i class="fas fa-rocket text-3xl"></i>
      </div>
      <div class="absolute -bottom-10 -left-10 bg-white p-6 rounded-3xl shadow-xl border border-slate-100 animate-float-delayed">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
            <i class="fas fa-check"></i>
          </div>
          <div>
            <p class="text-sm font-bold text-slate-900">Qualité Premium</p>
            <p class="text-xs text-slate-400">Vérifié par experts</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Produits -->
<section class="bg-white py-24 rounded-[5rem]">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
      <div class="space-y-4">
        <span class="text-primary font-bold uppercase tracking-[0.3em] text-xs">Marketplace</span>
        <h2 class="text-4xl font-bold text-slate-900">Produits & Services</h2>
      </div>
      <a href="<?php echo e(route('products.publicIndex')); ?>" class="group flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">
        Voir toute la boutique <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
      </a>
    </div>

    <div class="grid gap-8 md:grid-cols-3">
      <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="group bg-slate-50 rounded-[2.5rem] overflow-hidden border border-transparent hover:border-primary/10 hover:bg-white hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500">
          <div class="h-64 overflow-hidden relative">
            <img src="<?php echo e($product->image ?? 'https://via.placeholder.com/600x400'); ?>" alt="<?php echo e($product->title); ?>" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-2xl shadow-sm">
              <span class="text-primary font-bold"><?php echo e(number_format($product->price, 0, ',', ' ')); ?> <span class="text-[10px]">CFA</span></span>
            </div>
          </div>
          <div class="p-8 space-y-4">
            <div class="flex items-center gap-2">
              <span class="text-[10px] font-bold uppercase tracking-widest text-secondary bg-secondary/5 px-3 py-1 rounded-full">
                <?php echo e($product->type); ?>

              </span>
            </div>
            <h3 class="text-xl font-bold text-slate-900"><?php echo e($product->title); ?></h3>
            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
              <?php echo e($product->description); ?>

            </p>
            <a href="<?php echo e(route('products.show', $product)); ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary group-hover:gap-4 transition-all">
              Détails du produit <i class="fas fa-chevron-right text-[10px]"></i>
            </a>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-200">
          <p class="text-slate-400">Aucun produit disponible pour le moment.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Section Blog -->
<section class="py-24">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16 text-right md:text-left">
      <div class="space-y-4">
        <span class="text-secondary font-bold uppercase tracking-[0.3em] text-xs">Knowledge Base</span>
        <h2 class="text-4xl font-bold text-slate-900">Analyses & Articles</h2>
      </div>
      <a href="<?php echo e(route('blog.index')); ?>" class="group flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-secondary transition-colors">
        Accéder au blog <i class="fas fa-arrow-right transition-transform group-hover:translate-x-2"></i>
      </a>
    </div>

    <div class="grid gap-8 md:grid-cols-3">
      <?php $__empty_1 = true; $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <article class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 hover:border-secondary/20 hover:shadow-2xl hover:shadow-secondary/5 transition-all duration-500 flex flex-col relative">
          <?php if($post->is_premium): ?>
            <div class="absolute top-8 right-8 text-amber-500 text-lg">
              <i class="fas fa-crown"></i>
            </div>
          <?php endif; ?>
          <div class="space-y-4">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
              <?php echo e($post->published_at ? $post->published_at->diffForHumans() : 'Récemment'); ?>

            </p>
            <h3 class="text-2xl font-bold text-slate-900 leading-tight group-hover:text-secondary transition-colors">
              <?php echo e($post->title); ?>

            </h3>
            <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed">
              <?php echo e($post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 150)); ?>

            </p>
            <div class="pt-6 flex items-center justify-between">
              <a href="<?php echo e(route('blog.show', $post)); ?>" class="text-sm font-bold text-slate-900 group-hover:text-secondary flex items-center gap-2">
                Lire l'article <i class="fas fa-arrow-right text-[10px]"></i>
              </a>
              <div class="flex items-center gap-3 text-[10px] font-bold text-slate-300">
                <span><?php echo e($post->views_count); ?> VUES</span>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-20 text-center">
          <p class="text-slate-400">Bientôt de nouveaux articles.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Call to Action Chat -->
<section class="max-w-7xl mx-auto px-6 py-12">
  <div class="bg-slate-900 rounded-[4rem] p-12 md:p-20 relative overflow-hidden group">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/20 blur-[100px] rounded-full group-hover:scale-110 transition-transform duration-700"></div>
    
    <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
      <div class="space-y-6">
        <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight">
          Système de <span class="text-secondary italic">chat temps réel</span>
        </h2>
        <p class="text-slate-400 text-lg">
          Une messagerie moderne pour discuter instantanément avec un administrateur.
        </p>
        <div class="flex flex-wrap gap-4 pt-4">
          <a href="<?php echo e(route('chat.index')); ?>" class="px-10 py-5 bg-white text-slate-900 rounded-full font-bold hover:scale-105 transition-transform flex items-center gap-3">
            <i class="fas fa-comments"></i> Démarrer une discussion
          </a>
        </div>
      </div>
      
      <div class="hidden md:flex justify-end">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-[3rem] space-y-6 max-w-sm">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center text-white">
              <i class="fas fa-bolt"></i>
            </div>
            <p class="text-white font-bold">Réponse rapide</p>
          </div>
          <p class="text-slate-400 text-sm leading-relaxed">
            "Notre équipe est en ligne pour répondre à vos questions techniques et commerciales immédiatement."
          </p>
          <div class="flex -space-x-3 pt-2">
            <?php $__currentLoopData = range(1, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="w-10 h-10 rounded-full border-2 border-slate-900 bg-slate-800"></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
  }
  @keyframes float-delayed {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
  }
  @keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  .animate-float { animation: float 6s ease-in-out infinite; }
  .animate-float-delayed { animation: float-delayed 7s ease-in-out infinite 1s; }
  .animate-bounce-slow { animation: bounce-slow 5s ease-in-out infinite; }
  .animate-fade-in {
    animation: fadeIn 1s ease-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/monblog/resources/views/home.blade.php ENDPATH**/ ?>