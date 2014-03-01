<?php
class Amazon
{

	// public key
	var $publicKey = 'YOUR-AMAZON-PRODUCT-ADVERTISING-PUBLIC-API-KEY-HERE';
	// private key
	var $privateKey = 'YOUR-AMAZON-PRODUCT-ADVERTISING-PRIVATE-API-KEY-HERE';
	// affiliate tag
	//var $affiliateTag='affiliateTag';

		/**
		*Get a signed URL
		*@param string $region used to define country
		*@param array $param used to build url
		*@return array $signature returns the signed string and its components
		*/
	public function generateSignature($param)
	{
		// url basics
		$signature['method']='GET';
		$signature['host']='ecs.amazonaws.'.$param['region'];
		$signature['uri']='/onca/xml';

	    // necessary parameters
		$param['Service'] = "AWSECommerceService";
	    $param['AWSAccessKeyId'] = $this->publicKey;
	    $param['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
	    $param['Version'] = '2011-08-01';
		ksort($param);
	    foreach ($param as $key=>$value)
	    {
	        $key = str_replace("%7E", "~", rawurlencode($key));
	        $value = str_replace("%7E", "~", rawurlencode($value));
	        $queryParamsUrl[] = $key."=".$value;
	    }
		// glue all the  "params=value"'s with an ampersand
	    $signature['queryUrl']= implode("&", $queryParamsUrl);

	    // we'll use this string to make the signature
		$StringToSign = $signature['method']."\n".$signature['host']."\n".$signature['uri']."\n".$signature['queryUrl'];
	    // make signature
	    $signature['string'] = str_replace("%7E", "~",
			rawurlencode(
				base64_encode(
					hash_hmac("sha256",$StringToSign,$this->privateKey,True
					)
				)
			)
		);
	    return $signature;
	}
		/**
		* Get signed url response
		* @param string $region
		* @param array $params
		* @return string $signedUrl a query url with signature
		*/
	public function getSignedUrl($params)
	{
		$signature=$this->generateSignature($params);

		return $signedUrl= "http://".$signature['host'].$signature['uri'].'?'.$signature['queryUrl'].'&Signature='.$signature['string'];
	}
}
?>
