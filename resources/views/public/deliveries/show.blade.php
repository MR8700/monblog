@extends('layout.app')

@section('title', 'Espace de Livraison Sécurisé - ' . $delivery->title)

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-12">
        <!-- Header -->
        <div class="text-center space-y-4">
            <span class="px-4 py-2 bg-primary/10 text-primary rounded-full text-xs font-black uppercase tracking-widest">Espace Client Sécurisé</span>
            <h1 class="text-5xl font-black text-slate-900 tracking-tight">{{ $delivery->title }}</h1>
            <p class="text-slate-500 max-w-2xl mx-auto font-medium">{{ $delivery->description }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Preview Space -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[3rem] overflow-hidden border border-slate-100 shadow-2xl relative group">
                    @if($delivery->preview_path)
                        <img src="{{ asset('storage/' . $delivery->preview_path) }}" alt="Preview" class="w-full h-auto">
                    @else
                        <div class="aspect-video bg-slate-900 flex items-center justify-center text-white">
                            <div class="text-center space-y-4">
                                <i class="fas fa-file-invoice-dollar text-6xl text-primary/40"></i>
                                <p class="font-bold opacity-50 italic">Paiement requis pour prévisualiser ou télécharger</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($delivery->status !== 'paid')
                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
                            <div class="bg-white p-10 rounded-[3rem] text-center shadow-2xl space-y-6 max-w-sm mx-6">
                                <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center text-2xl mx-auto">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h2 class="text-2xl font-black text-slate-900">Produit Verrouillé</h2>
                                <p class="text-slate-500 font-medium">Veuillez régler la somme de <span class="text-slate-900 font-bold">{{ number_format($delivery->price, 2) }}€</span> pour débloquer votre produit.</p>
                                
                                <form action="{{ route('deliveries.pay', $delivery->secure_token) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full bg-primary text-white py-4 rounded-2xl font-black hover:shadow-lg transition-all">
                                        Payer {{ number_format($delivery->price, 2) }}€ & Débloquer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="p-8 bg-green-50 border-t border-green-100 flex items-center justify-between">
                            <div class="flex items-center gap-3 text-green-700">
                                <i class="fas fa-check-circle"></i>
                                <span class="font-bold">Paiement Validé - Produit disponible</span>
                            </div>
                            <a href="{{ route('deliveries.download', $delivery->secure_token) }}" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-primary transition-all flex items-center gap-2">
                                <i class="fas fa-download"></i> Télécharger Haute Qualité
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Discussion/Commentaires -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/40 space-y-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                            <i class="fas fa-comments text-primary"></i> 
                            Retours & Corrections
                        </h3>
                        
                        <!-- Réactions -->
                        <div class="flex gap-2">
                            <form action="{{ route('deliveries.react', $delivery->secure_token) }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="like">
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-red-50 hover:text-red-500 rounded-xl transition-all font-bold text-slate-500 text-xs">
                                    <i class="fas fa-heart"></i> {{ $delivery->reactions['like'] ?? 0 }}
                                </button>
                            </form>
                            <form action="{{ route('deliveries.react', $delivery->secure_token) }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="fire">
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-orange-50 hover:text-orange-500 rounded-xl transition-all font-bold text-slate-500 text-xs">
                                    <i class="fas fa-fire"></i> {{ $delivery->reactions['fire'] ?? 0 }}
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($delivery->comments as $comment)
                            <div class="flex gap-4 {{ $comment->is_admin ? 'flex-row-reverse' : '' }}">
                                <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center font-bold {{ $comment->is_admin ? 'bg-slate-900 text-white' : 'bg-primary/10 text-primary' }}">
                                    {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                </div>
                                <div class="max-w-md {{ $comment->is_admin ? 'bg-slate-900 text-white rounded-l-[1.5rem] rounded-tr-[1.5rem]' : 'bg-slate-50 text-slate-700 rounded-r-[1.5rem] rounded-tl-[1.5rem]' }} p-6 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-black uppercase tracking-widest opacity-50">{{ $comment->author_name }}</span>
                                        <span class="text-[10px] opacity-40">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="font-medium leading-relaxed">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('deliveries.comment', $delivery->secure_token) }}" method="POST" class="pt-8 border-t border-slate-50 space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Votre message / correction</label>
                            <textarea name="content" rows="3" required class="w-full bg-slate-50 border-transparent rounded-3xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all" placeholder="Quelque chose à modifier ? Dites-le nous ici..."></textarea>
                        </div>
                        <button type="submit" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-primary transition-all">
                            Envoyer mon retour
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 blur-[60px] rounded-full"></div>
                    <h3 class="text-lg font-bold mb-6 relative z-10 flex items-center gap-3">
                        <i class="fas fa-info-circle text-primary text-sm"></i> Informations
                    </h3>
                    <div class="space-y-6 relative z-10">
                        <div class="space-y-1">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Date de livraison</span>
                            <p class="font-bold text-slate-200">{{ $delivery->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Montant à régler</span>
                            <p class="text-3xl font-black text-primary">{{ number_format($delivery->price, 2) }}€</p>
                        </div>
                        <div class="pt-6 border-t border-white/10">
                            <p class="text-[10px] text-slate-400 leading-relaxed italic">
                                * Une fois le paiement validé, vous recevrez automatiquement la facture et le produit final haute résolution sur votre adresse email.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Help/Spam notice -->
                <div class="bg-yellow-50 border border-yellow-100 rounded-[2rem] p-6 space-y-4">
                    <div class="flex items-center gap-3 text-yellow-800">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                        <span class="font-bold text-sm uppercase tracking-tight">Vérifiez vos emails</span>
                    </div>
                    <p class="text-xs text-yellow-700 leading-relaxed font-medium">
                        Si vous ne recevez pas nos notifications de livraison ou de paiement, pensez à vérifier votre dossier **Spams / Courriers indésirables** dans Gmail.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
