<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\Wallet;
use Illuminate\Support\Facades\Log;


class ZoopController extends Controller
{
    public function processTransactionSuccess(Request $request)
    {


        if($request->has('type') && $request->type == 'ping') {
            return response()->json([], 200);
        }

        if($request->has('id') && $request->has('type') && $request->type == 'transaction.succeeded') {

            $payload = $request->payload;
            $data = new \stdClass;

            $data->status = $payload['object']['status'] == 'succeeded' ? 'approved' : 'failure';
            $data->external_reference = $payload['object']['id'];

            $walletHelper = new Wallet;

            return $walletHelper->updateStatusPayment($data);

        }

        return response()->json([
            'error' => 'Requisição inválida'
        ], 400);
    }
}