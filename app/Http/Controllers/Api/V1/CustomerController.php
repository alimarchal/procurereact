<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $customers = Customer::query()
            ->where('company_id', auth()->user()->company->id)
            ->latest()
            ->paginate();

        return CustomerResource::collection($customers);
    }

    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vat_no' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string'
        ]);

        $customer = Customer::create([
            ...$validated,
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company->id
        ]);

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Customer $customer): CustomerResource
    {
        if ($customer->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        return new CustomerResource($customer);
    }

    public function update(Request $request, Customer $customer): CustomerResource
    {
        if ($customer->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vat_no' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string'
        ]);

        $customer->update($validated);

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer): Response
    {
        if ($customer->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $customer->delete();
        return response()->noContent();
    }
}
