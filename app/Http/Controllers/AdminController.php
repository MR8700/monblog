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
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profil mis a jour avec succes !');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
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
