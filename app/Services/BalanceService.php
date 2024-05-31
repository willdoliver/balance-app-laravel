<?php

namespace App\Services;

use App\Repositories\BalanceRepository;
use App\Models\BalanceModel;
use Exception;

class BalanceService
{
    protected $balanceRepository;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function findAccountById($accountId)
    {
        try {
            $exists = $this->balanceRepository->getAccountById($accountId);
            return $exists;
        } catch (Exception) {
        }
    }

    public function createAccount(BalanceModel $balance)
    {
        $account = $this->balanceRepository->saveAccount($balance);
        return $account;
    }
}
