<?php

namespace App\Http\Controllers;

use App\Mail\ContactNotification;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function send(Request $request)
    {
        // Protection anti-spam Honeypot
        if ($request->filled('website')) {
            return back()->with('error', 'Spam détecté.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Ajout de l'IP pour le suivi
        $validated['ip_address'] = $request->ip();

        // Création du message
        $message = ContactMessage::create($validated);

        // Notification par email à l'admin (Gmail)
        try {
            Mail::to(config('mail.from.address'))->send(new ContactNotification($message));
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas bloquer l'utilisateur
            report($e);
        }

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
