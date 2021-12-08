<?php

namespace App\Http\Controllers\API;

use App\lib\zarinpal;
use DB;

/*require_once 'nusoap.php';*/

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ZarinPallController extends Controller
{

    public function add_order(Request $request)
    {

        $order = new zarinpal();
        $res = $order->pay($request->price,$request->email,$request->phone_number);
        return redirect('https://www.zarinpal.com/pg/StartPay/' . $res);

    }

    public function order(Request $request){

        $MerchantID = 'LEAFRD4S-ECOM-COAC-6BXB-HOA7L5EWVZIU';
        $Authority =$request->get('Authority') ;

        $data = array("merchant_id" => "$MerchantID", "authority" => $Authority, "amount" => $request->amount);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if ($err) {

            return response()->json([
                'message' => 'cURL Error #:' . $err,
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);

        } else {

            if ($result['data']['code'] == 100) {

                return response()->json([
                    'message' => 'Transation success.',
                    'ref_id' =>  $result['data']['ref_id'],
                    'status' => Response::HTTP_OK,
                ]);

            } else {

                return response()->json([
                    'message' => $result['errors']['message'],
                    'status' => $result['errors']['code'], // is it correct or bellow is correct?
//                    'status' => Response::HTTP_OK,
                ]);

            }

        }

    }

}

