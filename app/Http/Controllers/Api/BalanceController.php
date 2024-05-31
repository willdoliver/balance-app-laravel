<?php

namespace App\Http\Controllers\Api;

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
        // TODO
        return ['reset balances'];
    }

    public function balance(Request $request)
    {
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
        $account_id = $request->get('account_id');
        $account_exists = $this->balanceService->findAccountById($account_id);

        if (!$account_exists) {
            return response([0], 400);
        }

        dd($request->all());
    }

    public function event(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string',
            'type' => 'required|in:deposit,withdraw,transfer',
            'amount' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => true,
                'erros' => $validator->getMessageBag()
            ], 200);
        }

        $account_id = $request->get('destination');
        $type = $request->get('type');
        $amount = $request->get('amount');

        // TODO
        // check if account exists
        if ($type === 'deposit') {
            $this->balanceService->createAccount(
                new BalanceModel([
                    'account_id' => $account_id,
                    'balance' => $amount
                ])
            );

            return response([
                'destination' => [
                    'id' => $account_id,
                    'balance' => $amount
                ]
            ], 201);
        } elseif ($type === 'withdraw') {
            // withdraw event
        } elseif ($type === 'transfer') {
            // check destination account exists
            // withdraw from origin and deposit to destination
        }

        $balance = new BalanceModel(
            [
                'account_id' => $account_id,
                'balance' => $amount
            ]
        );

        dd($balance);
    }
}
