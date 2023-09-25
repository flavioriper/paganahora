<?php

    namespace App\Http\Controllers;

    use App\Helper\Money;
    use App\Http\Controllers\Controller;
    use App\Payment;
    use App\Models\TransactBalance;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    use App\Helper\Configs;
    use App\Helper\MensagemTelegram;
    use App\Helper\ZoopGateway;

    class WalletController extends Controller
    {
        public function createPayment(Request $request){

            $amount = $request->amount;
            $value = intval($amount);
           $order = new Payment([
                'amount' => $value,
				'user' => Auth::user()->id,
				'time' => time(),
				'status' => 0
            ]);
            $order->save();

            $zoopGateway = new ZoopGateway;
            $authorize = $zoopGateway->createCharge($order);
            $response = $authorize->getResponse();

            $order->update(['external_id' => $response['payment_method']['qr_code']['emv'], 'reference' => $response['id']]);

            return json_encode(array("paymentCode" =>  $order->external_id));
        }
        
    }
