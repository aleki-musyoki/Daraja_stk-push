 <?php
    //Access token code 
    $consumerKey = '';//Fill with your app Key
    $consumerSecret = '';//Fill with your app Secret


    $headers = ['Content-Type:application/json; charset=utf8'];

   $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
   $curl = curl_init($access_token_url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
   curl_setopt($curl, CURLOPT_HEADER, FALSE);
   curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
   $result = curl_exec($curl);
   $status = curl_getinfo($curl , CURLINFO_HTTP_CODE);
   $result = json_decode($result);
   $access_token = $result->access_token;     
   curl_close($curl);





    /* Initiating the transaction */



    //Defining the variables 
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $BusinessShortCode = '';//Organisation shortcode receiving the transaction
    $Timestamp = date('ymdGis');//It is in the format of year/month/day/hour(24hr)/minute/second
    $PartyA = '254700000000';//MSISDN sending the money(preferrably yours)
    $CallBackURL = '';//url where responses from M-PESA will be sent 
    $Amount = '1';//Amount to be transacted(actual amount will be deducted from your M-PESA)
    $AccountReference = 'CART098';//Used with the M-PESA Paybills 
    $TransactionDesc = 'Payment for services from Enigma Inc. for Bundle Payment';//Description of the transaction such as the example given 
    $Passkey = '';//Pass key from the credentials
    $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);//password in a base-64encoding to encrypt the request

    $stkheader = ['Content-Type:application/json','Authorization:Bearer'.$access_token];

    if (!$access_token) {
      echo "Sorry failed transaction";
    }else{
      echo "Transaction Successful";
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $initiate_url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
      //setting custom header    
      $curl_post_data = array(
        //Fill in the request parameters with valid values
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,//This is the MSISDN sending the funds 
        'PartyB' => $BusinessShortCode,//Same as the business shortcode
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
      );
      
      $data_string = json_encode($curl_post_data);
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
      
      $curl_response = curl_exec($curl);
      print_r($curl_response);
      
      echo $curl_response;
    }
    
    
  ?>