@extends('layout.app')

@section('title', 'Détails Demande de Service - Admin')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('admin.services.index') }}" class="text-slate-500 hover:text-primary transition-colors flex items-center gap-2 font-bold">
            <i class="fas fa-arrow-left"></i> Retour aux demandes
        </a>
        <div class="flex gap-4">
            <!-- Bouton Gmail -->
            @php
                $gmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($serviceRequest->client_email) . "&su=" . urlencode("Concernant votre demande de service: " . $serviceRequest->service_type) . "&body=" . urlencode("Bonjour " . $serviceRequest->client_name . ",\n\n");
            @endphp
            <a href="{{ $gmailUrl }}" target="_blank" onclick="logInteraction('email')" class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold flex items-center gap-2 hover:bg-red-100 transition">
                <i class="fab fa-google"></i> Contacter par Gmail
            </a>

            <!-- Bouton WhatsApp -->
            @php
                $whatsappUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $serviceRequest->client_phone) . "?text=" . urlencode("Bonjour " . $serviceRequest->client_name . ", je vous contacte concernant votre demande de " . $serviceRequest->service_type . " sur DigitalSpace.");
            @endphp
            <a href="{{ $whatsappUrl }}" target="_blank" onclick="logInteraction('whatsapp')" class="bg-green-50 text-green-600 px-4 py-2 rounded-xl font-bold flex items-center gap-2 hover:bg-green-100 transition">
                <i class="fab fa-whatsapp"></i> Contacter par WhatsApp
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne Gauche: Détails et Pièces Jointes -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass p-8 rounded-[2.5rem]">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900">{{ $serviceRequest->service_type }}</h1>
                        <p class="text-slate-500 font-medium">Demande #{{ $serviceRequest->id }} - {{ $serviceRequest->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-2xl text-sm font-black uppercase tracking-widest
                        {{ $serviceRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $serviceRequest->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $serviceRequest->status === 'quoted' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $serviceRequest->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $serviceRequest->status === 'delivered' ? 'bg-indigo-100 text-indigo-700' : '' }}
                        {{ $serviceRequest->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                    ">
                        {{ $serviceRequest->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Client</p>
                        <p class="text-lg font-bold text-slate-900">{{ $serviceRequest->client_name }}</p>
                        <p class="text-slate-600">{{ $serviceRequest->client_email }}</p>
                        <p class="text-slate-600">{{ $serviceRequest->client_phone }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Prix convenu</p>
                        <p class="text-3xl font-black text-primary">
                            {{ $serviceRequest->price ? number_format($serviceRequest->price, 2) . '€' : 'À définir' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Description</p>
                    <div class="bg-slate-50 p-6 rounded-3xl text-slate-700 leading-relaxed font-medium">
                        {!! nl2br(e($serviceRequest->description)) !!}
                    </div>
                </div>

                @if($serviceRequest->custom_fields)
                <div class="mt-8 space-y-4">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Champs Personnalisés</p>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($serviceRequest->custom_fields as $field)
                        <div class="bg-slate-50 px-6 py-4 rounded-2xl border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ $field['label'] }}</p>
                            <p class="font-bold text-slate-800">{{ $field['value'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Pièces jointes -->
            <div class="glass p-8 rounded-[2.5rem]">
                <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                    <i class="fas fa-paperclip text-primary"></i> Pièces Jointes
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @forelse($serviceRequest->attachments as $attachment)
                        <div class="group relative bg-slate-50 rounded-2xl p-4 border border-slate-100 hover:border-primary/30 transition-all">
                            <div class="aspect-square bg-white rounded-xl mb-3 flex items-center justify-center overflow-hidden">
                                <i class="fas {{ str_contains($attachment->mime_type, 'image') ? 'fa-image' : 'fa-file-alt' }} text-3xl text-slate-300"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-700 truncate mb-1">{{ $attachment->file_name }}</p>
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-[10px] font-black uppercase text-primary hover:underline">Télécharger</a>
                        </div>
                    @empty
                        <p class="text-slate-500 italic">Aucune pièce jointe.</p>
                    @endforelse
                </div>
            </div>

            <!-- Historique / Interactions -->
            <div class="glass p-8 rounded-[2.5rem]">
                <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                    <i class="fas fa-history text-primary"></i> Historique des échanges
                </h2>
                <div class="space-y-6">
                    @forelse($serviceRequest->interactions as $interaction)
                        <div class="flex gap-4">
                            <div class="flex-none w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                @if($interaction->type === 'email') <i class="fab fa-google"></i>
                                @elseif($interaction->type === 'whatsapp') <i class="fab fa-whatsapp"></i>
                                @elseif($interaction->type === 'status_change') <i class="fas fa-sync"></i>
                                @else <i class="fas fa-sticky-note"></i> @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-black text-slate-900">{{ $interaction->admin->name ?? 'Système' }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $interaction->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl text-sm text-slate-700 font-medium">
                                    {{ $interaction->content }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 italic">Aucun historique.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Colonne Droite: Actions -->
        <div class="space-y-8">
            <!-- Mise à jour Statut & Prix -->
            <div class="glass p-8 rounded-[2.5rem] sticky top-8">
                <h2 class="text-xl font-black text-slate-900 mb-6">Gestion</h2>
                <form action="{{ route('admin.services.update-status', $serviceRequest) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Statut</label>
                        <select name="status" class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                            <option value="pending" {{ $serviceRequest->status === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="processing" {{ $serviceRequest->status === 'processing' ? 'selected' : '' }}>En cours</option>
                            <option value="quoted" {{ $serviceRequest->status === 'quoted' ? 'selected' : '' }}>Devis envoyé</option>
                            <option value="paid" {{ $serviceRequest->status === 'paid' ? 'selected' : '' }}>Payé / Confirmé</option>
                            <option value="delivered" {{ $serviceRequest->status === 'delivered' ? 'selected' : '' }}>Livré</option>
                            <option value="cancelled" {{ $serviceRequest->status === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Prix définitif (€)</label>
                        <input type="number" name="price" step="0.01" value="{{ $serviceRequest->price }}" class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-900">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Notes internes</label>
                        <textarea name="admin_notes" rows="3" class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium" placeholder="Notes pour l'historique..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white rounded-2xl py-4 font-black hover:bg-primary transition-all">
                        Mettre à jour
                    </button>
                </form>

                <hr class="my-8 border-slate-100">

                <!-- Bouton pour ouvrir le modal de livraison -->
                @if(!$serviceRequest->delivery && ($serviceRequest->status === 'paid' || $serviceRequest->status === 'processing' || $serviceRequest->status === 'delivered'))
                <button @click="showDeliveryModal = true" class="w-full bg-primary text-white rounded-2xl py-4 font-black hover:bg-primary-dark transition-all flex items-center justify-center gap-2 shadow-xl shadow-primary/20">
                    <i class="fas fa-box-open"></i> Livrer le produit
                </button>
                @endif

                @if($serviceRequest->delivery)
                <div class="mt-8 p-6 bg-slate-900 rounded-[2rem] text-white space-y-4">
                    <h3 class="font-bold flex items-center gap-2">
                        <i class="fas fa-link text-primary"></i> Lien de livraison
                    </h3>
                    <div class="bg-white/10 p-4 rounded-xl break-all text-xs font-mono text-slate-300">
                        {{ route('deliveries.show', $serviceRequest->delivery->secure_token) }}
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="navigator.clipboard.writeText('{{ route('deliveries.show', $serviceRequest->delivery->secure_token) }}').then(() => alert('Lien copié !'))" class="py-2 bg-white/10 rounded-xl text-xs font-bold hover:bg-white/20 transition">
                            <i class="fas fa-copy mr-1"></i> Copier
                        </button>
                        
                        <form action="{{ route('admin.deliveries.regenerate-token', $serviceRequest->delivery) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-red-500/20 text-red-300 rounded-xl text-xs font-bold hover:bg-red-500/40 transition">
                                <i class="fas fa-sync mr-1"></i> Régénérer
                            </button>
                        </form>
                    </div>

                    <div class="space-y-2 pt-2">
                        <p class="text-[10px] font-black uppercase text-slate-500 tracking-widest">Partager le lien</p>
                        <div class="flex gap-2">
                            @php
                                $deliveryLink = route('deliveries.show', $serviceRequest->delivery->secure_token);
                                $shareText = "Bonjour " . $serviceRequest->client_name . ", votre commande est prête ! Vous pouvez la télécharger ici : " . $deliveryLink;
                                
                                $shareGmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($serviceRequest->client_email) . "&su=" . urlencode("Livraison de votre service : " . $serviceRequest->service_type) . "&body=" . urlencode($shareText);
                                $shareWhatsappUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $serviceRequest->client_phone) . "?text=" . urlencode($shareText);
                            @endphp
                            
                            <a href="{{ $shareGmailUrl }}" target="_blank" onclick="logInteraction('email', 'Envoi du lien de livraison par Gmail')" class="flex-1 bg-red-500/20 text-red-300 py-3 rounded-xl text-center text-xs font-bold hover:bg-red-500/30 transition">
                                <i class="fab fa-google mr-1"></i> Gmail
                            </a>
                            <a href="{{ $shareWhatsappUrl }}" target="_blank" onclick="logInteraction('whatsapp', 'Envoi du lien de livraison par WhatsApp')" class="flex-1 bg-green-500/20 text-green-300 py-3 rounded-xl text-center text-xs font-bold hover:bg-green-500/30 transition">
                                <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Modal de Livraison -->
<div x-show="showDeliveryModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDeliveryModal = false"></div>
        <div class="relative bg-white rounded-[3rem] max-w-2xl w-full p-10 shadow-2xl overflow-hidden">
            <h2 class="text-3xl font-black text-slate-900 mb-8">Livraison Sécurisée</h2>
            
            <form action="{{ route('admin.services.create-delivery', $serviceRequest) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Titre de la livraison</label>
                    <input type="text" name="title" required value="{{ $serviceRequest->service_type }} - {{ $serviceRequest->client_name }}" class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 font-bold">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Prix final (CFA)</label>
                    <input type="number" name="price" step="0.01" required value="{{ $serviceRequest->price }}" class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 font-black text-primary">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Fichier final (HD)</label>
                        <input type="file" name="file" required class="w-full text-xs">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Aperçu / Maquette</label>
                        <input type="file" name="preview" class="w-full text-xs">
                    </div>
                </div>

                <div class="flex items-center gap-4 py-4">
                    <input type="checkbox" name="is_public" id="is_public" class="w-6 h-6 rounded-lg text-primary focus:ring-primary border-slate-200">
                    <label for="is_public" class="text-sm font-bold text-slate-700">Rendre visible dans l'espace public (E-Vitrine)</label>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" @click="showDeliveryModal = false" class="flex-1 bg-slate-100 text-slate-600 rounded-2xl py-4 font-bold hover:bg-slate-200 transition">Annuler</button>
                    <button type="submit" class="flex-1 bg-slate-900 text-white rounded-2xl py-4 font-black hover:bg-primary transition shadow-xl shadow-slate-900/20">Valider la livraison</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function logInteraction(type, customContent = null) {
    const content = customContent || (type === 'email' ? 'Tentative de contact par Gmail' : 'Tentative de contact par WhatsApp');
    
    fetch('{{ route('admin.services.log-interaction', $serviceRequest) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            type: type,
            content: content
        })
    });
}
</script>
@endpush
@endsection
       content: content
        })
    });
}
</script>
@endpush
@endsection
