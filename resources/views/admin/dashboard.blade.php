@extends('layout.app')

@section('title', 'Tableau de Bord - DigitalSpace Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-6 md:p-10 rounded-[2rem] md:rounded-[3rem] border border-slate-100 shadow-soft">
        <div class="flex items-center gap-4 md:gap-6">
            <div class="w-16 h-16 md:w-24 md:h-24 rounded-2xl md:rounded-[2rem] overflow-hidden shadow-2xl shadow-primary/20 border-4 border-white flex-none">
                @if(Auth::guard('admin')->user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_picture) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white text-2xl md:text-4xl font-black">
                        {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="space-y-1">
                <h1 class="text-2xl md:text-4xl font-bold text-slate-900 tracking-tight">Bonjour, <span class="text-primary italic font-display">{{ Auth::guard('admin')->user()->name }}</span> !</h1>
                <p class="text-xs md:text-sm text-slate-500 font-medium">Ravi de vous revoir. Voici l'état de votre espace digital.</p>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.profile.edit') }}" class="w-full md:w-auto px-6 py-3 md:px-8 md:py-4 bg-slate-900 text-white rounded-2xl md:rounded-[2rem] font-bold shadow-xl shadow-slate-900/10 hover:bg-primary transition-all flex items-center justify-center gap-2 group">
                <i class="fas fa-user-circle text-slate-400 group-hover:text-white transition-colors"></i>
                <span>Mon Profil</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Revenue Card -->
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-soft group hover:border-green-500 transition-colors cursor-pointer">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-green-500 group-hover:text-white transition-all">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Revenus</span>
            </div>
            <p class="text-3xl font-black text-slate-900 mb-1">{{ number_format($totalTurnover, 0, ',', ' ') }} <span class="text-sm">CFA</span></p>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Chiffre d'Affaires</p>
        </div>

        <!-- Profit Card -->
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-soft group hover:border-emerald-500 transition-colors cursor-pointer">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Profit</span>
            </div>
            <p class="text-3xl font-black text-slate-900 mb-1">{{ number_format($totalProfit, 0, ',', ' ') }} <span class="text-sm">CFA</span></p>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Bénéfice Estimé</p>
        </div>

        <!-- Sales Card -->
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-soft group hover:border-primary transition-colors cursor-pointer">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-primary/5 text-primary rounded-2xl flex items-center justify-center text-2xl group-hover:bg-primary group-hover:text-white transition-all">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Ventes</span>
            </div>
            <p class="text-4xl font-black text-slate-900 mb-1">{{ number_format($totalSalesCount) }}</p>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Commandes payées</p>
        </div>

        <!-- Posts Card -->
        <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-soft group hover:border-indigo-500 transition-colors cursor-pointer">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-indigo-500 group-hover:text-white transition-all">
                    <i class="fas fa-newspaper"></i>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Blog</span>
            </div>
            <p class="text-4xl font-black text-slate-900 mb-1">{{ $publishedPosts }}</p>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Articles publiés</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Quick Actions Sidebar -->
        <div class="space-y-8">
            <div class="bg-slate-900 p-10 rounded-[3.5rem] shadow-2xl shadow-slate-900/30 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative space-y-8">
                    <h2 class="text-2xl font-black italic font-display">Actions <span class="text-primary">Rapides</span></h2>
                    <div class="grid gap-3">
                        <a href="{{ route('admin.products.create') }}" class="flex items-center gap-4 p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-all group">
                            <i class="fas fa-plus text-primary group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm font-bold">Nouveau Produit</span>
                        </a>
                        <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-4 p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-all group">
                            <i class="fas fa-pen-nib text-secondary group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm font-bold">Rédiger un Article</span>
                        </a>
                        <a href="{{ route('admin.portfolio.create') }}" class="flex items-center gap-4 p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-all group">
                            <i class="fas fa-briefcase text-indigo-400 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm font-bold">Ajouter un Projet</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Site Settings Quick View -->
            <div class="bg-white p-10 rounded-[3.5rem] border border-slate-100 shadow-soft space-y-8">
                <h2 class="text-xl font-black text-slate-900">Configuration <span class="text-slate-400 italic font-display">Site</span></h2>
                <div class="space-y-4">
                    @can('manage-admins')
                    <a href="{{ route('admin.admins.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 flex items-center justify-between group cursor-pointer hover:border-primary transition-colors">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-user-shield text-slate-300 group-hover:text-primary transition-colors"></i>
                            <span class="text-xs font-bold text-slate-600">Gérer l'Équipe</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    </a>
                    @endcan
                    <div class="p-4 bg-white rounded-2xl border border-slate-100 flex items-center justify-between group cursor-pointer hover:border-primary transition-colors">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-envelope-open-text text-slate-300 group-hover:text-primary transition-colors"></i>
                            <span class="text-xs font-bold text-slate-600">Config Email</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-red-50 text-red-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all flex items-center justify-center gap-3 group">
                            <i class="fas fa-power-off group-hover:rotate-90 transition-transform"></i>
                            <span>Déconnexion Sécurisée</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Latest Content -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Latest Sales -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-black text-slate-900 italic font-display">Ventes <span class="text-primary">Récentes</span></h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-xs font-black text-slate-400 hover:text-primary transition-colors uppercase tracking-widest">Tout voir</a>
                </div>
                
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden">
                    @forelse($latestProducts as $product)
                        <div class="p-6 border-b border-slate-50 flex items-center justify-between hover:bg-slate-50/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-none">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/50' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $product->title }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $product->type }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-black text-primary">{{ number_format($product->price, 0, ',', ' ') }} <span class="text-[10px]">CFA</span></p>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 italic">Aucune donnée disponible</div>
                    @endforelse
                </div>
            </div>

            <!-- Top Products -->
            <div class="space-y-6">
                <h2 class="text-2xl font-black text-slate-900 italic font-display">Produits <span class="text-secondary">Phare</span></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($topProducts as $product)
                        <div class="p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-soft hover:shadow-xl transition-all group">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-lg bg-secondary/5 text-secondary flex items-center justify-center text-sm">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Premium</span>
                            </div>
                            <h3 class="font-bold text-slate-900 mb-2 group-hover:text-secondary transition-colors">{{ $product->title }}</h3>
                            <p class="text-2xl font-black text-primary">{{ number_format($product->price, 0, ',', ' ') }} <span class="text-[10px]">CFA</span></p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
number_format($product->price, 0, ',', ' ') }} <span class="text-[10px]">CFA</span></p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
