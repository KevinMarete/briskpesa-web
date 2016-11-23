<?php

/*
	Sample checkout. Modify as needed. Leave the template as it is, however.
*/

require_once('BriskPesaGateway.php');

$apikey = "490cc963938029b5510bbf9932d1650ef80a86096b00ae8a0e9b84e6154b64b4";

$phone  = $_POST["phone"];
$amount  = $_POST["amount"];

$gateway = new BriskPesaGateway($apikey);

try 
{
	$results = $gateway->checkout($phone, $amount);
	# DO: update db if necessary
	# Sample success response: {"status": true, "trans_id": 23, "desc": "Ok"}
	# Sample failure response: {"status": false, "desc": "Invalid API key"}
	# How to pass json: $obj = json_decode($results);
	# Then: $obj->trans_id etc
	
	echo $results;
}

catch ( BriskPesaGatewayException $e )
{
  echo "Encountered an error while checking out: ".$e->getMessage();
}

?>
