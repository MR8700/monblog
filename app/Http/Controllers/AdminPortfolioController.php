<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPortfolioController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();
        $items = PortfolioItem::filter($request->all())
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('admin.portfolio.index', compact('items'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.portfolio.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $this->validateData($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = '/storage/' . $request->file('cover_image')->store('portfolio', 'public');
        }

        PortfolioItem::create($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Projet ajoute.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        $this->authorizeAdmin();
        return view('admin.portfolio.edit', ['item' => $portfolio]);
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $this->authorizeAdmin();

        $data = $this->validateData($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = '/storage/' . $request->file('cover_image')->store('portfolio', 'public');
        }

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Projet mis a jour.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        $this->authorizeAdmin();
        $portfolio->delete();

        return back()->with('success', 'Projet supprime.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'stack' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'link' => 'nullable|url',
            'cover_image' => 'nullable|image|max:4096',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'is_current' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_current'] = $request->filled('is_current');
        $data['featured'] = $request->filled('featured');

        return $data;
    }

    private function authorizeAdmin(): void
    {
        if (! Auth::guard('admin')->check()) {
            abort(403, 'Acces interdit');
        }
    }
}
