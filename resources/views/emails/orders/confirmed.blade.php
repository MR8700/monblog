<x-mail::message>
# Merci pour votre commande !

Bonjour {{ $order->user_name }},

Nous avons le plaisir de vous confirmer la réception de votre paiement pour la commande **#{{ $order->id }}**.

<x-mail::panel>
### Récapitulatif du paiement
**Montant total :** {{ number_format($order->total_price, 2) }}€  
**Méthode :** {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}  
**Statut :** Confirmé et Payé
</x-mail::panel>

## Vos articles et livrables :

@foreach($order->items as $item)
@php 
    $title = $item->product->title ?? $item->post->title;
    $isDownloadable = ($item->product && $item->product->is_downloadable && $item->product->file_path);
    // On considère que si c'est un post payé, l'accès est le lien vers l'article lui-même (ou un livrable joint)
    $accessUrl = null;
    if ($item->product_id && $isDownloadable) {
        $accessUrl = URL::signedRoute('orders.download', ['order' => $order, 'product' => $item->product]);
    } elseif ($item->post_id) {
        $accessUrl = route('blog.show', $item->post->slug);
    }
@endphp
* **{{ $title }}** (x{{ $item->quantity }})
@if($accessUrl)
  [Accéder au contenu / Télécharger]({{ $accessUrl }})
@endif
@endforeach

<x-mail::button :url="route('home')">
Retour sur DigitalSpace
</x-mail::button>

***

**💡 Note importante :** Si vous ne recevez pas nos futurs emails, veuillez vérifier votre dossier **Courriers indésirables (Spams)** et marquer notre adresse comme "légitime".

Si vous avez des questions concernant votre commande, notre support est à votre disposition.

Cordialement,  
L'équipe **DigitalSpace**
</x-mail::message>
