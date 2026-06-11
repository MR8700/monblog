@extends('layout.app')

@section('title', 'Détails des Ventes - ' . ($item->title ?? $item->name))

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-12">
        <!-- Header Item Info -->
        <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col md:flex-row gap-10 items-center">
            <div class="w-32 h-32 rounded-[2rem] overflow-hidden bg-slate-100 flex-shrink-0">
                @php $image = ($type === 'product' ? $item->image : $item->cover_image); @endphp
                @if($image)
                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <i class="fas {{ $type === 'product' ? 'fa-box' : 'fa-file-alt' }} text-4xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1 text-center md:text-left">
                <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4 inline-block">
                    {{ $type === 'product' ? 'Produit Marketplace' : 'Article de Blog' }}
                </span>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $item->title ?? $item->name }}</h1>
                <p class="text-slate-500 font-medium line-clamp-2">{{ Str::limit(strip_tags($item->description ?? $item->content ?? ''), 150) }}</p>
            </div>
            <div class="grid grid-cols-2 gap-6 text-center">
                <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Prix Unitaire</p>
                    <p class="text-xl font-bold text-slate-900">{{ number_format($item->price, 2) }}€</p>
                </div>
                <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Ventes Totales</p>
                    <p class="text-xl font-bold text-primary">{{ $sales->total() }}</p>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                <i class="fas fa-users text-primary"></i>
                Historique des acheteurs
            </h2>

            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-8 py-4">Client</th>
                            <th class="px-8 py-4">Commande</th>
                            <th class="px-8 py-4 text-center">Quantité</th>
                            <th class="px-8 py-4 text-right">Total Payé</th>
                            <th class="px-8 py-4 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-[10px] font-bold text-slate-500">
                                            {{ strtoupper(substr($sale->order->user_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">{{ $sale->order->user_name }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $sale->order->user_email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $sale->order) }}" class="text-primary hover:underline">
                                        #{{ $sale->order->id }}
                                    </a>
                                </td>
                                <td class="px-8 py-6 text-center font-bold text-slate-700">x{{ $sale->quantity }}</td>
                                <td class="px-8 py-6 text-right font-black text-slate-900">
                                    {{ number_format($sale->quantity * $sale->price, 0, ',', ' ') }} CFA
                                </td>
                                <td class="px-8 py-6 text-right text-xs text-slate-500">
                                    {{ $sale->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">Aucun achat enregistré pour cet item.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sales->hasPages())
                <div class="mt-8">
                    {{ $sales->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
