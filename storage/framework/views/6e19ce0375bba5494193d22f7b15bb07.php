<?php $__env->startSection('title', 'Accès Sécurisé - Administration'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-screen flex items-center justify-center px-6 py-20 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/10 blur-[120px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary/10 blur-[120px] rounded-full animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="w-full max-w-[450px] animate-fade-in" x-data="loginForm()">
        <!-- Brand -->
        <div class="text-center mb-10 space-y-4">
            <div class="inline-flex w-20 h-20 bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2rem] items-center justify-center text-white shadow-2xl shadow-slate-900/20 rotate-3 hover:rotate-0 transition-transform duration-500 ring-4 ring-white">
                <i class="fas fa-shield-halved text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Espace <span class="text-primary italic font-display">Administrateur</span></h1>
            <p class="text-slate-500 text-sm">Veuillez vous authentifier pour accéder au tableau de bord.</p>
        </div>

        <!-- Card -->
        <div class="bg-white/70 backdrop-blur-2xl p-10 rounded-[3rem] border border-white shadow-2xl shadow-slate-200/50 relative overflow-hidden">
            <!-- Security Light Indicator -->
            <div class="absolute top-0 left-0 w-full h-1 bg-slate-100">
                <div class="h-full bg-primary transition-all duration-1000" :style="{ width: progress + '%' }"></div>
            </div>

            <?php if(session('error')): ?>
                <div class="bg-danger/5 border border-danger/10 text-danger text-xs font-bold p-4 rounded-2xl mb-8 flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-4">Identifiant Expert</label>
                    <div class="relative group">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input type="email" name="email" required placeholder="admin@digitalspace.com"
                               class="w-full bg-white border-2 border-slate-50 rounded-2xl pl-12 pr-5 py-4 focus:outline-none focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium text-slate-700 placeholder:text-slate-300">
                    </div>
                </div>

                <div class="space-y-2" x-data="{ show: false }">
                    <div class="flex justify-between items-center ml-4">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Clef de Sécurité</label>
                        <button type="button" @click="show = !show" class="text-[10px] font-bold text-primary hover:underline">
                            <span x-text="show ? 'Masquer' : 'Afficher'"></span>
                        </button>
                    </div>
                    <div class="relative group">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••••••"
                               x-model="password" @input="checkStrength()"
                               class="w-full bg-white border-2 border-slate-50 rounded-2xl pl-12 pr-12 py-4 focus:outline-none focus:border-primary/20 focus:ring-4 focus:ring-primary/5 transition-all font-medium text-slate-700 placeholder:text-slate-300">
                        
                        <!-- Strength Indicator Light -->
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 flex gap-1">
                            <div class="w-1.5 h-1.5 rounded-full transition-colors" :class="strength > 0 ? (strength > 2 ? 'bg-green-500' : 'bg-amber-500') : 'bg-slate-200'"></div>
                            <div class="w-1.5 h-1.5 rounded-full transition-colors" :class="strength > 2 ? 'bg-green-500' : 'bg-slate-200'"></div>
                            <div class="w-1.5 h-1.5 rounded-full transition-colors" :class="strength > 3 ? 'bg-green-500' : 'bg-slate-200'"></div>
                        </div>
                    </div>

                    <!-- Password Strength Bar -->
                    <div class="px-2 pt-2">
                        <div class="h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-500" 
                                 :class="strengthColor" 
                                 :style="{ width: (strength * 25) + '%' }"></div>
                        </div>
                        <p class="text-[9px] font-bold mt-2 uppercase tracking-widest" :class="strengthTextColor" x-text="strengthText"></p>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-slate-900 text-white rounded-2xl py-5 font-bold shadow-xl shadow-slate-900/20 hover:bg-primary hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 group">
                        <span>Lancer la Session</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Note -->
        <p class="mt-8 text-center text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
            Accès restreint aux administrateurs autorisés.<br>
            Toutes les tentatives de connexion sont journalisées.
        </p>
    </div>
</section>

<script>
    function loginForm() {
        return {
            password: '',
            strength: 0,
            progress: 0,
            init() {
                setTimeout(() => this.progress = 100, 500);
            },
            checkStrength() {
                let s = 0;
                if (this.password.length > 6) s++;
                if (this.password.length > 10) s++;
                if (/[A-Z]/.test(this.password)) s++;
                if (/[0-9]/.test(this.password) && /[^A-Za-z0-9]/.test(this.password)) s++;
                this.strength = s;
            },
            get strengthText() {
                if (!this.password) return 'En attente de saisie...';
                if (this.strength < 2) return 'Sécurité Faible';
                if (this.strength < 4) return 'Sécurité Moyenne';
                return 'Sécurité Maximale';
            },
            get strengthColor() {
                if (this.strength < 2) return 'bg-danger';
                if (this.strength < 4) return 'bg-amber-500';
                return 'bg-green-500';
            },
            get strengthTextColor() {
                if (this.strength < 2) return 'text-danger';
                if (this.strength < 4) return 'text-amber-600';
                return 'text-green-600';
            }
        }
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/monblog/resources/views/admin/login.blade.php ENDPATH**/ ?>