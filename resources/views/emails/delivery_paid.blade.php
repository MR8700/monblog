<x-mail::message>
# Félicitations ! Votre produit est disponible.

Bonjour {{ $delivery->serviceRequest->client_name }},

Nous avons le plaisir de vous informer que votre commande pour le service **{{ $delivery->serviceRequest->service_type }}** a été finalisée et le paiement a été validé.

Vous trouverez ci-joint votre produit fini. Vous pouvez également y accéder à tout moment via votre espace sécurisé :

<x-mail::button :url="route('deliveries.show', $delivery->secure_token)">
Accéder à mon espace sécurisé
</x-mail::button>

**Détails de la livraison :**
- **Produit :** {{ $delivery->title }}
- **Montant :** {{ number_format($delivery->price, 0, ',', ' ') }} CFA

Merci de votre confiance.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
