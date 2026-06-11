<?php $__env->startSection('title', 'Rapport des Ventes - Admin'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-12">
        <div>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Performance des Ventes</h1>
            <p class="text-slate-600">Analyse détaillée des produits et articles les plus populaires.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Produits Physiques / Marketplace -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-briefcase text-primary"></i>
                    Marketplace & Services
                </h2>
                
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-6 py-4">Produit</th>
                                <th class="px-6 py-4 text-center">Vendus</th>
                                <th class="px-6 py-4 text-right">Revenu</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php $__empty_1 = true; $__currentLoopData = $productSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($sale->product->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $sale->product->image)); ?>" class="w-10 h-10 rounded-lg object-cover">
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                                    <i class="fas fa-box text-xs"></i>
                                                </div>
                                            <?php endif; ?>
                                            <span class="font-bold text-slate-900 text-sm"><?php echo e($sale->product->title); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700">
                                        <span class="px-3 py-1 bg-slate-100 rounded-full text-xs"><?php echo e($sale->total_sold); ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-black text-primary"><?php echo e(number_format($sale->total_revenue, 2)); ?>€</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?php echo e(route('admin.reports.sales.product', $sale->product)); ?>" class="text-xs font-bold text-slate-400 hover:text-primary transition-all">
                                            Détails <i class="fas fa-chevron-right text-[8px] ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">Aucune vente pour le moment.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Articles Payants / Blog -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-pen text-secondary"></i>
                    Articles de Blog
                </h2>
                
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-6 py-4">Article</th>
                                <th class="px-6 py-4 text-center">Accès Vendus</th>
                                <th class="px-6 py-4 text-right">Revenu</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php $__empty_1 = true; $__currentLoopData = $postSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($sale->post->cover_image): ?>
                                                <img src="<?php echo e(asset('storage/' . $sale->post->cover_image)); ?>" class="w-10 h-10 rounded-lg object-cover">
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                                    <i class="fas fa-file-alt text-xs"></i>
                                                </div>
                                            <?php endif; ?>
                                            <span class="font-bold text-slate-900 text-sm line-clamp-1"><?php echo e($sale->post->title); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-700">
                                        <span class="px-3 py-1 bg-slate-100 rounded-full text-xs"><?php echo e($sale->total_sold); ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-black text-secondary"><?php echo e(number_format($sale->total_revenue, 2)); ?>€</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="<?php echo e(route('admin.reports.sales.post', $sale->post)); ?>" class="text-xs font-bold text-slate-400 hover:text-secondary transition-all">
                                            Détails <i class="fas fa-chevron-right text-[8px] ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">Aucun accès article vendu.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/monblog/resources/views/admin/reports/products.blade.php ENDPATH**/ ?>