<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::with('attachments')
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => 'nullable|string|max:3000',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $isAdmin = Auth::guard('admin')->check();
        $authorName = $isAdmin ? Auth::guard('admin')->user()->name : ($request->input('name') ?: 'Visiteur');

        if (empty($data['body']) && ! $request->hasFile('attachments')) {
            return back()->withErrors(['body' => 'Message vide']);
        }

        $message = ChatMessage::create([
            'room' => 'global',
            'author_name' => $authorName,
            'author_type' => $isAdmin ? 'admin' : 'guest',
            'body' => $data['body'] ?? null,
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
