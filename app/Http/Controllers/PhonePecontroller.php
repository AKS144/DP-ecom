<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class PhonePecontroller extends Controller
{
    
    /*public function phonePe()
    {
        $data = array (
            'merchantId' => 'MERCHANTUAT',
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'MUID123',
            'amount' => 10000,
            'redirectUrl' => route('response'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('response'),
            'mobileNumber' => '9999999999',
            'paymentInstrument' => 
            array (
            'type' => 'PAY_PAGE',
            ),
        );

  
        $encode = base64_encode(json_encode($data));
         //dd($encode);
        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $string = $encode.'/pg/v1/pay'.$saltKey;
        //dd($string);
        $sha256 = hash('sha256',$string);
        //dd($sha256);

        $finalXHeader = $sha256.'###'.$saltIndex;
        //dd($finalXHeader);

        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";
        //dd($url);
        
        $response = Curl::to($url)
                        ->withHeader('Content-Type:application/json')
                        ->withHeader('X-VERIFY:' . $finalXHeader)
                        ->withData(json_encode(['request' => $encode]))
                        ->post();

        dd($response);
        $rData = json_decode($response);
        dd($rData);
        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    }

    public function response(Request $request)
    {
        $input = $request->all();

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $finalXHeader = hash('sha256','/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'].$saltKey).'###'.$saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'])
                ->withHeader('Content-Type:application/json')
                ->withHeader('accept:application/json')
                ->withHeader('X-VERIFY:'.$finalXHeader)
                ->withHeader('X-MERCHANT-ID:'.$input['transactionId'])
                ->get();

        dd(json_decode($response));
    }*/


        // PhonePe Integration
        public function makePhonePePayment(Request $request)
        {
            $amount = session()->get('phonepe_amount') ?? 100;
        
            $data = array (
              'merchantId' => 'MERCHANTUAT',
              'merchantTransactionId' => 'MT7850590068188103',
              'merchantUserId' => 'MUID123',
              'amount' => $amount * 100,
              'redirectUrl' => route('phonepe.payment.callback'),
              'redirectMode' => 'POST',
              'callbackUrl' => route('phonepe.payment.callback'),
              'mobileNumber' => '9999999999',
              'paymentInstrument' => 
              array (
                'type' => 'PAY_PAGE',
              ),
            );
    
            // dd($data);
            $encode = base64_encode(json_encode($data));
    
            // $saltKey = '16b35d38-90c1-47ee-8d5e-20e383e31804';
            $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
            $saltIndex = 1;
    
            $string = $encode.'/pg/v1/pay'.$saltKey;
            $sha256 = hash('sha256',$string);
    
            $finalXHeader = $sha256.'###'.$saltIndex;
            //dd($finalXHeader);
    
            
            $curl = curl_init();
            // //dd($curl);    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/pay',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => false,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode(['request' => $encode]),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-VERIFY: '.$finalXHeader,
                'X-DEBUG: true'
              ),
            ));    

            
            $response = curl_exec($curl);

            // dd($response);
            curl_close($curl);             
            
            $rData = json_decode($response);

    
            return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    
        }
    
        public function phonePeCallback(Request $request)
        {
            $input = $request->all();
    
            $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
            $saltIndex = 1;
    
            $finalXHeader = hash('sha256','/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'].$saltKey).'###'.$saltIndex;
    
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'],
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => false,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'accept: application/json',
                'X-VERIFY: '.$finalXHeader,
                'X-MERCHANT-ID: '.$input['transactionId']
              ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
    
            dd(json_decode($response));
            // flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
            // return redirect()->route('order_confirmed');
        }
}
