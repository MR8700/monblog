@extends('layout.app')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <a href="{{ route('admin.orders.index') }}" class="text-primary hover:text-primary-dark transition mb-2 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Retour aux commandes
      </a>
      <h1 class="text-3xl font-heading">Commande #{{ $order->id }}</h1>
      <p class="text-slate-600 mt-1">{{ $order->created_at->format('d F Y à H:i') }}</p>
    </div>
    <div class="flex gap-2">
      <button 
        onclick="printOrder()"
        class="btn btn-primary rounded-full"
      >
        <i class="fas fa-print mr-1"></i> Imprimer
      </button>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Status -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2">
          <i class="fas fa-info-circle text-primary"></i> Statut de la commande
        </h3>
        <div class="space-y-3">
          <div class="flex items-center gap-4">
            <select 
              id="statusSelect"
              class="flex-1 px-4 py-2 rounded-lg border border-primary text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/30"
              onchange="updateOrderStatus(this.value)"
            >
              <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
              <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
              <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En cours</option>
              <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Complétée</option>
              <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
            </select>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
              {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
              {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
              {{ $order->status === 'processing' ? 'bg-purple-100 text-purple-700' : '' }}
              {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
              {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
            ">
              {{ ucfirst($order->status) }}
            </span>
          </div>
        </div>
      </div>

      <!-- Articles commandés -->
      <div class="glass rounded-2xl p-6 overflow-x-auto">
        <h3 class="font-semibold mb-4 flex items-center gap-2">
          <i class="fas fa-box text-primary"></i> Articles ({{ $order->orderItems->count() }})
        </h3>
        <table class="w-full text-sm">
          <thead class="bg-slate-50 rounded-lg">
            <tr class="border-b">
              <th class="text-left px-4 py-2 font-semibold">Produit</th>
              <th class="text-center px-4 py-2 font-semibold">Quantité</th>
              <th class="text-right px-4 py-2 font-semibold">Prix unitaire</th>
              <th class="text-right px-4 py-2 font-semibold">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->orderItems as $item)
              <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                <td class="px-4 py-3">
                  <div>
                    <p class="font-medium">{{ $item->product->name ?? 'Produit supprimé' }}</p>
                    @if($item->product)
                      <p class="text-xs text-slate-600">{{ $item->product->slug }}</p>
                    @endif
                  </div>
                </td>
                <td class="text-center px-4 py-3">
                  <span class="font-semibold">{{ $item->quantity }}</span>
                </td>
                <td class="text-right px-4 py-3">
                  {{ number_format($item->unit_price, 2) }}€
                </td>
                <td class="text-right px-4 py-3 font-semibold">
                  {{ number_format($item->quantity * $item->unit_price, 2) }}€
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Notes -->
      @if($order->notes ?? null)
        <div class="glass rounded-2xl p-6 bg-blue-50/50 border border-blue-100">
          <h3 class="font-semibold mb-2 flex items-center gap-2 text-blue-900">
            <i class="fas fa-sticky-note text-blue-600"></i> Notes
          </h3>
          <p class="text-blue-900 text-sm">{{ $order->notes }}</p>
        </div>
      @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
      <!-- Informations client -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2">
          <i class="fas fa-user text-primary"></i> Client
        </h3>
        <div class="space-y-2 text-sm">
          <div>
            <span class="text-slate-600">Nom</span>
            <p class="font-medium">{{ $order->customer_name }}</p>
          </div>
          <div class="border-t pt-2">
            <span class="text-slate-600">Email</span>
            <p class="font-medium break-all">{{ $order->customer_email }}</p>
          </div>
          <div class="border-t pt-2">
            <span class="text-slate-600">Téléphone</span>
            <p class="font-medium">{{ $order->customer_phone ?? 'Non fourni' }}</p>
          </div>
        </div>
      </div>

      <!-- Récapitulatif financier -->
      <div class="glass rounded-2xl p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2">
          <i class="fas fa-calculator text-primary"></i> Récapitulatif
        </h3>
        <div class="space-y-3 text-sm">
          <div class="flex justify-between">
            <span class="text-slate-600">Sous-total</span>
            <span>{{ number_format($order->orderItems->sum(fn($i) => $i->quantity * $i->unit_price), 2) }}€</span>
          </div>
          @if(($order->tax_amount ?? 0) > 0)
            <div class="flex justify-between border-t pt-3">
              <span class="text-slate-600">TVA {{ ($order->tax_rate ?? 20) }}%</span>
              <span>{{ number_format($order->tax_amount, 2) }}€</span>
            </div>
          @endif
          @if(($order->shipping_cost ?? 0) > 0)
            <div class="flex justify-between border-t pt-3">
              <span class="text-slate-600">Frais de port</span>
              <span>{{ number_format($order->shipping_cost, 2) }}€</span>
            </div>
          @endif
          <div class="flex justify-between border-t pt-3 font-semibold text-base">
            <span>Total TTC</span>
            <span class="text-primary">{{ number_format($order->total_price, 2) }}€</span>
          </div>
        </div>
      </div>

      <!-- Métadonnées -->
      <div class="glass rounded-2xl p-6 text-sm space-y-3">
        <div>
          <span class="text-slate-600 block mb-1">ID Client IP</span>
          <code class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $order->customer_ip ?? 'N/A' }}</code>
        </div>
        <div class="border-t pt-3">
          <span class="text-slate-600 block mb-1">Créée le</span>
          <p>{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        </div>
        <div class="border-t pt-3">
          <span class="text-slate-600 block mb-1">Modifiée le</span>
          <p>{{ $order->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>
      </div>

      <!-- Actions -->
      <div class="glass rounded-2xl p-6 space-y-2">
        <h3 class="font-semibold mb-3">Actions</h3>
        <button 
          onclick="sendConfirmationEmail()"
          class="w-full px-4 py-2 text-sm rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition flex items-center justify-center gap-2"
        >
          <i class="fas fa-envelope"></i> Envoyer confirmation
        </button>
        <button 
          onclick="if(confirm('Voulez-vous vraiment annuler cette commande ?')) deleteOrder()"
          class="w-full px-4 py-2 text-sm rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition flex items-center justify-center gap-2"
        >
          <i class="fas fa-times"></i> Annuler
        </button>
      </div>
    </div>
  </div>

  <!-- Delete form (hidden) -->
  <form id="deleteForm" action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>
</div>

<script>
function updateOrderStatus(status) {
  fetch('{{ route("admin.orders.update", $order) }}', {
    method: 'PUT',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ status: status })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      showToast('Statut mis à jour', 'success');
    } else {
      showToast('Erreur lors de la mise à jour', 'danger');
      location.reload();
    }
  })
  .catch(() => {
    showToast('Erreur réseau', 'danger');
    location.reload();
  });
}

function sendConfirmationEmail() {
  showToast('Envoi de l\'email en cours...', 'info');
  // TODO: Implémenter l'envoi d'email
}

function deleteOrder() {
  if (confirm('Cette action est irréversible')) {
    document.getElementById('deleteForm').submit();
  }
}

function printOrder() {
  window.print();
}

function showToast(message, type) {
  // Utiliser le système de toast Alpine.js si disponible
  console.log(`[${type.toUpperCase()}] ${message}`);
}
</script>
@endsection
