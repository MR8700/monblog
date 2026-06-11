@extends('layout.app')

@section('title', 'Commande #' . $order->id)

@section('content')
<style>
    @media print {
        body * { visibility: hidden; }
        #invoice, #invoice * { visibility: visible; }
        #invoice { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%; 
            padding: 40px;
            background: white !important;
            color: black !important;
        }
        .no-print { display: none !important; }
        .glass, .btn, nav, footer { display: none !important; }
        body { background: white !important; }
    }
</style>

<div class="max-w-5xl mx-auto px-6 py-12">
  <!-- Header (Hidden on Print) -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 no-print">
    <div>
      <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-primary transition mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Retour aux commandes
      </a>
      <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Détails de la <span class="text-primary italic">Commande</span></h1>
      <p class="text-slate-500 mt-2 font-medium">Référence #{{ $order->id }} • {{ $order->created_at->format('d/m/Y à H:i') }}</p>
    </div>
    <div class="flex items-center gap-3">
      <button 
        onclick="window.print()"
        class="flex items-center gap-2 px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-xl shadow-slate-900/20"
      >
        <i class="fas fa-print"></i> Imprimer la facture
      </button>
    </div>
  </div>

  <!-- Main Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 no-print">
    <!-- Left Column: Details & Items -->
    <div class="lg:col-span-2 space-y-8">
      <!-- Status Card -->
      <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center text-sm">
                    <i class="fas fa-sync-alt"></i>
                </div>
                Suivi du Statut
            </h3>
            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest
              {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
              {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
              {{ $order->status === 'processing' ? 'bg-purple-100 text-purple-700' : '' }}
              {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
              {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
            ">
              {{ $order->status }}
            </span>
        </div>

        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex flex-col md:flex-row gap-4">
            @csrf
            @method('PUT')
            <select name="status" class="flex-1 bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✅ Confirmée</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>⚙️ En cours</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>🏁 Complétée</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Annulée</option>
            </select>
            <button type="submit" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all">
                Mettre à jour
            </button>
        </form>
      </div>

      <!-- Payment Info -->
      <div class="bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100">
        <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-3">
            <i class="fas fa-credit-card text-primary text-sm"></i> Informations de Paiement
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Méthode</span>
                <p class="font-bold text-slate-700">{{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'En attente')) }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Statut Financier</span>
                <p class="font-bold">
                    <span class="{{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-slate-500' }}">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </p>
            </div>
            @if($order->payment_reference)
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Référence</span>
                <p class="font-mono text-xs text-slate-500 break-all">{{ $order->payment_reference }}</p>
            </div>
            @endif
        </div>
      </div>

      <!-- Items List -->
      <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
        <h3 class="text-xl font-bold text-slate-900 mb-8 flex items-center gap-3">
            <i class="fas fa-shopping-basket text-primary"></i> Articles Commandés
        </h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-6 bg-slate-50 rounded-[2rem] border border-slate-100/50 hover:border-primary/20 transition-all group">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm border border-slate-100 group-hover:bg-primary group-hover:text-white transition-all">
                            <i class="fas {{ $item->product_id ? 'fa-box' : 'fa-file-alt' }} text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ $item->product->name ?? $item->post->title ?? 'Élément supprimé' }}</p>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                {{ $item->post ? 'Accès Digital' : 'Marketplace' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-12 text-right">
                        <div class="text-center">
                            <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Qté</span>
                            <span class="font-bold text-slate-700">x{{ $item->quantity }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Sous-total</span>
                            <span class="font-black text-slate-900">{{ number_format($item->quantity * $item->price, 0, ',', ' ') }} CFA</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </div>

    <!-- Right Column: Client & Totals -->
    <div class="space-y-8">
      <!-- Client Info -->
      <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40">
        <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-3">
            <i class="fas fa-user-circle text-primary"></i> Informations Client
        </h3>
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary/5 text-primary rounded-xl flex items-center justify-center font-bold">
                    {{ strtoupper(substr($order->user_name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-slate-900">{{ $order->user_name }}</p>
                    <p class="text-xs text-slate-500 font-medium">{{ $order->user_email }}</p>
                </div>
            </div>
            <div class="pt-6 border-t border-slate-50">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2">Téléphone</span>
                <p class="font-bold text-slate-700">{{ $order->user_phone ?? 'Non renseigné' }}</p>
            </div>
            <div class="pt-4">
                <a href="{{ route('admin.customers.show', $order->user_email) }}" class="text-xs font-black uppercase tracking-widest text-primary hover:text-primary-dark transition-all flex items-center gap-2">
                    Voir historique client <i class="fas fa-arrow-right text-[8px]"></i>
                </a>
            </div>
        </div>
      </div>

      <!-- Financial Recap -->
      <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 blur-[60px] rounded-full"></div>
        <h3 class="text-lg font-bold mb-8 relative z-10 flex items-center gap-3">
            <i class="fas fa-calculator text-primary text-sm"></i> Facturation
        </h3>
        <div class="space-y-4 relative z-10">
            <div class="flex justify-between items-center">
                <span class="text-slate-400 font-medium">Sous-total</span>
                <span class="font-bold text-slate-200">{{ number_format($order->total_price, 2) }}€</span>
            </div>
            <div class="flex justify-between items-center border-t border-white/10 pt-4">
                <span class="text-xl font-bold">Total</span>
                <span class="text-3xl font-black text-primary">{{ number_format($order->total_price, 2) }}€</span>
            </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="space-y-3">
        <button onclick="window.print()" class="w-full py-4 bg-white border border-slate-200 text-slate-900 rounded-2xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center gap-3">
            <i class="fas fa-file-invoice"></i> Télécharger PDF
        </button>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette commande ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-4 bg-red-50 text-red-600 rounded-2xl font-bold hover:bg-red-100 transition-all flex items-center justify-center gap-3">
                <i class="fas fa-trash-alt"></i> Supprimer la commande
            </button>
        </form>
      </div>
    </div>
  </div>

  <!-- PRINT ONLY: Professional Invoice -->
  <div id="invoice" class="hidden print:block">
      <div class="flex justify-between items-start mb-12">
          <div>
              <div class="flex items-center gap-3 mb-6">
                  <div class="w-12 h-12 bg-black rounded-xl flex items-center justify-center text-white">
                      <i class="fas fa-cube"></i>
                  </div>
                  <span class="text-2xl font-bold tracking-tight">Digital<span class="text-slate-500">Space</span></span>
              </div>
              <p class="text-sm font-bold uppercase tracking-widest text-slate-400">Agence Digitale Premium</p>
              <p class="text-sm text-slate-500">Ouagadougou, Zone 1, Burkina Faso</p>
              <p class="text-sm text-slate-500">contact@digitalspace.com</p>
          </div>
          <div class="text-right">
              <h2 class="text-4xl font-black uppercase italic text-slate-900 mb-2">Facture</h2>
              <p class="font-bold text-slate-500">RÉFÉRENCE #{{ $order->id }}</p>
              <p class="text-sm text-slate-400 mt-1">Date: {{ $order->created_at->format('d/m/Y') }}</p>
          </div>
      </div>

      <div class="grid grid-cols-2 gap-12 mb-16 py-8 border-y border-slate-100">
          <div>
              <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Client / Destinataire</p>
              <p class="text-lg font-bold text-slate-900">{{ $order->user_name }}</p>
              <p class="text-slate-600">{{ $order->user_email }}</p>
              <p class="text-slate-600">{{ $order->user_phone }}</p>
          </div>
          <div class="text-right">
              <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Paiement</p>
              <p class="font-bold text-slate-900">Méthode: {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</p>
              <p class="font-bold text-slate-600">Statut: {{ strtoupper($order->payment_status) }}</p>
          </div>
      </div>

      <table class="w-full mb-16">
          <thead>
              <tr class="text-left border-b-2 border-slate-900">
                  <th class="py-4 text-xs font-black uppercase tracking-widest">Désignation</th>
                  <th class="py-4 text-center text-xs font-black uppercase tracking-widest">Quantité</th>
                  <th class="py-4 text-right text-xs font-black uppercase tracking-widest">Prix Unitaire</th>
                  <th class="py-4 text-right text-xs font-black uppercase tracking-widest">Total</th>
              </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
              @foreach($order->items as $item)
                  <tr>
                      <td class="py-6">
                          <p class="font-bold text-slate-900">{{ $item->product->name ?? $item->post->title ?? 'Élément supprimé' }}</p>
                          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                              {{ $item->post ? 'Service Digital' : 'Article Marketplace' }}
                          </p>
                      </td>
                      <td class="py-6 text-center font-bold">{{ $item->quantity }}</td>
                      <td class="py-6 text-right font-medium">{{ number_format($item->price, 2) }}€</td>
                      <td class="py-6 text-right font-black">{{ number_format($item->quantity * $item->price, 2) }}€</td>
                  </tr>
              @endforeach
          </tbody>
      </table>

      <div class="flex justify-end">
          <div class="w-72 space-y-4">
              <div class="flex justify-between text-slate-500 font-medium">
                  <span>Sous-total</span>
                  <span>{{ number_format($order->total_price, 2) }}€</span>
              </div>
              <div class="flex justify-between text-slate-500 font-medium">
                  <span>TVA (0%)</span>
                  <span>0.00€</span>
              </div>
              <div class="flex justify-between items-center pt-4 border-t-2 border-slate-900">
                  <span class="text-xl font-black uppercase italic">Total</span>
                  <span class="text-3xl font-black">{{ number_format($order->total_price, 2) }}€</span>
              </div>
          </div>
      </div>

      <div class="mt-32 pt-12 border-t border-slate-100 text-center">
          <p class="text-sm font-bold text-slate-900 mb-2">Merci pour votre confiance !</p>
          <p class="text-xs text-slate-400">Cette facture a été générée automatiquement. DigitalSpace Digital Agency.</p>
      </div>
  </div>
</div>
@endsection
endsection
