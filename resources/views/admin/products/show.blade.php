@extends('layout.app')

@section('title', $product->title)

@section('content')
<section class="max-w-6xl mx-auto px-6 py-20">
  <div class="mb-10">
    <a href="{{ route('products.publicIndex') }}" class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-slate-400 hover:text-primary transition-colors">
      <i class="fas fa-arrow-left text-xs"></i> Retour à la boutique
    </a>
  </div>

  <div class="grid lg:grid-cols-2 gap-16 items-start">
    <!-- Image & Socials -->
    <div class="space-y-8">
      <div class="bg-white rounded-[3.5rem] p-4 shadow-xl shadow-slate-200/50 border border-slate-100">
        <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1551288049-bbbda540d3b9?auto=format&fit=crop&q=80&w=1200' }}" 
             alt="{{ $product->title }}" 
             class="w-full h-[500px] object-cover rounded-[2.5rem] shadow-inner">
      </div>

      <div class="flex flex-wrap gap-4">
        @if($product->whatsapp)
          <a href="https://wa.me/{{ $product->whatsapp }}" target="_blank" class="px-6 py-3 bg-green-500 text-white rounded-full text-xs font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-lg shadow-green-500/20">
            <i class="fab fa-whatsapp"></i> WhatsApp
          </a>
        @endif
        @if($product->facebook)
          <a href="{{ $product->facebook }}" target="_blank" class="px-6 py-3 bg-blue-600 text-white rounded-full text-xs font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-lg shadow-blue-600/20">
            <i class="fab fa-facebook-f"></i> Facebook
          </a>
        @endif
        @if($product->phone)
          <a href="tel:{{ $product->phone }}" class="px-6 py-3 bg-white text-slate-900 rounded-full text-xs font-bold flex items-center gap-2 border border-slate-100 shadow-sm hover:bg-slate-50 transition-colors">
            <i class="fas fa-phone"></i> {{ $product->phone }}
          </a>
        @endif
        @if($product->email)
          <a href="mailto:{{ $product->email }}" class="px-6 py-3 bg-white text-slate-900 rounded-full text-xs font-bold flex items-center gap-2 border border-slate-100 shadow-sm hover:bg-slate-50 transition-colors">
            <i class="fas fa-envelope"></i> Nous contacter
          </a>
        @endif
      </div>
    </div>

    <!-- Details & Form -->
    <div class="space-y-10">
      <div class="space-y-4">
        <span class="text-secondary font-bold uppercase tracking-[0.3em] text-[10px] bg-secondary/5 px-4 py-1.5 rounded-full">
          @switch($product->type)
              @case('app') Application @break
              @case('task') Tâche @break
              @case('service') Service @break
              @default Produit Digital
          @endswitch
        </span>
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight">{{ $product->title }}</h1>
        <div class="text-4xl font-black text-primary">
          {{ $product->price ? number_format($product->price, 0, ',', ' ') : '0' }} <span class="text-lg font-bold opacity-50">CFA</span>
        </div>
      </div>

      <div class="prose prose-slate prose-lg text-slate-500 max-w-none leading-relaxed">
        {!! nl2br(e($product->description)) !!}
      </div>

      <!-- Checkout Form -->
      <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-2xl shadow-slate-200/40 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-40 h-40 bg-primary/5 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
        
        <div class="relative z-10 space-y-8">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center text-xl">
              <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-slate-900">Commander maintenant</h3>
              <p class="text-xs text-slate-400 font-medium">Accès immédiat après confirmation du paiement</p>
            </div>
          </div>

          <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
              @csrf
              <input type="hidden" name="products[0][id]" value="{{ $product->id }}">
              <input type="hidden" name="products[0][quantity]" value="1">
              
              <div class="space-y-3">
                <input type="text" name="user_name" placeholder="Nom complet" 
                       class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required>
                
                <div class="grid md:grid-cols-2 gap-3">
                  <input type="email" name="user_email" placeholder="Adresse email" 
                         class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required>
                  <input type="text" name="user_phone" placeholder="Numéro WhatsApp/Tél" 
                         class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" required>
                </div>
              </div>
              
              <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:bg-primary-dark hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">
                <i class="fas fa-rocket"></i> Payer maintenant
              </button>
          </form>

          <div class="flex items-center justify-center gap-6 pt-4 grayscale opacity-40">
            <i class="fab fa-cc-visa text-2xl"></i>
            <i class="fab fa-cc-mastercard text-2xl"></i>
            <div class="w-px h-6 bg-slate-200"></div>
            <span class="text-[10px] font-bold uppercase tracking-widest">Paiement 100% Sécurisé</span>
          </div>
        </div>
      </div>

      @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
        <div class="flex gap-4 pt-10 border-t border-slate-100">
          <a href="{{ route('admin.products.edit', $product) }}" class="px-6 py-3 bg-slate-900 text-white rounded-full text-xs font-bold hover:bg-slate-800 transition-colors">
            <i class="fas fa-edit mr-2"></i> Modifier le produit
          </a>
          <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer ce produit ?')" class="px-6 py-3 bg-red-50 text-red-600 rounded-full text-xs font-bold hover:bg-red-100 transition-colors">
              <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
          </form>
        </div>
      @endif
    </div>
  </div>
</section>
@endsection

