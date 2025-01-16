<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Http\Resources\V1\BusinessResource;
use App\Models\Business;
use App\Services\CommissionCalculator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('name_arabic', 'like', "%{$request->search}%");
        }

        // Filter by company type
        if ($request->has('company_type')) {
            $query->where('company_type', $request->company_type);
        }

        // Filter by city
        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        // Order by
        $orderBy = $request->order_by ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $query->orderBy($orderBy, $direction);

        // Pagination
        $perPage = $request->per_page ?? 15;

        return BusinessResource::collection($query->paginate($perPage));
    }

    public function store(StoreBusinessRequest $request)
    {
        try {
            $validated = $request->validated();

            // Add the authenticated user's ID
            $validated['user_id'] = auth()->id();

            if ($request->hasFile('company_logo')) {
                $validated['company_logo'] = $request->file('company_logo')
                    ->store('business/logos', 'public');
            }

            if ($request->hasFile('company_stamp')) {
                $validated['company_stamp'] = $request->file('company_stamp')
                    ->store('business/stamps', 'public');
            }

            $user = auth()->user();

            // Ensure the user has a wallet
            if (!$user->wallet) {
                $user->wallet()->create();
            }

            $business = Business::create($validated);


            $calculator = app(CommissionCalculator::class);
            $calculator->processCommission($business);



            return (new BusinessResource($business))
                ->response()
                ->setStatusCode(201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create business',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    public function show(Business $business)
    {
        return new BusinessResource($business->load(['user', 'parent', 'children']));
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        $validated = $request->validated();


        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $request->file('company_logo')
                ->store('business/logos', 'public');
        }

        if ($request->hasFile('company_stamp')) {
            $validated['company_stamp'] = $request->file('company_stamp')
                ->store('business/stamps', 'public');
        }

        $business->update($validated);
        return new BusinessResource($business);
    }

    public function destroy(Business $business)
    {
        $business->delete();
        return response()->noContent();
    }

    public function restore($id)
    {
        $business = Business::withTrashed()->findOrFail($id);
        $business->restore();

        return new BusinessResource($business);
    }

    public function forceDelete($id)
    {
        $business = Business::withTrashed()->findOrFail($id);
        $business->forceDelete();

        return response()->noContent();
    }
}
