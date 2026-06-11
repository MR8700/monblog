<?php $__env->startSection('title', 'Gestion des Clients - Admin'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-bold text-slate-900 mb-2">Clients</h1>
                <p class="text-slate-600">Liste des clients ayant passé au moins une commande.</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-soft">
            <form action="<?php echo e(url()->current()); ?>" method="GET" class="flex gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nom, Email ou Téléphone..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                </div>
                <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg">
                    Rechercher
                </button>
            </form>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-black uppercase tracking-widest">
                            <th class="px-6 py-4 font-semibold border-b">Client</th>
                            <th class="px-6 py-4 font-semibold border-b">Contact</th>
                            <th class="px-6 py-4 font-semibold border-b">Commandes</th>
                            <th class="px-6 py-4 font-semibold border-b">Total Dépensé</th>
                            <th class="px-6 py-4 font-semibold border-b">Dernier Achat</th>
                            <th class="px-6 py-4 font-semibold border-b text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center font-bold">
                                            <?php echo e(strtoupper(substr($customer->user_name, 0, 1))); ?>

                                        </div>
                                        <span class="font-bold text-slate-900"><?php echo e($customer->user_name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-slate-700"><?php echo e($customer->user_email); ?></span>
                                        <span class="text-xs text-slate-400"><?php echo e($customer->user_phone); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">
                                        <?php echo e($customer->orders_count); ?> commande(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-900"><?php echo e(number_format($customer->total_spent, 2)); ?>€</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">
                                        <?php echo e(\Carbon\Carbon::parse($customer->last_order_at)->format('d/m/Y')); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="<?php echo e(route('admin.customers.show', $customer->user_email)); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-xl font-bold hover:bg-primary hover:text-white transition-all">
                                        <i class="fas fa-history text-xs"></i> Historique
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">
                                    Aucun client enregistré pour le moment.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($customers->hasPages()): ?>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    <?php echo e($customers->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/monblog/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>