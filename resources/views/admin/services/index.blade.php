@extends('layout.app')

@section('title', 'Demandes de Services - Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12" x-data="{ showTypeManager: false }">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-12">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Demandes de <span class="text-primary italic font-display">Services</span></h1>
            <p class="text-slate-500">Gérez les demandes personnalisées de vos clients.</p>
        </div>
        <button @click="showTypeManager = true" class="px-8 py-4 bg-slate-900 text-white rounded-[2rem] font-bold shadow-xl shadow-slate-900/10 hover:bg-primary transition-all flex items-center gap-3 group">
            <i class="fas fa-concierge-bell text-slate-400 group-hover:text-white transition-colors"></i>
            <span>Gérer les Services</span>
        </button>
    </div>

    @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-3xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-soft mb-8">
        <form action="{{ url()->current() }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Client, Email, Service..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
            </div>
            <div>
                <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En cours</option>
                    <option value="quoted" {{ request('status') == 'quoted' ? 'selected' : '' }}>Devis envoyé</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livré</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div class="flex gap-2">
                <select name="type" class="flex-1 px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                    <option value="">Tous les types</option>
                    @foreach($serviceTypes as $st)
                        <option value="{{ $st->name }}" {{ request('type') == $st->name ? 'selected' : '' }}>{{ $st->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-soft">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-2">Total demandes</p>
            <p class="text-3xl font-black text-slate-900">{{ number_format($requests->total()) }}</p>
        </div>
        <div class="bg-amber-50 p-8 rounded-[2.5rem] border border-amber-100/50 shadow-soft">
            <p class="text-amber-600/60 text-[10px] font-black uppercase tracking-widest mb-2">En attente</p>
            <p class="text-3xl font-black text-amber-600">{{ $requests->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-blue-50 p-8 rounded-[2.5rem] border border-blue-100/50 shadow-soft">
            <p class="text-blue-600/60 text-[10px] font-black uppercase tracking-widest mb-2">En cours</p>
            <p class="text-3xl font-black text-blue-600">{{ $requests->where('status', 'processing')->count() }}</p>
        </div>
        <div class="bg-green-50 p-8 rounded-[2.5rem] border border-green-100/50 shadow-soft">
            <p class="text-green-600/60 text-[10px] font-black uppercase tracking-widest mb-2">Livrées</p>
            <p class="text-3xl font-black text-green-600">{{ $requests->where('status', 'delivered')->count() }}</p>
        </div>
    </div>

    <!-- Services Table -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Client</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Service</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Prix</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Date</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($requests as $request)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $request->client_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $request->client_email }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    {{ $request->service_type }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($request->price)
                                    <p class="font-black text-primary">{{ number_format($request->price, 0, ',', ' ') }} <span class="text-[10px] opacity-50">CFA</span></p>
                                @else
                                    <span class="text-slate-300 italic text-xs">À définir</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full
                                    {{ $request->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $request->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $request->status === 'quoted' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $request->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $request->status === 'delivered' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                    {{ $request->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                ">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-xs font-bold text-slate-400">
                                {{ $request->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <a href="{{ route('admin.services.show', $request) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-primary hover:text-white transition-all text-xs">
                                    Gérer <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-slate-400 italic">
                                Aucune demande de service trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $requests->links() }}
    </div>

    <!-- Modal Gestion des Types de Services -->
    <div x-show="showTypeManager" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showTypeManager = false"></div>
            <div class="relative bg-white rounded-[3rem] max-w-2xl w-full p-10 shadow-2xl overflow-hidden border border-slate-100">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-black text-slate-900">Types de <span class="text-primary italic">Service</span></h2>
                    <button @click="showTypeManager = false" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-8">
                    <!-- Formulaire d'ajout -->
                    <form action="{{ route('admin.services.types.store') }}" method="POST" class="bg-slate-50 p-8 rounded-[2rem] space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Nouveau service</label>
                            <div class="flex gap-2">
                                <input type="text" name="name" required placeholder="Ex: Développement Mobile" class="flex-1 bg-white border-transparent rounded-2xl px-6 py-4 font-bold shadow-sm focus:ring-4 focus:ring-primary/5 transition-all">
                                <button type="submit" class="bg-slate-900 text-white px-8 rounded-2xl font-bold hover:bg-primary transition-all">Ajouter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des types -->
                    <div class="grid gap-3 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($serviceTypes as $type)
                            <div class="flex items-center justify-between p-5 bg-white rounded-2xl border border-slate-100 hover:border-primary/20 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-3 h-3 rounded-full {{ $type->is_active ? 'bg-green-500 shadow-lg shadow-green-500/30' : 'bg-red-500 shadow-lg shadow-red-500/30' }}"></div>
                                    <span class="font-bold {{ $type->is_active ? 'text-slate-900' : 'text-slate-300' }}">{{ $type->name }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <form action="{{ route('admin.services.types.toggle', $type) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl transition-all {{ $type->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                            {{ $type->is_active ? 'Suspendre' : 'Activer' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.services.types.destroy', $type) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce service ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-colors flex items-center justify-center">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endsection
