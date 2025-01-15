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
        if (!auth()->user()->business) {
            abort(403, 'No business associated with user');
        }

        $categories = Category::query()
            ->where('business_id', auth()->user()->business->id)
            ->latest()
            ->paginate();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => ['required', 'exists:businesses,id'],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $category = Category::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
//        try {
//            $user = auth()->user();
//
//            if (!$user || !$user->business) {
//                return response()->json([
//                    'message' => 'User or business not found',
//                    'status' => 403
//                ], 403);
//            }
//
//            if ($category->business_id !== $user->business->id) {
//                return response()->json([
//                    'message' => 'Unauthorized access',
//                    'status' => 403
//                ], 403);
//            }
//
//
//
//        } catch (\Exception $e) {
//            return response()->json([
//                'message' => $e->getMessage(),
//                'status' => 500
//            ], 500);
//        }
    }

    public function update(Request $request, Category $category)
    {
        if ($category->business_id !== auth()->user()->business->id) {
            abort(403);
        }

        $validated = $request->validate([
            'business_id' => ['required', 'exists:businesses,id'],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $category->update($validated);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        if ($category->business_id !== auth()->user()->business->id) {
            abort(403);
        }

        $category->delete();
        return response()->noContent();
    }
}
