@extends('layout.app')

@section('title', 'Sélection du mode de paiement')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="glass rounded-3xl p-8 space-y-6">
        <h1 class="text-3xl font-heading text-center">Règlement de votre commande</h1>
        <p class="text-center text-slate-600">Total à payer : <span class="text-2xl font-bold text-primary">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</span></p>

        <form id="payment-form" action="{{ route('orders.payment.initiate', ['order' => $order->publicRouteParameter()]) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <label class="relative flex flex-col items-center gap-4 p-6 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-primary transition-all">
                    <input type="radio" name="payment_method" value="ligdicash" class="peer hidden" required>
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center">
                        <span class="text-emerald-600 font-bold">LC</span>
                    </div>
                    <span class="font-bold">LigdiCash</span>
                    <p class="text-xs text-center text-slate-500">Mobile Money (Burkina, Mali, CI...)</p>
                    <div class="absolute top-4 right-4 w-6 h-6 border-2 border-slate-200 rounded-full peer-checked:border-primary peer-checked:bg-primary"></div>
                </label>

                <label class="relative flex flex-col items-center gap-4 p-6 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-primary transition-all">
                    <input type="radio" name="payment_method" value="orange_money" class="peer hidden">
                    <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center">
                        <span class="text-orange-600 font-bold">OM</span>
                    </div>
                    <span class="font-bold">Orange Money</span>
                    <div class="absolute top-4 right-4 w-6 h-6 border-2 border-slate-200 rounded-full peer-checked:border-primary peer-checked:bg-primary"></div>
                </label>

                <label class="relative flex flex-col items-center gap-4 p-6 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-primary transition-all">
                    <input type="radio" name="payment_method" value="visa" class="peer hidden">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-blue-600 font-bold">VISA</span>
                    </div>
                    <span class="font-bold">Carte Visa / MasterCard</span>
                    <div class="absolute top-4 right-4 w-6 h-6 border-2 border-slate-200 rounded-full peer-checked:border-primary peer-checked:bg-primary"></div>
                </label>
            </div>

            <button type="submit" id="submit-btn" class="w-full btn btn-primary py-4 rounded-full text-lg font-bold transition-all duration-200">
                <span id="btn-text">Continuer vers le paiement</span>
                <span id="btn-loader" class="hidden">
                    <svg class="animate-spin h-5 w-5 mx-auto text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </form>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('payment-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        const text = document.getElementById('btn-text');
        const loader = document.getElementById('btn-loader');
        
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        text.classList.add('hidden');
        loader.classList.remove('hidden');
    });
</script>
@endpush
@endsection
