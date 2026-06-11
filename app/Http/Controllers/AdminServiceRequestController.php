<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed; // We can reuse or create new one

use App\Models\ServiceRequestInteraction;
use Illuminate\Support\Facades\Auth;

use App\Models\ServiceType;
use Illuminate\Support\Str;

class AdminServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = ServiceRequest::filter($request->all())
            ->latest()
            ->paginate(15);
        
        $serviceTypes = ServiceType::all();
        
        return view('admin.services.index', compact('requests', 'serviceTypes'));
    }

    public function storeType(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:service_types,name']);
        ServiceType::create(['name' => $request->name]);
        return back()->with('success', 'Nouveau type de service ajouté.');
    }

    public function toggleType(ServiceType $serviceType)
    {
        $serviceType->update(['is_active' => !$serviceType->is_active]);
        return back()->with('success', 'Statut du service mis à jour.');
    }

    public function destroyType(ServiceType $serviceType)
    {
        $serviceType->delete();
        return back()->with('success', 'Type de service supprimé.');
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load('attachments', 'delivery.comments', 'interactions.admin');
        return view('admin.services.show', compact('serviceRequest'));
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'price' => 'nullable|numeric',
            'admin_notes' => 'nullable|string',
        ]);

        $oldStatus = $serviceRequest->status;
        $serviceRequest->update($validated);

        if ($oldStatus !== $validated['status']) {
            $serviceRequest->interactions()->create([
                'type' => 'status_change',
                'content' => "Statut changé de {$oldStatus} à {$validated['status']}",
                'admin_id' => Auth::id(),
            ]);
        }

        if ($request->filled('admin_notes')) {
            $serviceRequest->interactions()->create([
                'type' => 'note',
                'content' => $validated['admin_notes'],
                'admin_id' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Demande mise à jour.');
    }

    public function logInteraction(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'type' => 'required|in:email,whatsapp,note',
            'content' => 'required|string',
        ]);

        $serviceRequest->interactions()->create([
            'type' => $validated['type'],
            'content' => $validated['content'],
            'admin_id' => Auth::id(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Interaction enregistrée.');
    }

    public function createDelivery(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:51200', // 50MB
            'preview' => 'nullable|image|max:10240',
            'price' => 'required|numeric',
            'is_public' => 'boolean',
        ]);

        $filePath = $request->file('file')->store('deliveries/files', 'public');
        $previewPath = $request->hasFile('preview') ? $request->file('preview')->store('deliveries/previews', 'public') : null;

        $delivery = Delivery::create([
            'service_request_id' => $serviceRequest->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'preview_path' => $previewPath,
            'price' => $validated['price'],
            'is_public' => $request->has('is_public'),
        ]);

        $serviceRequest->update(['status' => 'delivered']);

        return back()->with('success', 'Produit livré sur l\'espace sécurisé. Lien généré.');
    }

    public function regenerateDeliveryToken(Delivery $delivery)
    {
        $delivery->update(['secure_token' => (string) \Illuminate\Support\Str::uuid()]);
        return back()->with('success', 'Lien sécurisé régénéré avec succès.');
    }
}
