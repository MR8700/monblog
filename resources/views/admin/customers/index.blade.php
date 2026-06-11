@extends('layout.app')

@section('title', 'Gestion des Clients - Admin')

@section('content')
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
            <form action="{{ url()->current() }}" method="GET" class="flex gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, Email ou Téléphone..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
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
                        @forelse($customers as $customer)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($customer->user_name, 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-slate-900">{{ $customer->user_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-slate-700">{{ $customer->user_email }}</span>
                                        <span class="text-xs text-slate-400">{{ $customer->user_phone }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">
                                        {{ $customer->orders_count }} commande(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-900">{{ number_format($customer->total_spent, 0, ',', ' ') }} CFA</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($customer->last_order_at)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.customers.show', $customer->user_email) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-xl font-bold hover:bg-primary hover:text-white transition-all">
                                        <i class="fas fa-history text-xs"></i> Historique
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">
                                    Aucun client enregistré pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
