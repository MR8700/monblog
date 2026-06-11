<x-mail::message>
# {{ $type === 'admin' ? 'Nouvelle Demande de Service' : 'Confirmation de Demande' }}

Bonjour {{ $type === 'admin' ? 'Administrateur' : $serviceRequest->client_name }},

{{ $type === 'admin' 
    ? "Une nouvelle demande de service a été soumise sur DigitalSpace." 
    : "Nous avons bien reçu votre demande de service et nous vous remercions de votre confiance." }}

## Récapitulatif de la demande :
- **Type de service :** {{ $serviceRequest->service_type }}
- **Client :** {{ $serviceRequest->client_name }}
- **Email :** {{ $serviceRequest->client_email }}
- **Téléphone :** {{ $serviceRequest->client_phone }}

**Description :**
{{ $serviceRequest->description }}

@if($serviceRequest->custom_fields && count($serviceRequest->custom_fields) > 0)
**Informations complémentaires :**
@foreach($serviceRequest->custom_fields as $field)
- **{{ $field['label'] }} :** {{ $field['value'] }}
@endforeach
@endif

@if($type === 'admin')
<x-mail::button :url="route('admin.services.show', $serviceRequest->id)">
Voir la demande sur le panel
</x-mail::button>
@else
Nous reviendrons vers vous très prochainement par email ou WhatsApp pour discuter des détails de votre projet.
@endif

Merci,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
