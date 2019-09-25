<?php
require 'config.php';
		header("Content_Type:application/json");

		$response = '{
			"ResultCode" : 0,
			"ResultDesc" : "Confirmation Received Successfully "

		}';

		//DATA

		//response from M-Pesa Stream
		$mpesaResponse = file_get_contents('php://input');

		//Log the response

		$logfile = "M_PESAConfirmationResponse.txt";//You will get details of the transaction here from M-PESA as a PlainText File

		$jsonMpesaResponse = json_decode($mpesaResponse, true);
		$transaction = array(

		':TransactionType'=> $jsonMpesaResponse['TransactionType'], 
		':TransID' => $jsonMpesaResponse['TransID'], 
		':TransTime' => $jsonMpesaResponse['TransTime'], 
		':TransAmount' => $jsonMpesaResponse['TransAmount'], 
		':BusinessShortCode' => $jsonMpesaResponse['BusinessShortCode'], 
		':BillRefNumber' => $jsonMpesaResponse['BillRefNumber'], 
		':InvoiceNumber' => $jsonMpesaResponse['InvoiceNumber'], 
		':OrgAccountBalance' => $jsonMpesaResponse['OrgAccountBalance'], 
		':ThirdPartyTransID' => $jsonMpesaResponse['ThirdPartyTransID'], 
		':MSISDN' => $jsonMpesaResponse['MSISDN'], 
		':FirstName' => $jsonMpesaResponse['FirstName'], 
		':MiddleNam' => $jsonMpesaResponse['MiddleName'], 
		':LastName' => $jsonMpesaResponse['LastName']
		);


		//Write to file
		$log = fopen($logfile, "a");

		fwrite($log, $mpesaResponse);
		fclose($log);

		echo $response;

		insert_response($jsonMpesaResponse);


?>