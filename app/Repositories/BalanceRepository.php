<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Models\BalanceModel;
use Exception;

class BalanceRepository
{
    public function getAccountById(int $accountId): ?BalanceModel
    {
        $allAccounts = Cache::get('allAccounts');
        return $allAccounts[$accountId] ?? null;
    }

    public function saveAccount(BalanceModel $balanceModel): bool
    {
        try {
            $allAccounts = Cache::get('allAccounts') ?? [];
            $allAccounts[$balanceModel->accountId] = $balanceModel;

            Cache::put('allAccounts', $allAccounts, now()->addMinutes(60));
            return true;
        } catch (Exception) {
            return false;
        }
    }

    public function resetAllAccounts(): bool
    {
        return Cache::flush();
    }
}
