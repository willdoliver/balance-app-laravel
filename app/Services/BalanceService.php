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

    public function findAccountById($accountId): ?BalanceModel
    {
        return $this->balanceRepository->getAccountById($accountId);
    }

    public function depositAmount(BalanceModel $balanceModel, $amount): BalanceModel
    {
        return new BalanceModel([
            'accountId' => $balanceModel->accountId,
            'balance' => $balanceModel->balance + $amount,
        ]);
    }

    public function withdrawAmount(BalanceModel $balanceModel, $amount): BalanceModel
    {
        if ($amount > $balanceModel->balance) {
            return $balanceModel;
        } else {
            return new BalanceModel([
                'accountId' => $balanceModel->accountId,
                'balance' => $balanceModel->balance - $amount,
            ]);

        }
    }

    public function saveAccount(BalanceModel $balanceModel)
    {
        return $this->balanceRepository->saveAccount($balanceModel);
    }

    public function resetAccounts(): void
    {
        $this->balanceRepository->resetAllAccounts();
    }

}
