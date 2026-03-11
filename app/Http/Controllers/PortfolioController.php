<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;

class PortfolioController extends Controller
{
    public function index()
    {
        $featured = PortfolioItem::where('featured', true)
            ->orderBy('sort_order')
            ->get();

        $items = PortfolioItem::orderBy('sort_order')
            ->orderByDesc('started_at')
            ->get();

        return view('portfolio.index', compact('featured', 'items'));
    }
}
