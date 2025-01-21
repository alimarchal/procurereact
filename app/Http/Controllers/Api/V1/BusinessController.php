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
use Illuminate\Support\Facades\Log;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        try {
            $business = Business::query()
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->paginate();

            return response()->json([
                'status' => 'success',
                'data' => BusinessResource::collection($business),
                'meta' => [
                    'total' => $business->total(),
                    'current_page' => $business->currentPage(),
                    'last_page' => $business->lastPage(),
                    'per_page' => $business->perPage()
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

            Log::error('Business registration failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Failed to create business',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }

    public function show(Business $business)
    {
        try {
            if ($business->id !== auth()->user()->business->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], 403);
            }

            return response()->json([
                'status' => 'success',
                'data' => new BusinessResource($business->load(['user']))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch business',
                'error' => $e->getMessage()
            ], 500);
        }
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
