<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CompanyResource;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $companies = Company::paginate();
        return CompanyResource::collection($companies);
    }

    public function store(StoreCompanyRequest $request): JsonResponse
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

        $company = Company::create($validatedData);

        return response()->json([
            'message' => 'Company created successfully',
            'data' => new CompanyResource($company)
        ], 201);
    }

    public function show(Company $company): CompanyResource
    {
        return new CompanyResource($company);
    }

    public function update(UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        if ($request->hasFile('company_logo')) {
            if ($company->company_logo) {
                Storage::disk('public')->delete($company->company_logo);
            }
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $validatedData['company_logo'] = $logoPath;
        }

        if ($request->hasFile('company_stamp')) {
            if ($company->company_stamp) {
                Storage::disk('public')->delete($company->company_stamp);
            }
            $stampPath = $request->file('company_stamp')->store('company_stamps', 'public');
            $validatedData['company_stamp'] = $stampPath;
        }

        $company->update($validatedData);

        return response()->json([
            'message' => 'Company updated successfully',
            'data' => new CompanyResource($company)
        ]);
    }

    public function destroy(Company $company): JsonResponse
    {
        if ($company->quotations()->exists() || $company->invoices()->exists()) {
            return response()->json([
                'message' => 'Cannot delete company with associated records'
            ], 422);
        }

        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully'
        ]);
    }
}
