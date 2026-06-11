<?php $__env->startSection('title', 'Gestion des Produits - Admin'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[3rem] border border-slate-100 shadow-soft">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Catalogue <span class="text-primary italic font-display">Digital</span></h1>
            <p class="text-slate-500">Gérez vos applications, services et outils numériques en un clic.</p>
        </div>
        <?php if(auth()->guard('admin')->check()): ?>
        <div class="flex gap-4">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-transform flex items-center gap-2">
                <i class="fas fa-plus"></i> Nouveau Produit
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-soft">
        <form action="<?php echo e(url()->current()); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Rechercher un produit..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
            </div>
            <div>
                <select name="type" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                    <option value="">Tous les types</option>
                    <option value="work" <?php echo e(request('type') == 'work' ? 'selected' : ''); ?>>Work</option>
                    <option value="app" <?php echo e(request('type') == 'app' ? 'selected' : ''); ?>>App</option>
                    <option value="task" <?php echo e(request('type') == 'task' ? 'selected' : ''); ?>>Task</option>
                    <option value="service" <?php echo e(request('type') == 'service' ? 'selected' : ''); ?>>Service</option>
                </select>
            </div>
            <div class="flex gap-2">
                <?php if(auth()->guard('admin')->check()): ?>
                <select name="published" class="flex-1 px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                    <option value="">Statut</option>
                    <option value="yes" <?php echo e(request('published') == 'yes' ? 'selected' : ''); ?>>Public</option>
                    <option value="no" <?php echo e(request('published') == 'no' ? 'selected' : ''); ?>>Brouillon</option>
                </select>
                <?php endif; ?>
                <button type="submit" class="flex-1 px-6 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table/Grid -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Produit</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Type & Prix</th>
                        <?php if(auth()->guard('admin')->check()): ?>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Statut</th>
                        <?php endif; ?>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden border border-slate-100">
                                        <img src="<?php echo e($product->image ?? 'https://via.placeholder.com/100'); ?>" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900"><?php echo e($product->title); ?></h4>
                                        <p class="text-xs text-slate-400">Créé le <?php echo e($product->created_at->format('d/m/Y')); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-secondary bg-secondary/5 px-2 py-0.5 rounded-full"><?php echo e($product->type); ?></span>
                                    <p class="font-black text-primary"><?php echo e(number_format($product->price, 0, ',', ' ')); ?> <span class="text-[10px] opacity-50">CFA</span></p>
                                </div>
                            </td>
                            <?php if(auth()->guard('admin')->check()): ?>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?php echo e($product->published ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-400'); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($product->published ? 'bg-green-600' : 'bg-slate-400'); ?>"></span>
                                    <?php echo e($product->published ? 'Public' : 'Brouillon'); ?>

                                </span>
                            </td>
                            <?php endif; ?>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-primary/10 hover:text-primary transition-all">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <?php if(auth()->guard('admin')->check()): ?>
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-amber-500/10 hover:text-amber-500 transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-danger/10 hover:text-danger transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-6 bg-slate-50/50">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/monblog/resources/views/admin/products/index.blade.php ENDPATH**/ ?>