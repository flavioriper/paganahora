<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\User;

class TefwayController extends Controller {

    public function callback(Request $request)
    {
        $data = $request->get('data');
        $data = isset($data) ? $data : array("externalIdentifier" => $request->get('externalIdentifier'));
        if (isset($data['externalIdentifier'])) {

            $paymentId = $data['externalIdentifier'];

            $payment = Payment::where('external_id', $paymentId)->first();
            $user = User::where('id', $payment->user)->first();

            if (isset($payment) && isset($user) && $payment->status == 0) {
                $payment->status = 1;
                $payment->update();

                $user->money += $payment->amount;
                $user->update();
            }

            return "OK";

        }
    }
}