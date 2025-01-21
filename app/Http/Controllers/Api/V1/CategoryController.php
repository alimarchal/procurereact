<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BusinessResource;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {

        try {
            $categories = Category::query()
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->paginate();

            return response()->json([
                'status' => 'success',
                'data' => CategoryResource::collection($categories),
                'meta' => [
                    'total' => $categories->total(),
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch customers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'boolean'
            ]);

            $category = Category::create([
                ...$validated,
                'user_id' => auth()->id(),
                'business_id' => auth()->user()->business->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category)
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
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
