@extends('layout.app')

@section('title', 'Gestion du Chat - Admin')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 space-y-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white p-10 rounded-[3rem] border border-slate-100 shadow-soft">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-slate-900 tracking-tight">Conversations <span class="text-primary italic font-display">Privées</span></h1>
            <p class="text-slate-500">Gérez les discussions en direct avec vos clients.</p>
        </div>
        <div class="flex gap-4">
            <div class="px-6 py-4 bg-primary/5 rounded-2xl border border-primary/10 text-center">
                <p class="text-[10px] font-black uppercase tracking-widest text-primary">Actives</p>
                <p class="text-2xl font-black text-slate-900">{{ $conversations->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Client / Session</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Dernière activité</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($conversations as $chat)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900">Session {{ substr($chat->room, 5, 8) }}</h4>
                                        <p class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $chat->author_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm text-slate-600">{{ $chat->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.chat.show', $chat->room) }}" class="px-6 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-primary transition-all shadow-lg shadow-slate-900/10">
                                        Ouvrir la discussion
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center">
                                <div class="space-y-2">
                                    <i class="fas fa-comments text-4xl text-slate-200"></i>
                                    <p class="text-slate-400 font-medium">Aucune conversation active pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
