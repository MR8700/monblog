@extends('layout.app')

@section('title', 'Chat en direct')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 grid gap-10 lg:grid-cols-3">
  <div class="lg:col-span-2 space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="uppercase tracking-[0.3em] text-xs font-semibold text-secondary">Chat</p>
        <h1 class="text-3xl font-display text-primary">Discussion en temps reel</h1>
      </div>
      <span class="text-xs text-slate-500">Salon public</span>
    </div>

    <div id="chat-box" class="glass rounded-3xl p-6 h-[28rem] overflow-y-auto space-y-4">
      @foreach($messages as $message)
        <div class="space-y-2">
          <div class="flex items-center gap-2 text-sm font-semibold">
            <span>{{ $message->author_name }}</span>
            @if($message->author_type === 'admin')
              <span class="px-2 py-1 text-xs rounded-full bg-secondary/20 text-secondary">Admin</span>
            @endif
            <span class="text-xs text-slate-400">{{ $message->created_at->format('H:i') }}</span>
          </div>
          @if($message->body)
            <p class="text-sm text-slate-700">{{ $message->body }}</p>
          @endif
          @if($message->attachments->isNotEmpty())
            <div class="flex flex-wrap gap-3">
              @foreach($message->attachments as $file)
                @if(str_starts_with($file->mime, 'image/'))
                  <a href="{{ $file->path }}" target="_blank" class="block">
                    <img src="{{ $file->path }}" alt="{{ $file->original_name }}" class="w-28 h-20 object-cover rounded-xl border border-slate-200">
                  </a>
                @else
                  <a href="{{ $file->path }}" target="_blank" class="px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs">
                    {{ $file->original_name }}
                  </a>
                @endif
              @endforeach
            </div>
          @endif
        </div>
      @endforeach
    </div>

    <form method="POST" action="{{ route('chat.store') }}" enctype="multipart/form-data" class="glass rounded-3xl p-6 space-y-4">
      @csrf
      @if(!Auth::guard('admin')->check())
        <input type="text" name="name" placeholder="Votre nom" class="w-full rounded-xl border border-slate-200 px-4 py-2">
      @endif
      <textarea name="body" rows="3" placeholder="Votre message" class="w-full rounded-xl border border-slate-200 px-4 py-2"></textarea>
      <input type="file" name="attachments[]" multiple class="w-full text-sm">
      <button type="submit" class="btn btn-primary rounded-full">Envoyer</button>
    </form>
  </div>

  <div class="lg:col-span-1 space-y-6">
    <div class="glass rounded-3xl p-6 space-y-3">
      <h2 class="text-xl font-heading">Appel video</h2>
      <p class="text-sm text-slate-600">Rejoignez le salon video public pour discuter en direct.</p>
      <div class="aspect-video rounded-2xl overflow-hidden border border-slate-200">
        <iframe
          src="https://meet.jit.si/MonEspaceProChat"
          allow="camera; microphone; fullscreen; display-capture"
          class="w-full h-full"
        ></iframe>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (!window.Echo) return;
    window.Echo.channel('chat.global')
      .listen('.chat.message', (event) => {
        const message = event.message;
        const box = document.getElementById('chat-box');
        const wrapper = document.createElement('div');
        wrapper.className = 'space-y-2';

        const header = document.createElement('div');
        header.className = 'flex items-center gap-2 text-sm font-semibold';
        header.innerHTML = `
          <span>${message.author_name}</span>
          ${message.author_type === 'admin' ? '<span class="px-2 py-1 text-xs rounded-full bg-secondary/20 text-secondary">Admin</span>' : ''}
          <span class="text-xs text-slate-400">now</span>
        `;

        wrapper.appendChild(header);

        if (message.body) {
          const body = document.createElement('p');
          body.className = 'text-sm text-slate-700';
          body.textContent = message.body;
          wrapper.appendChild(body);
        }

        if (message.attachments && message.attachments.length) {
          const files = document.createElement('div');
          files.className = 'flex flex-wrap gap-3';
          message.attachments.forEach((file) => {
            const isImage = file.mime && file.mime.startsWith('image/');
            const link = document.createElement('a');
            link.href = file.path;
            link.target = '_blank';
            link.className = isImage ? 'block' : 'px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs';
            if (isImage) {
              const img = document.createElement('img');
              img.src = file.path;
              img.alt = file.original_name;
              img.className = 'w-28 h-20 object-cover rounded-xl border border-slate-200';
              link.appendChild(img);
            } else {
              link.textContent = file.original_name;
            }
            files.appendChild(link);
          });
          wrapper.appendChild(files);
        }

        box.appendChild(wrapper);
        box.scrollTop = box.scrollHeight;
      });
  });
</script>
@endsection
