@extends('layout.app')

@section('title', 'Chat en direct')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Chat Privé</p>
        <h1 class="text-3xl font-display text-primary">Discussion directe</h1>
      </div>
      <span class="text-xs text-slate-500">ID: {{ substr($room, 5, 8) }}</span>
    </div>

    <div id="chat-box" class="glass rounded-3xl p-6 h-[32rem] overflow-y-auto space-y-4">
      @foreach($messages as $message)
        <div class="flex {{ $message->author_type === 'admin' ? 'justify-start' : 'justify-end' }}">
          <div class="max-w-[80%] space-y-1">
            <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 {{ $message->author_type === 'admin' ? '' : 'flex-row-reverse' }}">
              <span>{{ $message->author_type === 'admin' ? 'Support Admin' : 'Vous' }}</span>
              <span>{{ $message->created_at->format('H:i') }}</span>
            </div>
            
            <div class="p-4 rounded-2xl shadow-sm {{ $message->author_type === 'admin' ? 'bg-white text-slate-700 border border-slate-100' : 'bg-primary text-white' }}">
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

    <form method="POST" action="{{ route('chat.store') }}" enctype="multipart/form-data" class="glass rounded-3xl p-6 space-y-4">
      @csrf
      <input type="hidden" name="room" value="{{ $room }}">
      <div class="flex gap-4 items-end">
        <div class="flex-1 space-y-4">
          <textarea name="body" rows="2" placeholder="Tapez votre message ici..." class="w-full rounded-2xl border-transparent bg-slate-50 px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all text-sm" required></textarea>
          <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-xs text-slate-400 cursor-pointer hover:text-primary transition-colors">
              <i class="fas fa-paperclip"></i>
              <span>Joindre un fichier</span>
              <input type="file" name="attachments[]" multiple class="hidden">
            </label>
            <span class="text-[10px] text-slate-300">Votre discussion est privée et sécurisée</span>
          </div>
        </div>
        <button type="submit" class="w-14 h-14 bg-primary text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </form>
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
        wrapper.className = `flex ${isAdmin ? 'justify-start' : 'justify-end'}`;

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
          <div class="max-w-[80%] space-y-1">
            <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 ${isAdmin ? '' : 'flex-row-reverse'}">
              <span>${isAdmin ? 'Support Admin' : 'Vous'}</span>
              <span>now</span>
            </div>
            <div class="p-4 rounded-2xl shadow-sm ${isAdmin ? 'bg-white text-slate-700 border border-slate-100' : 'bg-primary text-white'}">
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
