<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ibr;
use App\Models\IbrDirectCommission;
use App\Models\IbrIndirectCommission;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IbrController extends Controller
{
    public function business_referrals(): JsonResponse
    {
        $business_referrals = Business::with('user')->where('ibr', auth()->user()->ibr_no)->get();
        return response()->json([
            'business_referrals' => $business_referrals,
        ]);
    }

    public function ibr_referrals(): JsonResponse
    {
        $ibr_referrals = User::where('referred_by', auth()->user()->ibr_no)
            ->select(['name', 'email', 'mobile_number'])
            ->get();

        return response()->json([
            'ibr_referrals' => $ibr_referrals,
        ]);
    }

    public function profileUpdate(Request $request): JsonResponse
    {
        Validator::make($request->all(),[
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ])->validate();

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::guard('ibr_api')->user()->getAuthPassword())))
            {
                return response()->json(['error' => 'Entered password did not matched our records']);
            }
        }
        if ($request->password != ''){
            if (strcmp($request->get('current_password'),$request->get('password'))==0)
            {
                return response()->json(['error' => 'Your current password cannot be same to new password']);
            }
        }

        Ibr::where('id', auth()->guard('ibr_api')->id())->update(['password' => Hash::make($request->password)]);
        return response()->json(['Success' => 'Profile updated successfully!!']);
    }

    public function directCommissions(): JsonResponse
    {
        $directCommissions = IbrDirectCommission::where([
            'ibr_no' => auth()->guard('ibr_api')->user()->ibr_no,
        ])
            ->get();

        if (count($directCommissions) > 0){
            return response()->json(['DirectCommissions' => $directCommissions]);
        }
        else{
            return response()->json(['data' => 'No data found'], 404);
        }
    }

    public function inDirectCommissions(): JsonResponse
    {
        $inDirectCommissions = IbrIndirectCommission::where([
            'ibr_no' => auth()->guard('ibr_api')->user()->ibr_no,
        ])->get();

        if (count($inDirectCommissions) > 0){
            return response()->json(['InDirectCommissions' => $inDirectCommissions]);
        }
        else{
            return response()->json(['data' => 'No data found'], 404);
        }
    }

    /* Functions for dashboard start */
    public function myEarnings(): JsonResponse
    {
        $directCommissions = IbrDirectCommission::with('inDirectCommissions')
            ->where('ibr_no' , 'IBR4')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();

        $inDirectCommissions = $directCommissions->pluck('inDirectCommissions');

        return response()->json([
            'directCommissions' => $directCommissions,
            'inDirectCommissions' => $inDirectCommissions,
        ]);
    }

    public function myClients(): JsonResponse
    {
        $clients = Business::with('businessPackages', 'coupon')
            ->withCount('activeUsers')
            ->where('ibr', auth()->guard('ibr_api')->user()->ibr_no)->get();

        return response()->json(['clients' => $clients]);
    }

    public function myNetworks(): JsonResponse
    {
        $network['ibr'] = Ibr::where('referred_by', auth()->guard('ibr_api')->user()->ibr_no)
            ->withCount('ibrReferred')
            ->get()
            ->toArray();

        $directIBRs['directIBRs'] = Ibr::where('referred_by', auth()->guard('ibr_api')->user()->ibr_no)->count();
        $directClients['directClients'] = Business::where('ibr', auth()->guard('ibr_api')->user()->ibr_no)->count();
        $directIncome['directIncome'] = IbrDirectCommission::where('ibr_no', auth()->guard('ibr_api')->user()->ibr_no)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        $inDirectIncome['inDirectIncome'] = IbrIndirectCommission::where('ibr_no', auth()->guard('ibr_api')->user()->ibr_no)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        $data = array_merge($network, $directIBRs, $directClients, $directIncome, $inDirectIncome);

        return response()->json(['data' => $data]);
    }
}
