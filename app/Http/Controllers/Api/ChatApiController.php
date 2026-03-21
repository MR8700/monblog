<?php

namespace App\Http\Controllers\Api;

use App\Models\ChatMessage;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessageRequest;
use Illuminate\Support\Facades\Auth;

class ChatApiController extends Controller
{
    /**
     * GET /api/v1/chat/messages
     */
    public function index(): JsonResponse
    {
        $messages = ChatMessage::with(['attachments', 'admin'])
            ->latest()
            ->take(50)
            ->get()
            ->reverse();

        return response()->json($messages->values());
    }

    /**
     * POST /api/v1/chat/messages
     */
    public function store(StoreChatMessageRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $isAdmin = Auth::guard('admin')->check();
        $adminId = $isAdmin ? Auth::guard('admin')->id() : null;
        $authorName = $isAdmin ? Auth::guard('admin')->user()->name : ($validated['name'] ?? 'Visiteur');

        $message = ChatMessage::create([
            'room' => 'global',
            'author_name' => $authorName,
            'admin_id' => $adminId,
            'author_type' => $isAdmin ? 'admin' : 'guest',
            'body' => $validated['body'] ?? null,
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
        return response()->json($message, 201);
    }
}
