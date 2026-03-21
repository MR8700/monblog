<?php

namespace App\Http\Controllers\Api;

use App\Models\PortfolioItem;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortfolioApiController extends Controller
{
    /**
     * GET /api/v1/portfolio
     */
    public function index(): JsonResponse
    {
        $items = PortfolioItem::with('admin')
            ->orderBy('sort_order')
            ->get();

        return response()->json($items);
    }

    /**
     * POST /api/v1/portfolio
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'role' => 'nullable|string',
            'stack' => 'nullable|string',
            'summary' => 'nullable|string',
            'link' => 'nullable|url',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'is_current' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $item = PortfolioItem::create([
            ...$validated,
            'admin_id' => auth()->guard('admin')->id(),
        ]);

        return response()->json($item, 201);
    }

    /**
     * PUT /api/v1/portfolio/{portfolio}
     */
    public function update(Request $request, PortfolioItem $portfolio): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'role' => 'nullable|string',
            'stack' => 'nullable|string',
            'summary' => 'nullable|string',
            'link' => 'nullable|url',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date',
            'is_current' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $portfolio->update($validated);
        return response()->json($portfolio);
    }

    /**
     * DELETE /api/v1/portfolio/{portfolio}
     */
    public function destroy(PortfolioItem $portfolio): JsonResponse
    {
        $portfolio->delete();
        return response()->json(['message' => 'Portfolio item deleted'], 200);
    }
}
