<?php

namespace App\Services;

use App\Models\{Business, User};
use App\Enums\{CommissionType, CommissionStatus};
use App\Repositories\{CommissionRepository, WalletRepository};
use Illuminate\Support\Facades\DB;

readonly class CommissionCalculator
{
    public function __construct(
        private CommissionRepository $commissionRepository,
        private WalletRepository $walletRepository
    ) {}

    public function processCommission(Business $business): void
    {
        DB::transaction(function () use ($business) {
            $this->processDirectCommission($business);
            $this->processIndirectCommissions($business);
        });
    }

    private function processDirectCommission(Business $business): void
    {
        if ($business->amount === null) {
            // Handle the case where the business amount is null
            // For example, you could throw an exception or log an error
            throw new \Exception('Business amount is required');
        }

        $parent = $business->user->parent;

        if ($parent) {
            $this->createCommission(
                user: $parent,
                business: $business,
                fromUser: $business->user,
                // Passing $business->amount to calculateDirectCommission method
                amount: $this->calculateDirectCommission($business->amount),
                type: CommissionType::Direct,
                level: 1
            );
        }
    }

    private function processIndirectCommissions(Business $business): void
    {
        $parent = $business->user->parent; // Changed from parent?->parent
        $level = 1; // Changed from 2

        while ($parent && $level <= 5) { // Changed from 3 to 5
            if ($level > 1) { // Added check to skip first level
                $this->createCommission(
                    user: $parent,
                    business: $business,
                    fromUser: $business->user,
                    amount: $this->calculateIndirectCommission($business->amount),
                    type: CommissionType::Indirect,
                    level: $level
                );
            }

            $parent = $parent->parent;
            $level++;
        }
    }
    private function calculateDirectCommission(float $businessAmount): float
    {
        $directCommissionPercentage = 0.10; // 10% direct commission
        return $businessAmount * $directCommissionPercentage;
    }

    private function calculateIndirectCommission(float $businessAmount): float
    {
        return $businessAmount * 0.10;
    }

    private function createCommission(User $user, Business $business, User $fromUser, float $amount, CommissionType $type, int $level  ): void {
            $commission = $this->commissionRepository->create([
                'user_id' => $user->id,
                'business_id' => $business->id,
                'from_user_id' => $fromUser->id,
                'amount' => $amount,
                'type' => $type,
                'level' => $level,
                'status' => CommissionStatus::Pending
            ]);

        if ($user->wallet) {
            $this->walletRepository->creditCommission($user->wallet, $commission);
        } else {
            // Handle the case where the wallet is null
            // For example, you could throw an exception or log an error
            throw new \Exception('Wallet not found');
        }
    }
}
