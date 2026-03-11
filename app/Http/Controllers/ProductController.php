<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Post;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Liste des produits.
     * - Admin : tous les produits.
     * - Public : uniquement les produits publiés.
     */

    /**
     * Affiche la liste publique des produits.
     */
    public function publicIndex()
    {
        // On récupère uniquement les produits publiés (si tu as un champ 'published')
        $products = Product::where('published', true)
            ->orderByDesc('created_at')
            ->paginate(12); // pagination de 12 produits par page

        return view('admin.products.index', compact('products'));
    }

    /**
     * Affiche le détail d’un produit public (via le slug).
     */
    public function publicShow(Product $product)
    {
        // Vérifie que le produit est publié
        if (! $product->published) {
            abort(404, 'Produit non disponible');
        }

        return view('admin.products.show', compact('product'));
    }

public function publicHome()
{
    // Récupère uniquement les produits publiés, les plus récents en premier, pagination de 9 par page
    $products = Product::where('published', true)
                        ->latest()
                        ->take(6)
                        ->get();

    $latestPosts = Post::where('published', true)
        ->orderByDesc('published_at')
        ->orderByDesc('created_at')
        ->take(3)
        ->get();

    $featuredPortfolio = PortfolioItem::where('featured', true)
        ->orderBy('sort_order')
        ->take(3)
        ->get();

    // Retourne la vue publique (tu peux utiliser la même vue que pour la liste si tu veux)
    return view('home', compact('products', 'latestPosts', 'featuredPortfolio'));
}

    public function index()
    {
        $isAdmin = Auth::guard('admin')->check();

        $products = $isAdmin
            ? Product::latest()->paginate(10)
            : Product::where('published', true)->latest()->paginate(9);

        return view('admin.products.index', compact('products', 'isAdmin'));
    }

    /**
     * Affiche un produit.
     * - Admin : n'importe quel produit.
     * - Public : uniquement les produits publiés.
     */
    public function show(Product $product)
    {
        if (!Auth::guard('admin')->check() && !$product->published) {
            abort(404, 'Produit non disponible');
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Formulaire création produit (admin uniquement)
     */
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.products.create');
    }

    /**
     * Enregistrement nouveau produit (admin uniquement)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $this->validateData($request);

        $data['slug'] = Str::slug($data['title']) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
    }

    /**
     * Formulaire édition produit (admin uniquement)
     */
    public function edit(Product $product)
    {
        $this->authorizeAdmin();
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Mise à jour produit (admin uniquement)
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    /**
     * Supprimer produit (admin uniquement)
     */
    public function destroy(Product $product)
    {
        $this->authorizeAdmin();
        $product->delete();

        return back()->with('success', 'Produit supprimé.');
    }

    /**
     * Validation commune pour store et update
     */
    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'image'       => 'nullable|image|max:2048',
            'whatsapp'    => 'nullable|string',
            'facebook'    => 'nullable|url',
            'phone'       => 'nullable|string',
            'email'       => 'nullable|email',
        ]);

        // Checkbox published
        $data['published'] = $request->filled('published');

        return $data;
    }

    /**
     * Vérifie si l’admin est connecté
     */
    private function authorizeAdmin()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Accès interdit');
        }
    }
}
