<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Mail\DeliveryPaid;
use Illuminate\Support\Facades\Mail;

class DeliveryController extends Controller
{
    /**
     * Vitrine publique des livraisons (E-Vitrine)
     */
    public function gallery()
    {
        $deliveries = Delivery::where('is_public', true)
            ->latest()
            ->paginate(12);

        return view('public.deliveries.gallery', compact('deliveries'));
    }

    /**
     * Espace sécurisé de livraison (Public via Token)
     */
    public function show($token)
    {
        $delivery = Delivery::where('secure_token', $token)
            ->with(['comments', 'serviceRequest'])
            ->firstOrFail();

        return view('public.deliveries.show', compact('delivery'));
    }

    /**
     * Traiter le paiement de la livraison
     */
    public function processPayment(Request $request, $token)
    {
        $delivery = Delivery::where('secure_token', $token)->with('serviceRequest')->firstOrFail();

        if ($delivery->status === 'paid') {
            return back()->with('success', 'Cette livraison est déjà payée.');
        }

        // Ici, on devrait normalement rediriger vers la passerelle de paiement
        // Pour cet exercice, nous simulons la validation de paiement
        
        $delivery->update(['status' => 'paid']);

        // Envoyer l'email avec la facture et le produit
        try {
            Mail::to($delivery->serviceRequest->client_email)->send(new DeliveryPaid($delivery));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur d'envoi d'email de livraison : " . $e->getMessage());
        }

        return back()->with('success', 'Paiement validé ! Votre produit est maintenant disponible au téléchargement et vous a été envoyé par email.');
    }

    /**
     * Ajouter un commentaire/réaction sur la livraison
     */
    public function storeComment(Request $request, $token)
    {
        $delivery = Delivery::where('secure_token', $token)->firstOrFail();
        
        $request->validate(['content' => 'required|string']);

        $delivery->comments()->create([
            'author_name' => $request->author_name ?? 'Client',
            'content' => $request->content,
            'is_admin' => auth()->guard('admin')->check(),
        ]);

        // Si lié à une demande de service, on historise
        if ($delivery->serviceRequest) {
            $delivery->serviceRequest->interactions()->create([
                'type' => 'note',
                'content' => "Nouveau commentaire client sur l'espace de livraison : " . $request->content,
                'admin_id' => auth()->guard('admin')->id(), // Sera null si c'est le client
            ]);
        }

        return back()->with('success', 'Votre retour a été enregistré.');
    }

    /**
     * Liker/Réagir à une livraison
     */
    public function toggleReaction(Request $request, $token)
    {
        $delivery = Delivery::where('secure_token', $token)->firstOrFail();
        
        $reactions = $delivery->reactions ?? [];
        $type = $request->type ?? 'like';
        
        if (isset($reactions[$type])) {
            $reactions[$type]++;
        } else {
            $reactions[$type] = 1;
        }

        $delivery->update(['reactions' => $reactions]);

        return back();
    }

    /**
     * Téléchargement sécurisé après paiement
     */
    public function download($token)
    {
        $delivery = Delivery::where('secure_token', $token)->firstOrFail();

        if ($delivery->status !== 'paid') {
            abort(403, 'Le paiement est requis pour télécharger ce produit.');
        }

        return Storage::disk('public')->download($delivery->file_path, $delivery->title . '.' . pathinfo($delivery->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Afficher la facture de la livraison
     */
    public function invoice($token)
    {
        $delivery = Delivery::where('secure_token', $token)
            ->with('serviceRequest')
            ->firstOrFail();

        if ($delivery->status !== 'paid') {
            abort(403, 'La facture n\'est disponible qu\'après paiement.');
        }

        return view('public.deliveries.invoice', compact('delivery'));
    }
}
