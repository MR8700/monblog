<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Obtenir ou générer un identifiant de session de chat pour le visiteur
     */
    private function getChatToken()
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        if (!session()->has('chat_token')) {
            session()->put('chat_token', 'room_' . bin2hex(random_bytes(8)));
        }

        return session()->get('chat_token');
    }

    public function index(Request $request)
    {
        $isAdmin = Auth::guard('admin')->check();
        
        if ($isAdmin) {
            return redirect()->route('admin.chat.index');
        }

        $room = $this->getChatToken();

        $messages = ChatMessage::with('attachments')
            ->where('room', $room)
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('chat.index', compact('messages', 'room'));
    }

    public function adminIndex()
    {
        // Lister les conversations groupées par room
        $conversations = ChatMessage::select('room', 'author_name', 'created_at')
            ->where('room', '!=', 'global')
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')
                    ->from('chat_messages')
                    ->groupBy('room');
            })
            ->orderByDesc('created_at')
            ->get();

        return view('admin.chat.index', compact('conversations'));
    }

    public function adminShow($room)
    {
        $messages = ChatMessage::with('attachments')
            ->where('room', $room)
            ->latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values();

        // Marquer comme lu (si on ajoute un champ is_read plus tard)
        
        return view('admin.chat.show', compact('messages', 'room'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => 'nullable|string|max:3000',
            'attachments.*' => 'nullable|file|max:10240',
            'room' => 'nullable|string',
        ]);

        $isAdmin = Auth::guard('admin')->check();
        $room = $isAdmin ? ($request->input('room') ?: 'global') : $this->getChatToken();
        $authorName = $isAdmin ? Auth::guard('admin')->user()->name : ($request->input('name') ?: 'Client');

        if (empty($data['body']) && ! $request->hasFile('attachments')) {
            return back()->withErrors(['body' => 'Message vide']);
        }

        $message = ChatMessage::create([
            'room' => $room,
            'author_name' => $authorName,
            'author_type' => $isAdmin ? 'admin' : 'guest',
            'body' => $data['body'] ?? null,
            'admin_id' => $isAdmin ? Auth::guard('admin')->id() : null,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('chat', 'public');
                $message->attachments()->create([
                    'path' => '/storage/' . $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        $message->load('attachments');
        broadcast(new ChatMessageSent($message))->toOthers();

        return back();
    }
}
