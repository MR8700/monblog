@extends('layout.app')

@section('title', 'Centre de Messagerie - Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[3rem] border border-slate-100 shadow-soft">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Centre de <span class="text-secondary italic font-display">Messagerie</span></h1>
            <p class="text-slate-500">Gérez les demandes de vos clients et l'historique des discussions.</p>
        </div>
        <div class="flex gap-4 text-center">
            <div class="px-6 py-4 bg-primary/5 rounded-2xl border border-primary/10">
                <p class="text-[10px] font-black uppercase tracking-widest text-primary">Nouveaux</p>
                <p class="text-2xl font-black text-slate-900">{{ \App\Models\ContactMessage::where('status', 'new')->count() }}</p>
            </div>
            <div class="px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total</p>
                <p class="text-2xl font-black text-slate-900">{{ \App\Models\ContactMessage::count() }}</p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Expéditeur</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Sujet & Aperçu</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Statut</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Date</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($messages as $msg)
                        <tr class="hover:bg-slate-50/50 transition-colors group {{ $msg->status === 'new' ? 'bg-primary/5' : '' }}">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $msg->name }}</h4>
                                        <p class="text-[10px] text-slate-400">{{ $msg->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="max-w-xs">
                                    <h5 class="font-bold text-slate-700 truncate">{{ $msg->subject ?? 'Sans objet' }}</h5>
                                    <p class="text-xs text-slate-400 truncate">{{ $msg->message }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    @if($msg->status === 'new') bg-primary text-white
                                    @elseif($msg->status === 'read') bg-amber-100 text-amber-600
                                    @elseif($msg->status === 'replied') bg-green-100 text-green-600
                                    @else bg-slate-100 text-slate-400 @endif">
                                    {{ $msg->status === 'new' ? 'Nouveau' : ($msg->status === 'read' ? 'Lu' : ($msg->status === 'replied' ? 'Répondu' : 'Archivé')) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-xs text-slate-400">
                                {{ $msg->created_at->diffForHumans() }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
                                        <i class="fas fa-reply text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Supprimer ce message ?')" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center hover:bg-danger hover:text-white hover:border-danger transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-6 bg-slate-50/50">
            {{ $messages->links() }}
        </div>
    </div>
</section>
@endsection
