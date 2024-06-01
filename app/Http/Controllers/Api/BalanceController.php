<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BalanceModel;
use App\Services\BalanceService;
use Illuminate\Support\Facades\Validator;

class BalanceController extends Controller
{
    protected $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    public function reset(Request $request)
    {
        try {
            $this->balanceService->resetAccounts();
            return response('OK', 200);
        } catch (Exception $e) {
            return response(0, 404);
        }
    }
    public function balance(Request $request)
    {
        try {
            // Validate fields
            $validator = Validator::make($request->all(), [
                'account_id' => 'required|int'
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => true,
                    'erros' => $validator->getMessageBag()
                ], 200);
            }

            // Check account
            $accountId = $request->get('account_id');
            $accountExists = $this->balanceService->findAccountById($accountId);
            if (is_null($accountExists)) {
                return response(0, 404);
            }

            return response($accountExists->balance, 200);
        } catch (Exception $e) {
            return response(0, 404);
        }
    }

    public function event(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'destination' => 'required_without:origin|string',
                'origin' => 'required_without:destination|string',
                'type' => 'required|in:deposit,withdraw,transfer',
                'amount' => 'required|int'
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => true,
                    'erros' => $validator->getMessageBag()
                ], 200);
            }

            $type = $request->get('type');
            $amount = $request->get('amount');

            if (in_array($type, ['withdraw', 'transfer'])) {
                $accountId = $request->get('origin');
                $accountExists = $this->balanceService->findAccountById($accountId);
                if (is_null($accountExists)) {
                    return response(0, 404);
                }
            } else {
                $accountId = $request->get('destination');
                $accountExists = $this->balanceService->findAccountById($accountId);
            }

            if ($type === 'deposit') {
                if (!is_null($accountExists)) {
                    $balanceModel = $this->balanceService->depositAmount($accountExists, $amount);
                } else {
                    $balanceModel = new BalanceModel([
                        'accountId' => $accountId,
                        'balance' => $amount
                    ]);
                }

                $saved = $this->balanceService->saveAccount($balanceModel);

                if ($saved) {
                    return response([
                        'destination' => [
                            'id' => $balanceModel->accountId,
                            'balance' => $balanceModel->balance
                        ]
                    ], 201);
                } else {
                    return response(0, 404);
                }
            } elseif ($type === 'withdraw') {
                $balanceModel = $this->balanceService->withdrawAmount($accountExists, $amount);
                $saved = $this->balanceService->saveAccount($balanceModel);

                return response([
                    'origin' => [
                        'id' => $balanceModel->accountId,
                        'balance' => $balanceModel->balance
                    ]
                ], 201);
            } elseif ($type === 'transfer') {
                // Withdraw from origin
                $originAccount = $this->balanceService->withdrawAmount($accountExists, $amount);
                $saved = $this->balanceService->saveAccount($originAccount);

                if ($saved) {
                    //  Deposit to destination
                    $destinationAccountId = $request->get('destination');
                    $destinationAccount = $this->balanceService->findAccountById($destinationAccountId);
                    if (is_null($destinationAccount)) {
                        $balanceModel = new BalanceModel([
                            'accountId' => $destinationAccountId,
                            'balance' => $amount
                        ]);
                    } else {
                        $balanceModel = $this->balanceService->depositAmount($accountExists, $amount);
                    }
                    $saved = $this->balanceService->saveAccount($balanceModel);
                }

                return response([
                    'origin' => [
                        'id' => $originAccount->accountId,
                        'balance' => $originAccount->balance
                    ],
                    'destination' => [
                        'id' => $destinationAccountId,
                        'balance' => $balanceModel->balance
                    ]
                ], 201);
            }
        } catch (Exception $e) {
            return response(0, 404);
        }
    }

}
