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
          @foreach($order->items as $item)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
              <div>
                <p class="font-medium">{{ $item->product->title ?? $item->post->title ?? 'Article' }}</p>
                <p class="text-sm text-slate-600">Quantité: {{ $item->quantity }}</p>
                @if($order->payment_status === 'paid' && $item->product?->is_downloadable)
                  <a href="{{ URL::signedRoute('orders.download', ['order' => $order, 'product' => $item->product]) }}" class="inline-flex items-center gap-2 mt-2 px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-600/20">
                    <i class="fas fa-download"></i> Télécharger le fichier
                  </a>
                @endif
                @if($order->payment_status === 'paid' && $item->post)
                  <a href="{{ route('blog.show', $item->post) }}" class="inline-flex items-center gap-2 mt-2 px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary-dark transition shadow-lg shadow-primary/20">
                    <i class="fas fa-eye"></i> Accéder au contenu
                  </a>
                @endif
              </div>
              <div class="text-right">
                <p class="font-bold text-slate-900">{{ number_format($item->quantity * $item->price, 0, ',', ' ') }} CFA</p>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ number_format($item->price, 0, ',', ' ') }} CFA / unité</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Total -->
      <div class="border-t border-slate-200 pt-6">
        <div class="flex justify-between items-center mb-2">
          <span class="text-slate-600">Sous-total</span>
          <span class="font-bold text-slate-900">{{ number_format($order->total_price, 0, ',', ' ') }} CFA</span>
        </div>
        <div class="flex justify-between items-center text-2xl font-black text-primary border-t pt-4">
          <span>TOTAL</span>
          <span>{{ number_format($order->total_price, 0, ',', ' ') }} CFA</span>
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
          <p class="font-medium">{{ $order->user_name }}</p>
        </div>
        <div>
          <p class="text-slate-600 text-sm mb-1">Email</p>
          <p class="font-medium break-all">{{ $order->user_email }}</p>
        </div>
        @if($order->user_phone)
          <div>
            <p class="text-slate-600 text-sm mb-1">Téléphone</p>
            <p class="font-medium">{{ $order->user_phone }}</p>
          </div>
        @endif
      </div>
      <div class="mt-6 pt-6 border-t space-y-3">
        <p class="text-sm text-slate-600">
          ✉️ Un email de confirmation a été envoyé à <strong>{{ $order->user_email }}</strong>
        </p>
        <div class="flex items-center gap-2 p-3 bg-yellow-50 text-yellow-800 rounded-xl text-xs border border-yellow-100">
          <i class="fas fa-exclamation-triangle text-yellow-500"></i>
          <span>Veuillez vérifier vos <strong>Spams (courriers indésirables)</strong> si vous ne recevez pas l'email.</span>
        </div>
      </div>
    </div>

    <!-- Payment Info Card -->
    <div class="glass rounded-3xl p-8 mb-8 bg-slate-50/50">
      <h3 class="font-semibold mb-6 text-lg flex items-center gap-2">
        <i class="fas fa-credit-card text-primary"></i> Paiement
      </h3>
      <div class="grid grid-cols-2 gap-4 text-sm">
          <div>
              <span class="text-slate-500">Méthode</span>
              <p class="font-bold">{{ strtoupper(str_replace('_', ' ', $order->payment_method ?? 'Non défini')) }}</p>
          </div>
          <div>
              <span class="text-slate-500">Statut</span>
              <p class="font-bold">
                  <span class="px-2 py-0.5 rounded-full
                      {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}
                  ">
                      {{ strtoupper($order->payment_status) }}
                  </span>
              </p>
          </div>
          @if($order->payment_reference)
          <div class="col-span-2 border-t pt-2">
              <span class="text-slate-500">Référence Transaction</span>
              <p class="font-mono text-xs">{{ $order->payment_reference }}</p>
          </div>
          @endif
      </div>
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
          <span><strong>Validation :</strong> Notre équipe vérifiera votre paiement Orange Money / Visa</span>
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
