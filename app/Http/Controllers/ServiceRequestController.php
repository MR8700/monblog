<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceRequestController extends Controller
{
    public function create()
    {
        $serviceTypes = ServiceType::where('is_active', true)->get();
        return view('public.services.request', compact('serviceTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'description' => 'required|string|max:10000',
            'custom_fields' => 'nullable|array',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,webp,txt',
        ]);

        try {
            $serviceRequest = ServiceRequest::create([
                'client_name' => strip_tags($validated['client_name']),
                'client_email' => $validated['client_email'],
                'client_phone' => strip_tags($validated['client_phone']),
                'service_type' => strip_tags($validated['service_type']),
                'description' => $validated['description'],
                'custom_fields' => $request->input('custom_fields'),
                'status' => 'pending',
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('service-requests', 'private');
                        $serviceRequest->attachments()->create([
                            'file_path' => $path,
                            'file_name' => basename($file->getClientOriginalName()),
                            'mime_type' => $file->getClientMimeType(),
                        ]);
                    }
                }
            }

            // Envoyer les notifications
            try {
                // Notification Admin
                $adminEmail = config('mail.from.address'); // Ou une adresse spécifique
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\ServiceRequestNotification($serviceRequest, 'admin'));
                
                // Notification Client
                \Illuminate\Support\Facades\Mail::to($serviceRequest->client_email)->send(new \App\Mail\ServiceRequestNotification($serviceRequest, 'client'));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erreur lors de l\'envoi des emails de service request: ' . $e->getMessage());
            }

            return redirect()->route('home')->with('success', 'Votre demande de service a été envoyée avec succès ! Nous vous contacterons bientôt.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la création de la demande de service: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'envoi de votre demande. Veuillez réessayer.');
        }
    }
}
