<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::filter($request->all())
            ->latest()
            ->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'profile_picture' => 'nullable|image|max:2048',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,super_admin',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ];

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('avatars', 'public');
        }

        Admin::create($data);

        return redirect()->route('admin.admins.index')->with('success', 'Administrateur créé avec succès.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'profile_picture' => 'nullable|image|max:2048',
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,super_admin',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->hasFile('profile_picture')) {
            if ($admin->profile_picture && Storage::exists($admin->profile_picture)) {
                Storage::delete($admin->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Administrateur mis à jour.');
    }

    public function toggleSuspension(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas suspendre votre propre compte.');
        }

        $admin->update(['is_suspended' => !$admin->is_suspended]);
        
        $status = $admin->is_suspended ? 'suspendu' : 'activé';
        return back()->with('success', "Compte administrateur {$status}.");
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($admin->isSuperAdmin() && Admin::where('role', 'super_admin')->count() <= 1) {
            return back()->with('error', 'Vous ne pouvez pas supprimer le dernier super-administrateur.');
        }

        if ($admin->profile_picture && Storage::exists($admin->profile_picture)) {
            Storage::delete($admin->profile_picture);
        }

        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Administrateur supprimé.');
    }
}
  return redirect()->route('admin.admins.index')->with('success', 'Administrateur supprimé.');
    }
}
