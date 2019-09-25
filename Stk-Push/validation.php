<?php
		header("Content_Type:application/json");

		$response = '{
			"ResultCode" : 0,
			"ResultDesc" : "Confirmation Received Successfully "

		}';

		//DATA

		$mpesaResponse = file_get_contents('php://input');

		//Log the response

		$logfile = "validationResponse.txt";

		$jsonMpesaResponse = json_decode($mpesaResponse, true);

		//Write to file
		$log = fopen($logfile, "a");

		fwrite($log, $mpesaResponse);
		fclose($log);

		echo $response;


?>