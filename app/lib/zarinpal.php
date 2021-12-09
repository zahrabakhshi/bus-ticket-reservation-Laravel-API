<?php
namespace App\lib;

use Symfony\Component\HttpFoundation\Response;

class zarinpal
{
    public $MerchantID;

    public function __construct()
    {
        $this->MerchantID="LEAFRD4S-ECOM-COAC-6BXB-HOA7L5EWVZIU";
    }

    public function pay($Amount)
    {
        $data = array("merchant_id" => $this->MerchantID,
            "amount" => $Amount,
            "callback_url" => url('/order'),
            "description" => "خرید تست",
        );
        $jsonData = json_encode($data);

        $ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));


        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);

        curl_close($ch);

        if ($err) {

            return response()->json([
                'message' => 'cURL Error #:' . $err,
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);

        } else {
            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    header('Location: https://sandbox.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
                }
            } else {
                return response()->json([
                    'message' => $result['errors']['message'],
                    'status' => $result['errors']['code'],
                ]);

            }
        }

    }

}
