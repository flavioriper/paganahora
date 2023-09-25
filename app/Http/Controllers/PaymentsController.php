<?php

namespace App\Http\Controllers;


use App\User;
use App\Game;
use App\Withdraw;
use App\Settings;
use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PaymentsController extends Controller
{

    public function tefway()
    {
        $settings = Settings::find(1)->first();
        if ($settings->tefway_token) {
            $keys = $this->getKeys($settings->tefway_test, $settings->tefway_token);
        } else {
            $keys[] = "Insira um token para validar a forma de pagamento";
        }
        return view('admin.tefway', compact('settings', 'keys'));
    }

    public function update(Request $r)
    {
        $settings = Settings::find(1)->first();
        $settings->tefway_token = $r->tefway_token;
        $settings->tefway_test = $r->tefway_test;
        $settings->tefway_active = $r->tefway_active;
        $settings->tefway_pix = $r->tefway_pix;
        $settings->save();
        return redirect('/admin/payments/tefway');
    }

    private function getKeys($tefway_test, $tefway_token) {
        $url = $tefway_test == "1" ? "https://sandbox.meutef.com.br:33443" : "https://api.meutef.com.br:33443";
        $url .= "/apipix/accounts/aliases?aliasStatus=ACTIVE";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $tefway_token
            ),
        ));

        $response = curl_exec($curl);

        $error = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        if($error) {
            $keys[] = $error;
        } else if (isset($response["data"])) {
            $keys = [];
            $allKeys = $response["data"]["aliases"];
            foreach ($allKeys as $value) {
                $keys[] = $value["name"];
            }
        } else {
            $keys[] = "Chave invalida";
        }
        return $keys;
    }

}