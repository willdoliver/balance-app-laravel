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
            'account_id' => 'required'
        ]);

        // TODO: Validate json
        $validator->setAttributeNames(['account_id' => 'Número da conta é obrigatório']);
        if ($validator->fails()) {
            return ['error' => 1, 'msg' => $validator->errors()];
        } else {
            dd($request->all());
        }
    }

    public function event(Request $request)
    {
        $account_id = $request->get('destination');
        $type = $request->get('type');
        $amount = $request->get('amount');

        // TODO
        // validate possible types
        // check if account exists

        if ($type == 'deposit') {
            // deposit event
        } elseif ($type == 'withdraw') {
            // withdraw event
        } elseif ($type == 'transfer') {
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
