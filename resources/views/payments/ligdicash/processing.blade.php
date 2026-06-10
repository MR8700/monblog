@extends('layout.public')

@section('title', 'Paiement en cours - ' . config('app.name'))

@section('content')
<div class="container mx-auto px-4 py-20">
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-8 text-center">
            <div id="status-icon" class="mb-6 flex justify-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-indigo-600"></div>
            </div>
            
            <h2 id="status-title" class="text-2xl font-bold text-gray-800 mb-2">Paiement en cours...</h2>
            <p id="status-message" class="text-gray-600 mb-8">
                Nous vérifions la confirmation de votre paiement auprès de LigdiCash. 
                Veuillez ne pas fermer cette fenêtre.
            </p>

            <div id="order-details" class="bg-gray-50 rounded-xl p-4 mb-8 text-left">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-500">Commande :</span>
                    <span class="font-semibold">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Montant :</span>
                    <span class="font-semibold text-indigo-600">{{ number_format($order->total_price, 0, ',', ' ') }} XOF</span>
                </div>
            </div>

            <div id="action-buttons" class="hidden">
                <a href="{{ route('orders.confirmation', $order) }}" 
                   class="inline-block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200">
                    Voir ma commande
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const orderId = "{{ $order->id }}";
    const statusUrl = "{{ route('payments.ligdicash.status', $order) }}";
    let attempts = 0;
    const maxAttempts = 30; // 30 tentatives (env 1 minute)

    function checkStatus() {
        fetch(statusUrl)
            .then(response => response.json())
            .then(data => {
                attempts++;
                
                if (data.status === 'paid') {
                    showSuccess();
                } else if (data.status === 'failed') {
                    showError('Le paiement a échoué. Veuillez réessayer.');
                } else if (attempts >= maxAttempts) {
                    showError('Le délai de vérification est dépassé. Si vous avez été débité, veuillez nous contacter.');
                } else {
                    setTimeout(checkStatus, 2000); // Réessayer toutes les 2 secondes
                }
            })
            .catch(error => {
                console.error('Error checking status:', error);
                setTimeout(checkStatus, 5000);
            });
    }

    function showSuccess() {
        document.getElementById('status-icon').innerHTML = `
            <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        `;
        document.getElementById('status-title').innerText = 'Paiement Confirmé !';
        document.getElementById('status-title').classList.add('text-green-600');
        document.getElementById('status-message').innerText = 'Votre commande a été validée avec succès. Vous allez être redirigé...';
        document.getElementById('action-buttons').classList.remove('hidden');
        
        setTimeout(() => {
            window.location.href = "{{ route('orders.confirmation', $order) }}";
        }, 3000);
    }

    function showError(message) {
        document.getElementById('status-icon').innerHTML = `
            <div class="h-16 w-16 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        `;
        document.getElementById('status-title').innerText = 'Erreur';
        document.getElementById('status-title').classList.add('text-red-600');
        document.getElementById('status-message').innerText = message;
        document.getElementById('action-buttons').innerHTML = `
            <a href="{{ route('orders.payment.select', $order) }}" 
               class="inline-block w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-6 rounded-xl transition duration-200">
                Réessayer le paiement
            </a>
        `;
        document.getElementById('action-buttons').classList.remove('hidden');
    }

    // Lancer le polling
    setTimeout(checkStatus, 2000);
</script>
@endpush
@endsection
