@extends('layout.app')

@section('title', 'Paiement Orange Money')

@section('content')
<section class="max-w-xl mx-auto px-6 py-12">
    <div class="glass rounded-3xl p-8 space-y-6">
        <div class="flex items-center justify-center gap-4">
            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold italic">om</div>
            <h1 class="text-2xl font-heading">Paiement Orange Money</h1>
        </div>

        <div class="bg-orange-50 border border-orange-100 p-4 rounded-2xl text-orange-800 text-sm">
            {{ $result['message'] }}
        </div>

        <p class="text-center font-bold">Montant : {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>

        <form action="{{ route('orders.payment.process', ['order' => $order->publicRouteParameter()]) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="transaction_id" value="{{ $result['transaction_id'] }}">
            
            <div class="space-y-2">
                <label for="otp" class="text-sm font-medium">Code OTP</label>
                <input type="text" name="otp" id="otp" placeholder="Ex: 1234" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-center text-2xl tracking-widest" required>
            </div>

            <button type="submit" class="w-full btn btn-primary py-3 rounded-full font-bold">Confirmer le paiement</button>
        </form>

        <p class="text-center text-xs text-slate-400">Transaction ID: {{ $result['transaction_id'] }}</p>
    </div>
</section>
@endsection
