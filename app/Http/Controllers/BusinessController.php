<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Http\Resources\V1\BusinessResource;
use App\Models\Business;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Business::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when(request('type'), function ($query, $type) {
                $query->where('company_type', $type);
            })
            ->latest()
            ->paginate(request('per_page', 15));

        return BusinessResource::collection($companies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $validatedData['company_logo'] = $logoPath;
        }

        if ($request->hasFile('company_stamp')) {
            $stampPath = $request->file('company_stamp')->store('company_stamps', 'public');
            $validatedData['company_stamp'] = $stampPath;
        }

        $business = Business::create($validatedData);

        return response()->json([
            'message' => 'Company created successfully',
            'data' => new BusinessResource($business)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business)
    {
        return new BusinessResource($business);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessRequest $request, Business $business)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('company_logo')) {
            if ($business->company_logo) {
                Storage::disk('public')->delete($business->company_logo);
            }
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $validatedData['company_logo'] = $logoPath;
        }

        if ($request->hasFile('company_stamp')) {
            if ($business->company_stamp) {
                Storage::disk('public')->delete($business->company_stamp);
            }
            $stampPath = $request->file('company_stamp')->store('company_stamps', 'public');
            $validatedData['company_stamp'] = $stampPath;
        }

        $business->update($validatedData);

        return response()->json([
            'message' => 'Company updated successfully',
            'data' => new BusinessResource($business)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        if ($business->quotations()->exists() || $business->invoices()->exists()) {
            return response()->json([
                'message' => 'Cannot delete company with associated records'
            ], 422);
        }

        if ($business->company_logo) {
            Storage::disk('public')->delete($business->company_logo);
        }
        if ($business->company_stamp) {
            Storage::disk('public')->delete($business->company_stamp);
        }

        $business->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
