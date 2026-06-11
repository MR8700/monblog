@extends('layout.app')

@section('title', 'Détail du Message - Admin')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.messages.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Détail du <span class="text-primary italic font-display">Message</span></h1>
        </div>
        <div class="flex gap-2">
             <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest 
                @if($message->status === 'new') bg-primary text-white
                @elseif($message->status === 'read') bg-amber-100 text-amber-600
                @elseif($message->status === 'replied') bg-green-100 text-green-600
                @else bg-slate-100 text-slate-400 @endif">
                {{ $message->status === 'new' ? 'Nouveau' : ($message->status === 'read' ? 'Lu' : ($message->status === 'replied' ? 'Répondu' : 'Archivé')) }}
            </span>
        </div>
    </div>

    <!-- Message Card -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden">
        <!-- Message Content -->
        <div class="p-10 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-8 border-b border-slate-50">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary/5 text-primary flex items-center justify-center text-2xl font-black">
                        {{ strtoupper(substr($message->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $message->name }}</h3>
                        <p class="text-sm text-slate-400 font-medium">{{ $message->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $message->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-[10px] text-slate-300 font-bold uppercase tracking-widest">IP: {{ $message->ip_address }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h4 class="text-xs font-black uppercase tracking-[0.2em] text-primary">Objet: {{ $message->subject ?? 'Sans objet' }}</h4>
                <div class="bg-slate-50 p-8 rounded-[2.5rem] text-slate-600 leading-relaxed whitespace-pre-wrap">
                    {{ $message->message }}
                </div>
            </div>
        </div>

        <!-- Reply Area -->
        <div class="bg-slate-900 p-10 md:p-14 space-y-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 blur-[100px] rounded-full"></div>
            
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-reply-all"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Envoyer une réponse</h3>
            </div>

            @if($message->status === 'replied')
                <div class="relative z-10 space-y-4">
                    <div class="p-6 bg-white/5 border border-white/10 rounded-2xl">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Votre dernière réponse ({{ $message->replied_at->format('d/m/Y') }}) :</p>
                        <p class="text-slate-300 italic whitespace-pre-wrap leading-relaxed">{{ $message->admin_reply }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.messages.reply', $message) }}" method="POST" class="relative z-10 space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-4">Message de réponse au client</label>
                    <textarea name="admin_reply" required rows="6" placeholder="Écrivez votre réponse ici. Elle sera envoyée par email au client."
                              class="w-full bg-white/5 border-2 border-white/10 rounded-[2rem] px-8 py-6 focus:outline-none focus:bg-white/10 focus:border-primary/50 transition-all text-white placeholder:text-slate-600 font-medium"></textarea>
                </div>
                <div class="pt-4 flex justify-between items-center">
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest italic max-w-xs">
                        <i class="fas fa-circle-info mr-2"></i> L'envoi du message déclenche automatiquement une notification Gmail vers le client.
                    </p>
                    <button type="submit" class="px-10 py-5 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-transform flex items-center gap-3">
                        <i class="fas fa-paper-plane text-xs"></i> Envoyer la Réponse
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
