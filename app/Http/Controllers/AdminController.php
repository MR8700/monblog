<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ChatMessage;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function edit()
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'profile_picture' => 'nullable|image|max:2048',
            'current_password' => 'required',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            // Supprimer l'ancienne si elle existe
            if ($admin->profile_picture && \Illuminate\Support\Facades\Storage::exists($admin->profile_picture)) {
                \Illuminate\Support\Facades\Storage::delete($admin->profile_picture);
            }
            $admin->profile_picture = $request->file('profile_picture')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profil mis à jour avec succès !');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            
            if ($admin->is_suspended) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Votre compte est suspendu. Veuillez contacter le super administrateur.']);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Identifiants incorrects']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalProducts = Product::count();
        $publishedProducts = Product::where('published', true)->count();
        $unpublishedProducts = Product::where('published', false)->count();
        $avgPrice = Product::where('published', true)->avg('price');
        $totalSales = \App\Models\OrderItem::sum('quantity');

        $totalPosts = Post::count();
        $publishedPosts = Post::where('published', true)->count();
        $totalComments = PostComment::count();
        $portfolioCount = PortfolioItem::count();
        $chatMessages = ChatMessage::count();

        $latestProducts = Product::latest()->take(5)->get();
        $topProducts = Product::orderByDesc('price')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'publishedProducts',
            'unpublishedProducts',
            'avgPrice',
            'totalSales',
            'totalPosts',
            'publishedPosts',
            'totalComments',
            'portfolioCount',
            'chatMessages',
            'latestProducts',
            'topProducts'
        ));
    }
}
