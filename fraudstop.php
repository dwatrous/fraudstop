<?php 

function get_transaction_count ($ip, $cardhash, $service_timeout = 3000) {
	// create curl resource 
	$ch = curl_init(); 

	// setup request
	curl_setopt($ch, CURLOPT_URL, "https://fraudstop.simplecreditcardpayments.com/frequency/$ip"); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $cardhash);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $service_timeout);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($cardhash))                                                                       
	);

	// return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_HEADER, true);

	// $output contains the output string 
	$output = curl_exec($ch); 

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($output, 0, $header_size);
	$body = substr($output, $header_size);

	$result = json_decode($body, true);
	//print_r($result);

	// close curl resource to free up system resources 
	if (curl_error($ch) == "") {
		$transaction_count = $result['count'];
	} else {
		$transaction_count = 0;
	}
	curl_close($ch);
	
	return $transaction_count;
}

// create request object
$cardhash = array("cardhash" => "098f6bcd4621d373cade4e832627b4fa");
$cardhash_json = json_encode($cardhash);
$ip_address = "1.2.3.4";

// get transaction count
$transaction_count = get_transaction_count($ip_address, $cardhash_json);

// print transaction attempts
print($transaction_count);

?>