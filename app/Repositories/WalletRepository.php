<?php
namespace App\Repositories;

use App\Models\{Wallet, Commission, WalletTransaction};
use App\Enums\TransactionType;

class WalletRepository
{
    public function creditCommission(Wallet $wallet, Commission $commission): void
    {
        $wallet->balance += $commission->amount;
        $wallet->total_earned += $commission->amount;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'commission_id' => $commission->id,
            'amount' => $commission->amount,
            'type' => TransactionType::Credit,
            'description' => "Level {$commission->level} {$commission->type->value} commission"
        ]);
    }
}
