<?php 

function get_transaction_count ($ip, $cardhash) {
	// create curl resource 
	$ch = curl_init(); 

	// setup request
	curl_setopt($ch, CURLOPT_URL, "https://fraudstop.simplecreditcardpayments.com/frequency/$ip"); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $cardhash);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 3000);
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

print(get_transaction_count("1.2.3.4", json_encode($cardhash)));

?>