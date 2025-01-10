<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        if (!auth()->user()->company) {
            abort(403, 'No company associated with user');
        }

        $categories = Category::query()
            ->where('company_id', auth()->user()->company->id)
            ->latest()
            ->paginate();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $category = Category::create([
            ...$validated,
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company->id
        ]);

        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        if ($category->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        if ($category->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $category->update($validated);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        if ($category->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $category->delete();
        return response()->noContent();
    }
}
