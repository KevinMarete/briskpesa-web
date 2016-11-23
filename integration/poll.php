<?php

/*
	Sample poll. Modify as needed. Leave the template as it is, however.
*/

require_once('BriskPesaGateway.php');

$apikey = "490cc963938029b5510bbf9932d1650ef80a86096b00ae8a0e9b84e6154b64b4";
$trans_id  = $_POST["trans_id"];

$gateway = new BriskPesaGateway($apikey);

try 
{
	$results = $gateway->poll($trans_id);
	# DO: update db if necessary
	# Sample failure response: {"status": -1, "desc": "Pending"}
	# Sample success response: {"status": 0, "mpesa_code": "KDU1MWUGPB"}
	# Sample failure response: {"status": 1, "desc": "Transaction expired"}
	# How to pass json: $obj = json_decode($results);
	# Then: $obj->status etc
	echo $results;
}

catch ( BriskPesaGatewayException $e )
{
  echo "Encountered an error while checking out: ".$e->getMessage();
}

?>
