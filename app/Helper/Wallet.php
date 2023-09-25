<?php

namespace App\Helper;

use App\Payment;
use App\User;
use App\Settings;

class Wallet
{
    public function updateStatusPayment($request)
    {
        $ACTIVE_GATEWAY = env('ACTIVE_GATEWAY');
        
        if($ACTIVE_GATEWAY == "doBank"){
            $typeStatus = [
                'pending' => 0,
                'Recebido' => 1,
                'failure' => 3
            ];
        }else{
            $typeStatus = [
                'pending' => 0,
                'approved' => 1,
                'failure' => 3
            ];
        }
        
        if(empty($request->status)){
            return response()->json(['status' => 403]);
        }

        if($request->status !== 'null'){
            $reference = $request->external_reference;
            $rechargeOrder = Payment::where('reference', $reference)->get();
            $user = User::find($rechargeOrder->first()->user);

            if($rechargeOrder->contains('status', 1) || $rechargeOrder->contains('status', 2)){
                return response()->json(['status' => 403]);
            }

            if($typeStatus[$request->status] === 0){
                return response()->json(['status' => 200]);
            }

            if($typeStatus[$request->status] !== 0){
                $newRechargeOrder = $rechargeOrder->first()->replicate();
                $newRechargeOrder->status = $typeStatus[$request->status];
                $newRechargeOrder->push();

                $totalRecharge = $newRechargeOrder->amount;

                if($typeStatus[$request->status] === 1){
                    $user->money += $newRechargeOrder->amount;
                    $user->save();
                    $refUserCode = $user->ref_use;
                    $refUserObj = User::where('ref_code', $refUserCode)->first();
                    if($refUserObj != null){
                    $settings = Settings::find(1);
                    $refUserObj->money += $totalRecharge * ($settings->promo_percent/100);
                    $refUserObj->save();
                    }
                }               

                return response()->json(['status' => 201]);
            }
        }
        return response()->json(['status' => 403]);
    }
}
