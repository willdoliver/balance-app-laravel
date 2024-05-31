<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BalanceModel;
use Illuminate\Support\Facades\Validator;

class BalanceController extends Controller
{
    public function reset(Request $request)
    {
        // TODO
        return ['reset balances'];
    }

    public function balance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => true,
                'erros' => $validator->getMessageBag()
            ], 200);
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
            // deposit event
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
