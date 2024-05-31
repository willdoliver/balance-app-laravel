<?php

namespace App\Repositories;

use App\Models\BalanceModel;
use Exception;

class BalanceRepository
{
    protected $accounts;

    public function __construct(array $accounts = [])
    {
        $this->accounts = $accounts;
    }

    public function getAccountById(int $account_id): ?BalanceModel
    {
        return $this->accounts[$account_id] ?? null;
    }

    public function saveAccount(BalanceModel $balanceModel)
    {
        try {
            $this->accounts[$balanceModel->account_id] = $balanceModel;
            return $balanceModel;
        } catch (Exception) {
            return [
                'error' => 'Erro while creating account'
            ];
        }
    }
}
