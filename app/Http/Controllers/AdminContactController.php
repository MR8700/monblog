<?php

namespace App\Http\Controllers;

use App\Mail\ContactReply;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $message->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        // Envoi de la réponse par email au client
        try {
            Mail::to($message->email)->send(new ContactReply($message));
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Le message a été enregistré mais l\'email n\'a pas pu être envoyé.');
        }

        return redirect()->route('admin.messages.index')->with('success', 'Réponse envoyée avec succès.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message supprimé.');
    }
}
