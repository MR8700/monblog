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
            'description' => 'required|string',
            'custom_fields' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:20480', // 20MB max
        ]);

        $serviceRequest = ServiceRequest::create([
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'service_type' => $validated['service_type'],
            'description' => $validated['description'],
            'custom_fields' => $request->input('custom_fields'),
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('service-requests', 'public');
                $serviceRequest->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Votre demande de service a été envoyée avec succès ! Nous vous contacterons bientôt.');
    }
}
