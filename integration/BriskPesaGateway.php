<?php
/*

	# COPYRIGHT (C) 2016 MOBIWORLD ICT SOLUTIONS LTD <www.mobiworld.co.ke>   

BRISKPESA GATEWAY CLASS IS A FREE SOFTWARE IE. CAN BE MODIFIED AND/OR REDISTRIBUTED UNDER THE TERMS OF GNU GENERAL PUBLIC LICENCES AS PUBLISHED BY THE FREE SOFTWARE FOUNDATION VERSION 3 OR ANY LATER VERSION.
 
 */

class BriskPesaGatewayException extends Exception{}

class BriskPesaGateway
{
	protected $_apiKey;
	
	const CHECKOUT_URL = 'https://api.briskpesa.com/v1/checkout';
	const POLL_URL = 'https://api.briskpesa.com/v1/poll';

	public function __construct($apiKey_)
	{
		$this->_apiKey = $apiKey_;
	}

	public function checkout($phone_, $amount_)
	{
		if ( strlen($phone_) == 0 || strlen($amount_) == 0 ) {
			throw new BriskPesaGatewayException('Please supply both phone and amount parameters');
		}

		if ( !$this->isValidPhoneNumber($phone_) ) {
			throw new BriskPesaGatewayException('Enter a valid phone number');
		}

		if ( !is_numeric($amount_) ) {
			throw new BriskPesaGatewayException('Enter a valid amount');
		}

		if ( intval($amount_) < 10 ) {
			throw new BriskPesaGatewayException('Amount must be greater than 10');
		}
		
		$phone_ = $this->sanitizePhoneNumber($phone_);
		$params = array(
		    'phone' => $phone_,
		    'amount' => $amount_,
		    'api_key' => $this->_apiKey,
		);
		$res = $this->executePost($params, self::CHECKOUT_URL);
		return $res;
	}

	public function poll($trans_id)
	{
		$params = array(
		    'trans_id' => $trans_id,
			'api_key' => $this->_apiKey,
		);
		$res = $this->executePost($params, self::POLL_URL);
		return $res;
	}
	
	private function executePost ($dataArray, $url)
  	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArray);
		$result = curl_exec($ch);
		
		if ($result === FALSE) {
			throw new BriskPesaGatewayException('curl failed' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}

	private function isValidPhoneNumber($phone)
	{
		return preg_match('/^(?:\\+?254)?(0|7|07)\\d{8}$/', $phone);
	}

	private function sanitizePhoneNumber($phone){
		if ($phone[0] === '0') {
		    return $phone;
		}
		else if ($phone[0] === '+') {
		    return "0" . substr($phone, 4);
		}
		else if ( (substr($phone, 0, 3) === "254")) {
		    return "0" . substr($phone, 3);
		}
		else if ( strlen($phone) === 9) {
		    return "0" . $phone;
		}        
		return $phone;
	}
}

?>
