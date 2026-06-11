@extends('layout.app')

@section('title', 'Historique Client - Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-12">
        <!-- Client Header Card -->
        <div class="bg-slate-900 rounded-[3rem] p-10 md:p-16 text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/20 blur-[120px] rounded-full"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-10">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur rounded-3xl flex items-center justify-center text-3xl font-bold border border-white/20">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-4xl font-bold tracking-tight">{{ $customer->name }}</h1>
                        <p class="text-slate-400 font-medium flex items-center gap-2">
                            <i class="fas fa-envelope text-primary"></i> {{ $customer->email }}
                            <span class="mx-2 text-slate-700">•</span>
                            <i class="fas fa-phone text-secondary"></i> {{ $customer->phone }}
                        </p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="text-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Total Commandes</p>
                        <p class="text-2xl font-bold">{{ $customer->orders_count }}</p>
                    </div>
                    <div class="w-px h-10 bg-white/10 self-center"></div>
                    <div class="text-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Total Dépensé</p>
                        <p class="text-2xl font-bold text-primary">{{ number_format($customer->total_spent, 0, ',', ' ') }} CFA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Timeline -->
        <div class="space-y-8">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                <i class="fas fa-history text-primary"></i>
                Historique des achats
            </h2>

            <div class="space-y-6">
                @foreach($customer->orders as $order)
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40 hover:border-primary/20 transition-all group">
                        <div class="flex flex-col md:flex-row justify-between gap-8">
                            <div class="space-y-4 flex-1">
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-black text-slate-900">COMMANDE #{{ $order->id }}</span>
                                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $order->status }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                
                                <div class="grid gap-4">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100/50">
                                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                                                <i class="fas {{ $item->product_id ? 'fa-box' : 'fa-file-alt' }}"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-bold text-slate-900 text-sm">
                                                    {{ $item->product ? $item->product->name : $item->post->title }}
                                                </p>
                                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">
                                                    Qté: {{ $item->quantity }} • {{ number_format($item->price, 0, ',', ' ') }} CFA / unité
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-slate-900">{{ number_format($item->quantity * $item->price, 0, ',', ' ') }} CFA</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="md:w-64 flex flex-col justify-between items-end gap-6">
                                <div class="text-right">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Montant Total</p>
                                    <p class="text-3xl font-bold text-slate-900">{{ number_format($order->total_price, 0, ',', ' ') }} CFA</p>
                                </div>
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg shadow-slate-900/10">
                                    Détails Commande <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
