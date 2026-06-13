@extends('layout.app')

@section('title', 'Commandes - Admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-heading">Commandes</h1>
  </div>

  <!-- Filters -->
  <div class="glass p-6 rounded-3xl mb-8">
    <form action="{{ url()->current() }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2 relative">
            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Client, Email, Réf..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
        </div>
        <div>
            <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En cours</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Complétée</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>
        <div class="flex gap-2">
            <select name="payment_status" class="flex-1 px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                <option value="">Paiement</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Payé</option>
                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Non payé</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Échoué</option>
            </select>
            <button type="submit" class="px-6 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </form>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="glass rounded-2xl p-4">
      <p class="text-slate-600 text-sm mb-1">Total commandes</p>
      <p class="text-2xl font-bold">{{ number_format($orders->total()) }}</p>
    </div>
    <div class="glass rounded-2xl p-4">
      <p class="text-slate-600 text-sm mb-1">En attente</p>
      <p class="text-2xl font-bold text-yellow-600">{{ $orders->where('status', 'pending')->count() }}</p>
    </div>
    <div class="glass rounded-2xl p-4">
      <p class="text-slate-600 text-sm mb-1">En cours</p>
      <p class="text-2xl font-bold text-blue-600">{{ $orders->where('status', 'processing')->count() }}</p>
    </div>
    <div class="glass rounded-2xl p-4">
      <p class="text-slate-600 text-sm mb-1">Complétées</p>
      <p class="text-2xl font-bold text-green-600">{{ $orders->where('status', 'completed')->count() }}</p>
    </div>
    <div class="glass rounded-2xl p-4">
      <p class="text-slate-600 text-sm mb-1">Revenu total</p>
      <p class="text-2xl font-bold text-primary">{{ number_format($orders->sum('total_price'), 2) }}€</p>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="glass rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
      <thead class="bg-slate-50 border-b border-slate-200">
        <tr>
          <th class="px-6 py-4 font-semibold">ID / Client</th>
          <th class="px-6 py-4 font-semibold text-center">Articles</th>
          <th class="px-6 py-4 font-semibold text-center">Total</th>
          <th class="px-6 py-4 font-semibold text-center">Statut</th>
          <th class="px-6 py-4 font-semibold">Date</th>
          <th class="px-6 py-4 font-semibold text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr class="border-t border-slate-100 hover:bg-slate-50/50 transition">
            <td class="px-6 py-4">
              <div>
                <p class="font-semibold">#{{ $order->id }}</p>
                <p class="text-xs text-slate-600">{{ $order->user_name }}</p>
                <p class="text-xs text-slate-500">{{ $order->user_email }}</p>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <p class="font-medium">{{ $order->items_count ?? $order->items->count() }} article(s)</p>
              <p class="text-xs text-slate-600">{{ $order->total_amount ?? $order->items->sum('quantity') }} unité(s)</p>
            </td>
            <td class="px-6 py-4 text-center">
              <p class="font-semibold text-lg">{{ number_format($order->total_price, 0, ',', ' ') }} CFA</p>
            </td>
            <td class="px-6 py-4 text-center">
              <span class="px-3 py-1 text-xs font-semibold rounded-full
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $order->status === 'processing' ? 'bg-purple-100 text-purple-700' : '' }}
                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
              ">
                {{ ucfirst($order->status) }}
              </span>
            </td>
            <td class="px-6 py-4 text-xs text-slate-600">
              {{ $order->created_at->format('d/m/Y H:i') }}
            </td>
            <td class="px-6 py-4 text-right">
              <a 
                href="{{ route('admin.orders.show', $order) }}"
                class="text-primary hover:text-primary-dark font-semibold transition inline-flex items-center gap-1"
              >
                <i class="fas fa-eye"></i> Voir
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-6 py-8 text-center text-slate-600">
              <i class="fas fa-inbox text-3xl mb-2 opacity-30 block"></i>
              Aucune commande trouvée.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $orders->links() }}
  </div>
</section>

@endsection
