@extends('layout.app')

@section('title', 'Commandes - Admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-heading">Commandes</h1>
    <div class="flex gap-2">
      <select id="statusFilter" class="px-4 py-2 rounded-lg border border-primary text-sm font-medium">
        <option value="">Tous les statuts</option>
        <option value="pending">En attente</option>
        <option value="confirmed">Confirmée</option>
        <option value="processing">En cours</option>
        <option value="completed">Complétée</option>
        <option value="cancelled">Annulée</option>
      </select>
    </div>
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
    <table class="w-full text-left text-sm">
      <thead class="bg-slate-50 border-b border-slate-200">
        <tr>
          <th class="px-6 py-4 font-semibold">ID / Client</th>
          <th class="px-6 py-4 font-semibold">Articles</th>
          <th class="px-6 py-4 font-semibold">Total</th>
          <th class="px-6 py-4 font-semibold">Statut</th>
          <th class="px-6 py-4 font-semibold">Date</th>
          <th class="px-6 py-4 font-semibold">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr class="border-t border-slate-100 hover:bg-slate-50/50 transition">
            <td class="px-6 py-4">
              <div>
                <p class="font-semibold">#{{ $order->id }}</p>
                <p class="text-xs text-slate-600">{{ $order->customer_name }}</p>
                <p class="text-xs text-slate-500">{{ $order->customer_email }}</p>
              </div>
            </td>
            <td class="px-6 py-4">
              <p class="font-medium">{{ $order->order_items_count ?? $order->orderItems->count() }} article(s)</p>
              <p class="text-xs text-slate-600">{{ $order->total_amount ?? $order->order_items->sum('quantity') }} unité(s)</p>
            </td>
            <td class="px-6 py-4">
              <p class="font-semibold text-lg">{{ number_format($order->total_price, 2) }}€</p>
            </td>
            <td class="px-6 py-4">
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
            <td class="px-6 py-4">
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

  <!-- Pagination -->
  <div class="mt-6">
    {{ $orders->links() }}
  </div>
</section>

@push('scripts')
<script>
document.getElementById('statusFilter').addEventListener('change', function() {
  const status = this.value;
  const url = new URL(window.location);
  if (status) {
    url.searchParams.set('status', status);
  } else {
    url.searchParams.delete('status');
  }
  window.location = url.toString();
});

// Auto-filter if status param exists
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');
if (status) {
  document.getElementById('statusFilter').value = status;
}
</script>
@endpush
@endsection
