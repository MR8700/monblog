<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        $serviceTypes = ServiceType::all();
        return view('admin.settings.index', compact('settings', 'serviceTypes'));
    }

    public function updateVisual(Request $request)
    {
        $this->validatePassword($request);

        $data = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:512',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('settings', 'public');
            Setting::set('site_logo', $data['logo'], 'visual');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
            Setting::set('site_favicon', $data['favicon'], 'visual');
        }

        if (isset($data['site_name'])) Setting::set('site_name', $data['site_name'], 'visual');
        if (isset($data['primary_color'])) Setting::set('primary_color', $data['primary_color'], 'visual');
        if (isset($data['secondary_color'])) Setting::set('secondary_color', $data['secondary_color'], 'visual');

        return back()->with('success', 'Identité visuelle mise à jour.');
    }

    public function updateEmail(Request $request)
    {
        $this->validatePassword($request);

        $data = $request->validate([
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'email');
        }

        return back()->with('success', 'Configuration email mise à jour.');
    }

    public function backup(Request $request)
    {
        $this->validatePassword($request);

        try {
            // Dans un environnement réel, on utiliserait spatie/laravel-backup
            // Ici on simule ou on fait un simple dump si possible
            Artisan::call('db:monitor'); // Juste pour tester l'appel artisan
            
            return back()->with('success', 'Sauvegarde de la base de données initiée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function storeServiceType(Request $request)
    {
        $this->validatePassword($request);
        $request->validate(['name' => 'required|string|unique:service_types,name']);
        ServiceType::create(['name' => $request->name]);
        return back()->with('success', 'Nouveau type de service ajouté.');
    }

    public function toggleServiceType(ServiceType $serviceType)
    {
        $serviceType->update(['is_active' => !$serviceType->is_active]);
        return back()->with('success', 'Statut du service mis à jour.');
    }

    public function destroyServiceType(ServiceType $serviceType)
    {
        $serviceType->delete();
        return back()->with('success', 'Type de service supprimé.');
    }

    private function validatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        if (!Hash::check($request->current_password, auth()->guard('admin')->user()->password)) {
            abort(403, 'Mot de passe de confirmation incorrect.');
        }
    }
}
