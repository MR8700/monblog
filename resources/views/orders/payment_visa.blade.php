@extends('layout.app')

@section('title', 'Paiement Carte Visa')

@section('content')
<section class="max-w-xl mx-auto px-6 py-12">
    <div class="glass rounded-3xl p-8 space-y-6">
        <div class="flex items-center justify-center gap-4">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold italic text-xs">VISA</div>
            <h1 class="text-2xl font-heading">Paiement Carte Visa</h1>
        </div>

        <p class="text-center font-bold">Montant : {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>

        <form action="{{ route('orders.payment.process', $order) }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-2">
                <label for="card_number" class="text-sm font-medium">Numéro de carte</label>
                <input type="text" name="card_number" id="card_number" placeholder="4242 4242 4242 4242" class="w-full rounded-xl border border-slate-200 px-4 py-3" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="expiry" class="text-sm font-medium">Expiration (MM/AA)</label>
                    <input type="text" name="expiry" id="expiry" placeholder="12/26" class="w-full rounded-xl border border-slate-200 px-4 py-3" required>
                </div>
                <div class="space-y-2">
                    <label for="cvv" class="text-sm font-medium">CVC / CVV</label>
                    <input type="text" name="cvv" id="cvv" placeholder="123" class="w-full rounded-xl border border-slate-200 px-4 py-3" required>
                </div>
            </div>

            <button type="submit" class="w-full btn btn-primary py-3 rounded-full font-bold">Payer maintenant</button>
        </form>

        <p class="text-center text-xs text-slate-400">Paiement sécurisé par Visa / MasterCard</p>
    </div>
</section>
@endsection
