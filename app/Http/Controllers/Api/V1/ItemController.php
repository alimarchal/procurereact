<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $items = Item::query()
            ->where('company_id', auth()->user()->company->id)
            ->with('category')
            ->latest()
            ->paginate();

        return ItemResource::collection($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'unit' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $item = Item::create([
            ...$validated,
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company->id
        ]);

        return new ItemResource($item);
    }

    public function show(Item $item)
    {
        if ($item->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        return new ItemResource($item);
    }

    public function update(Request $request, Item $item)
    {
        if ($item->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'code' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'unit' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $item->update($validated);

        return new ItemResource($item);
    }

    public function destroy(Item $item)
    {
        if ($item->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $item->delete();
        return response()->noContent();
    }
}
