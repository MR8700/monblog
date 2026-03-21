@extends('layout.app')

@section('title', 'Confirmation de commande')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
  <div class="max-w-2xl w-full">
    <!-- Success Icon -->
    <div class="text-center mb-8">
      <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-green-100 mb-6">
        <i class="fas fa-check text-4xl text-green-600"></i>
      </div>
      <h1 class="text-3xl md:text-4xl font-heading mb-2">Commande confirmée !</h1>
      <p class="text-slate-600 text-lg">Merci pour votre achat</p>
    </div>

    <!-- Order Summary Card -->
    <div class="glass rounded-3xl p-8 space-y-6 mb-8">
      <!-- Order Number -->
      <div class="text-center pb-6 border-b border-slate-200">
        <p class="text-slate-600 mb-1">Numéro de commande</p>
        <p class="text-3xl font-bold text-primary">#{{ $order->id }}</p>
        <p class="text-sm text-slate-600 mt-2">{{ $order->created_at->format('d F Y à H:i') }}</p>
      </div>

      <!-- Order Items -->
      <div>
        <h3 class="font-semibold mb-4 text-lg">Vos articles</h3>
        <div class="space-y-3">
          @foreach($order->orderItems as $item)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
              <div>
                <p class="font-medium">{{ $item->product->name ?? 'Produit' }}</p>
                <p class="text-sm text-slate-600">Quantité: {{ $item->quantity }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold">{{ number_format($item->quantity * $item->unit_price, 2) }}€</p>
                <p class="text-sm text-slate-600">{{ number_format($item->unit_price, 2) }}€ x{{ $item->quantity }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Total -->
      <div class="border-t border-slate-200 pt-6">
        <div class="flex justify-between items-center mb-2">
          <span class="text-slate-600">Sous-total</span>
          <span>{{ number_format($order->orderItems->sum(fn($i) => $i->quantity * $i->unit_price), 2) }}€</span>
        </div>
        @if(($order->tax_amount ?? 0) > 0)
          <div class="flex justify-between items-center mb-2 text-sm text-slate-600">
            <span>TVA</span>
            <span>{{ number_format($order->tax_amount, 2) }}€</span>
          </div>
        @endif
        @if(($order->shipping_cost ?? 0) > 0)
          <div class="flex justify-between items-center mb-4 text-sm text-slate-600">
            <span>Frais de port</span>
            <span>{{ number_format($order->shipping_cost, 2) }}€</span>
          </div>
        @endif
        <div class="flex justify-between items-center text-xl font-bold text-primary border-t pt-4">
          <span>Total TTC</span>
          <span>{{ number_format($order->total_price, 2) }}€</span>
        </div>
      </div>
    </div>

    <!-- Customer Info Card -->
    <div class="glass rounded-3xl p-8 mb-8">
      <h3 class="font-semibold mb-6 text-lg flex items-center gap-2">
        <i class="fas fa-user text-primary"></i> Informations de contact
      </h3>
      <div class="space-y-4">
        <div>
          <p class="text-slate-600 text-sm mb-1">Nom</p>
          <p class="font-medium">{{ $order->customer_name }}</p>
        </div>
        <div>
          <p class="text-slate-600 text-sm mb-1">Email</p>
          <p class="font-medium break-all">{{ $order->customer_email }}</p>
        </div>
        @if($order->customer_phone)
          <div>
            <p class="text-slate-600 text-sm mb-1">Téléphone</p>
            <p class="font-medium">{{ $order->customer_phone }}</p>
          </div>
        @endif
      </div>
      <p class="text-sm text-slate-600 mt-6 pt-6 border-t">
        ✉️ Un email de confirmation a été envoyé à <strong>{{ $order->customer_email }}</strong>
      </p>
    </div>

    <!-- Next Steps -->
    <div class="glass rounded-3xl p-8 bg-blue-50/50 border border-blue-100 mb-8">
      <h3 class="font-semibold mb-4 text-lg flex items-center gap-2 text-blue-900">
        <i class="fas fa-info-circle text-blue-600"></i> Prochaines étapes
      </h3>
      <ol class="space-y-3 text-slate-700 text-sm">
        <li class="flex gap-3">
          <span class="flex-shrink-0 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">1</span>
          <span><strong>Confirmation :</strong> Vous recevrez un email de confirmation dans les prochaines minutes</span>
        </li>
        <li class="flex gap-3">
          <span class="flex-shrink-0 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">2</span>
          <span><strong>Traitement :</strong> Votre commande est en cours de traitement</span>
        </li>
        <li class="flex gap-3">
          <span class="flex-shrink-0 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">3</span>
          <span><strong>Envoi :</strong> Vous serez notifié lors de l'expédition</span>
        </li>
        <li class="flex gap-3">
          <span class="flex-shrink-0 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">4</span>
          <span><strong>Livraison :</strong> Suivi de livraison mis à jour régulièrement</span>
        </li>
      </ol>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <a 
        href="{{ route('home') }}"
        class="px-6 py-3 rounded-xl border-2 border-primary text-primary font-semibold hover:bg-primary/5 transition text-center flex items-center justify-center gap-2"
      >
        <i class="fas fa-home"></i> Retour à l'accueil
      </a>
      <a 
        href="{{ route('blog.index') }}"
        class="px-6 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition text-center flex items-center justify-center gap-2"
      >
        <i class="fas fa-blog"></i> Explore le blog
      </a>
    </div>

    <!-- Contact Support -->
    <div class="mt-12 pt-8 border-t border-slate-200 text-center">
      <p class="text-slate-600 mb-2">Des questions ?</p>
      <a href="{{ route('contact') }}" class="text-primary hover:text-primary-dark font-semibold transition">
        Contactez-nous <i class="fas fa-arrow-right ml-1"></i>
      </a>
    </div>
  </div>
</div>

<style>
  @media print {
    body {
      background: white;
    }
    .glass {
      border: 1px solid #e2e8f0;
      background: white;
    }
  }
</style>
@endsection
