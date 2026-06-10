@extends('layout.app')

@section('title', 'Sélection du mode de paiement')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="glass rounded-3xl p-8 space-y-6">
        <h1 class="text-3xl font-heading text-center">Règlement de votre commande</h1>
        <p class="text-center text-slate-600">Total à payer : <span class="text-2xl font-bold text-primary">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</span></p>

        <form action="{{ route('orders.payment.initiate', $order) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <label class="relative flex flex-col items-center gap-4 p-6 border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-primary transition-all">
                    <input type="radio" name="payment_method" value="orange_money" class="peer hidden" required>
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

            <button type="submit" class="w-full btn btn-primary py-4 rounded-full text-lg font-bold">Continuer vers le paiement</button>
        </form>
    </div>
</section>
@endsection
