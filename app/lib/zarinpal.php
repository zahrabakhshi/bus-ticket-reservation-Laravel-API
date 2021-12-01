<?php
namespace App\lib;

class zarinpal
{
    public $MerchantID;

    public function __construct()
    {
        $this->MerchantID="LEAFRD4S-ECOM-COAC-6BXB-HOA7L5EWVZIU";
    }

    public function pay($Amount,$Email,$Mobile)
    {
        $data = array("merchant_id" => $this->MerchantID,
            "amount" => $Amount,
            "callback_url" => url('/order'),
            "description" => "خرید تست",
            "metadata" => [ "email" => "$Email","mobile"=>"$Mobile"],
        );
        $jsonData = json_encode($data);
        $ch = curl_init('https://banktest.ir/gateway/zarinpal/pg/rest/WebGate/PaymentRequest.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);

        if ($result['Status'] == 100) {
            return $result['Authority'];
        } else {
            return false;
        }

    }

}
