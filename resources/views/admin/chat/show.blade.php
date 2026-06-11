@extends('layout.app')

@section('title', 'Discussion Client - Admin')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.chat.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Session {{ substr($room, 5, 8) }}</h1>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Discussion en direct avec le client</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">En ligne</span>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-soft overflow-hidden flex flex-col h-[70vh]">
        <!-- Chat Body -->
        <div id="chat-box" class="flex-1 overflow-y-auto p-8 space-y-6 bg-slate-50/30">
            @foreach($messages as $message)
                <div class="flex {{ $message->author_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%] space-y-1">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 {{ $message->author_type === 'admin' ? 'flex-row-reverse' : '' }}">
                            <span>{{ $message->author_type === 'admin' ? 'Vous' : $message->author_name }}</span>
                            <span>{{ $message->created_at->format('H:i') }}</span>
                        </div>
                        
                        <div class="p-4 rounded-2xl shadow-sm {{ $message->author_type === 'admin' ? 'bg-primary text-white' : 'bg-white text-slate-700 border border-slate-100' }}">
                            @if($message->body)
                                <p class="text-sm leading-relaxed">{{ $message->body }}</p>
                            @endif

                            @if($message->attachments->isNotEmpty())
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($message->attachments as $file)
                                        @if(str_starts_with($file->mime, 'image/'))
                                            <a href="{{ $file->path }}" target="_blank" class="block rounded-lg overflow-hidden border border-black/5">
                                                <img src="{{ $file->path }}" alt="{{ $file->original_name }}" class="w-32 h-24 object-cover">
                                            </a>
                                        @else
                                            <a href="{{ $file->path }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-black/5 text-[10px] font-bold uppercase">
                                                <i class="fas fa-file"></i> Fichier
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Chat Footer -->
        <div class="p-6 bg-white border-t border-slate-100">
            <form method="POST" action="{{ route('chat.store') }}" enctype="multipart/form-data" class="flex gap-4 items-end">
                @csrf
                <input type="hidden" name="room" value="{{ $room }}">
                <div class="flex-1 relative">
                    <textarea name="body" rows="1" placeholder="Répondre au client..." class="w-full rounded-2xl border-transparent bg-slate-50 pl-6 pr-16 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all text-sm resize-none" required></textarea>
                    <label class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-primary cursor-pointer transition-colors">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" name="attachments[]" multiple class="hidden">
                    </label>
                </div>
                <button type="submit" class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center shadow-lg hover:bg-primary hover:scale-105 active:scale-95 transition-all">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const box = document.getElementById('chat-box');
        box.scrollTop = box.scrollHeight;

        if (!window.Echo) return;
        window.Echo.channel('chat.{{ $room }}')
            .listen('.chat.message', (event) => {
                const message = event.message;
                const isAdmin = message.author_type === 'admin';
                
                const wrapper = document.createElement('div');
                wrapper.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'}`;

                let attachmentsHtml = '';
                if (message.attachments && message.attachments.length) {
                    attachmentsHtml = '<div class="mt-3 flex flex-wrap gap-2">';
                    message.attachments.forEach(file => {
                        const isImage = file.mime && file.mime.startsWith('image/');
                        if (isImage) {
                            attachmentsHtml += `
                                <a href="${file.path}" target="_blank" class="block rounded-lg overflow-hidden border border-black/5">
                                    <img src="${file.path}" alt="${file.original_name}" class="w-32 h-24 object-cover">
                                </a>`;
                        } else {
                            attachmentsHtml += `
                                <a href="${file.path}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-black/5 text-[10px] font-bold uppercase">
                                    <i class="fas fa-file"></i> Fichier
                                </a>`;
                        }
                    });
                    attachmentsHtml += '</div>';
                }

                wrapper.innerHTML = `
                    <div class="max-w-[70%] space-y-1">
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 ${isAdmin ? 'flex-row-reverse' : ''}">
                            <span>${isAdmin ? 'Vous' : message.author_name}</span>
                            <span>now</span>
                        </div>
                        <div class="p-4 rounded-2xl shadow-sm ${isAdmin ? 'bg-primary text-white' : 'bg-white text-slate-700 border border-slate-100'}">
                            ${message.body ? `<p class="text-sm leading-relaxed">${message.body}</p>` : ''}
                            ${attachmentsHtml}
                        </div>
                    </div>
                `;

                box.appendChild(wrapper);
                box.scrollTop = box.scrollHeight;
            });
    });
</script>
@endsection
