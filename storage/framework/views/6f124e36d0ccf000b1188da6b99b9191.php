<?php $__env->startSection('title', 'Modifier Produit - Admin'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-4xl mx-auto px-6 py-12 space-y-12">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Modifier <span class="text-secondary italic font-display"><?php echo e($product->title); ?></span></h1>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-primary transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Annuler & Retour
        </a>
    </div>

    <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-soft space-y-8">
            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Titre du produit</label>
                    <input type="text" name="title" value="<?php echo e(old('title', $product->title)); ?>" required
                           class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Type de service</label>
                    <select name="type" required class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                        <option value="app" <?php echo e($product->type == 'app' ? 'selected' : ''); ?>>Application</option>
                        <option value="service" <?php echo e($product->type == 'service' ? 'selected' : ''); ?>>Service</option>
                        <option value="task" <?php echo e($product->type == 'task' ? 'selected' : ''); ?>>Tâche / Code</option>
                        <option value="work" <?php echo e($product->type == 'work' ? 'selected' : ''); ?>>Travail Portfolio</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Prix (CFA)</label>
                    <input type="number" name="price" value="<?php echo e(old('price', $product->price)); ?>"
                           class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Description complète</label>
                <textarea name="description" rows="5" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-6 py-4 focus:outline-none focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium"><?php echo e(old('description', $product->description)); ?></textarea>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Image de couverture</label>
                    <?php if($product->image): ?>
                        <div class="w-32 h-32 rounded-2xl overflow-hidden border border-slate-100 mb-2">
                            <img src="<?php echo e($product->image); ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-6 py-4 text-sm">
                </div>
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Fichier numérique</label>
                    <?php if($product->file_path): ?>
                        <div class="p-4 bg-green-50 text-green-600 rounded-2xl text-xs font-bold flex items-center gap-2">
                            <i class="fas fa-file-shield"></i> Fichier déjà présent
                        </div>
                    <?php endif; ?>
                    <input type="file" name="file" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-6 py-4 text-sm">
                </div>
            </div>

            <div class="flex items-center gap-4 p-6 bg-slate-50 rounded-2xl">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="published" value="1" id="published" <?php echo e($product->published ? 'checked' : ''); ?> class="w-5 h-5 rounded-lg text-primary focus:ring-primary border-slate-300">
                    <label for="published" class="text-sm font-bold text-slate-700">Publié</label>
                </div>
                <div class="flex items-center gap-3 ml-8">
                    <input type="checkbox" name="is_downloadable" value="1" id="is_downloadable" <?php echo e($product->is_downloadable ? 'checked' : ''); ?> class="w-5 h-5 rounded-lg text-primary focus:ring-primary border-slate-300">
                    <label for="is_downloadable" class="text-sm font-bold text-slate-700">Téléchargeable</label>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-secondary text-white rounded-3xl font-black uppercase tracking-[0.2em] shadow-2xl shadow-secondary/20 hover:bg-secondary-dark hover:-translate-y-1 transition-all">
                    Enregistrer les Modifications
                </button>
            </div>
        </div>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/monblog/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>