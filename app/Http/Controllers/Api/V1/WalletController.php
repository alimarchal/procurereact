<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\WalletResource;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    public function index()
    {
        return new WalletResource(
            auth()->user()->wallet()->with('transactions')->firstOrFail()
        );
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'type' => ['required', Rule::in(['credit', 'debit'])],
            'description' => ['required', 'string', 'min:1']
        ], [
            'amount.required' => 'Amount field is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.gt' => 'Amount must be greater than 0',
            'type.required' => 'Transaction type is required',
            'type.in' => 'Type must be either credit or debit',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be text',
            'description.min' => 'Description must not be empty'
        ]);

        // Check if wallet exists
        $wallet = auth()->user()->wallet;
        if (!$wallet) {
            return response()->json([
                'message' => 'Wallet not found',
                'status' => 'error'
            ], 404);
        }

        // Check balance for debit transactions
        if ($validated['type'] === 'debit' && $wallet->balance < $validated['amount']) {
            return response()->json([
                'message' => 'Insufficient balance',
                'status' => 'error',
                'current_balance' => $wallet->balance
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create transaction
            $transaction = $wallet->transactions()->create([
                'amount' => $validated['amount'],
                'type' => $validated['type'],
                'description' => $validated['description']
            ]);

            // Update wallet balance
            $wallet->balance = $validated['type'] === 'credit'
                ? $wallet->balance + $validated['amount']
                : $wallet->balance - $validated['amount'];

            if ($validated['type'] === 'credit') {
                $wallet->total_earned += $validated['amount'];
            } else {
                $wallet->total_withdrawn += $validated['amount'];
            }

            $wallet->save();

            DB::commit();

            return response()->json([
                'message' => 'Transaction completed successfully',
                'status' => 'success',
                'data' => [
                    'transaction' => $transaction,
                    'wallet' => [
                        'balance' => $wallet->balance,
                        'total_earned' => $wallet->total_earned,
                        'total_withdrawn' => $wallet->total_withdrawn
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Transaction failed',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Wallet $wallet)
    {
        // Ensure user can only access their own wallet
        if ($wallet->user_id !== auth()->id()) {
            abort(403);
        }

        return new WalletResource($wallet->load('transactions'));
    }

//    public function destroy(Wallet $wallet)
//    {
//        if ($wallet->user_id !== auth()->id()) {
//            abort(403);
//        }
//
//        $wallet->delete();
//        return response()->noContent();
//    }

    public function directCommissions(): JsonResponse
    {
        $commissions = auth()->user()->commissions()
            ->where('type', 'direct')
            ->with(['business', 'fromUser'])
            ->get();

        return response()->json([
            'data' => $commissions,
            'total' => $commissions->sum('amount')
        ]);
    }

    public function indirectCommissions(): JsonResponse
    {
        $commissions = auth()->user()->commissions()
            ->where('type', 'indirect')
            ->with(['business', 'fromUser'])
            ->get();

        return response()->json([
            'data' => $commissions,
            'total' => $commissions->sum('amount')
        ]);
    }

    public function myEarnings(): JsonResponse
    {
        $earnings = DB::table('commissions')
            ->where('user_id', auth()->id())
            ->select(
                DB::raw('SUM(CASE WHEN type = "direct" THEN amount ELSE 0 END) as direct_earnings'),
                DB::raw('SUM(CASE WHEN type = "indirect" THEN amount ELSE 0 END) as indirect_earnings'),
                DB::raw('SUM(amount) as total_earnings'),
                DB::raw('COUNT(CASE WHEN type = "direct" THEN 1 END) as direct_count'),
                DB::raw('COUNT(CASE WHEN type = "indirect" THEN 1 END) as indirect_count')
            )
            ->first();

        return response()->json([
            'earnings' => $earnings,
            'wallet_balance' => auth()->user()->wallet?->balance ?? 0
        ]);
    }

    public function myClients(): JsonResponse
    {
        $clients = auth()->user()->businesses()
            ->with(['user'])
            //->withCount(['quotations', 'invoices'])
            ->get();

        return response()->json([
            'data' => $clients,
            'total_clients' => $clients->count(),
            'active_clients' => $clients->where('status', 'active')->count()
        ]);
    }

    public function myNetworks(): JsonResponse
    {
        $referrals = auth()->user()->children()
            ->with(['businesses', 'wallet'])
            ->withCount(['businesses', 'commissions'])
            ->get();

        $stats = [
            'total_referrals' => $referrals->count(),
            'total_businesses' => $referrals->sum('businesses_count'),
            'total_commissions' => $referrals->sum('commissions_count'),
            'total_earnings' => $referrals->sum('wallet.total_earned'),
            'active_referrals' => $referrals->where('is_active', 'Yes')->count()
        ];

        return response()->json([
            'referrals' => $referrals,
            'stats' => $stats
        ]);
    }
}
