<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Stephen Bungert <stephenbungert@yahoo.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Implementation of oAuth for the TYPO3 extension "sb_portfolio"
 * Just enough is implemented to use the the flickr API in anonymous mode
 * The requests are only signed with the consumer token and don't need an access token.
 *
 * Code based on flickrimages code.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Flickr_Authorisation_OAuth {
	/**
	 * Signature method to be used
	 *
	 * @var string
	 */
	protected $signatureMethod = 'HMAC-SHA1';
	
	/**
	 * The http method to be used
	 *
	 * @var string
	 */
	protected $httpMethod = 'GET';
	
	/**
	 * The oauth version to be used
	 *
	 * @var string
	 */
	protected $version = '1.0';
	
	/**
	 * The flickr API key
	 *
	 * @var string
	 */
	protected $apiKey;
	
	/**
	 * The signature for signing requests
 	 *
	 * @var string
	 */
	protected $signature = '';
	
	/**
	 * The oauth parameters
	 *
	 * @var array
	 */
	protected $params;
	
	
	
	/**
	 * __construct
	 *
	 * @param array $apiKey The Flickr API Key for your app
	 * @return void
	 */
	public function __construct($apiKey) {
		$this->setApiKey($apiKey);
		
		$this->setCallbackUrl(\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('HTTP_HOST') . \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REQUEST_URI'));
	}
	
	
	
	/**
	 * Sets version
	 *
	 * @param string $version The oauth version
	 * @return void
	 */
	public function setVersion($version) {
		$this->version = $version;
	}
	
	/**
	 * Returns version
	 *
	 * @return string $version
	 */
	public function getVersion() {
		return $this->version;
	}
	
	/**
	 * Sets signatureMethod
	 *
	 * @param string $signatureMethod The method used to sign requests
	 * @return void
	 */
	public function setSignatureMethod($signatureMethod) {
		$this->signatureMethod = $signatureMethod;
	}
	
	/**
	 * Returns signatureMethod
	 *
	 * @return string $signatureMethod
	 */
	public function getSignatureMethod() {
		return $this->signatureMethod;
	}
	
	/**
	 * Sets httpMethod
	 *
	 * @param string $httpMethod The method used to perform queries
	 * @return void
	 */
	public function setHttpMethod($httpMethod) {
		$this->httpMethod = strtoupper($httpMethod);
	}
	
	/**
	 * Returns httpMethod
	 *
	 * @return string $httpMethod
	 */
	public function getHttpMethod() {
		return $this->httpMethod;
	}
	
	/**
	 * Sets callbackUrl
	 *
	 * @param string $callbackUrl The local url for you requests.
	 * @return void
	 */
	public function setCallbackUrl($callbackUrl) {
		$this->callbackUrl = $callbackUrl;
	}
	
	/**
	 * Returns callbackUrl
	 *
	 * @return string $callbackUrl
	 */
	public function getCallbackUrl() {
		return $this->callbackUrl;
	}
	
	/**
	 * Returns apiKey
	 *
	 * @return string $apiKey
	 */
	public function getApiKey() {
		return $this->apiKey;
	}
	
	/**
	 * Sets apiKey
	 *
	 * @param string $apiKey The Flickr API key.
	 * @return void
	 */
	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}
	
	/**
	 * Returns signature
	 *
	 * @return string $signature
	 */
	public function getSignature() {
		return $this->signature;
	}
	
	/**
	 * Sets signature
	 *
	 * @param string $signature The signature for signung requests
	 * @return void
	 */
	public function setSignature($signature) {
		$this->signature = $signature;
	}
	
	/**
	 * Set params
	 *
	 * @param array $methodParams Params for the services API method being used
	 * @return void
	 */
	public function setParams(array $methodParams) {
		$defaultParams = array (
			'oauth_version'				=> $this->getVersion(),
			'oauth_nonce'				=> $this->generateNonce(),
			'oauth_timestamp'			=> $this->generateTimeStamp(),
			'oauth_consumer_key'		=> $this->getApiKey(),
			'oauth_signature_method'	=> $this->getSignatureMethod(),
		);
		
		if (!empty($methodParams)) {
			$this->params = array_merge($defaultParams, $methodParams);
			
		} else {
			$this->params = $defaultParams;
		}
	}
	
	/**
	 * Set a new parameter in $this->params 
	 *
	 * @param string $key The key for the new parameter
	 * @param string $value The value for the new parameter
	 * @return void
	 */
	public function setParam($key, $value) {
		$this->params[$key] = $value;
	}
	
	/**
	 * Get params
	 *
	 * @return array $params
	 */
	public function getParams() {
		return $this->params;
	}
	
	
	
	/**
	 * Returns a unix timestamp
	 *
	 * @return integer
	 */
	protected function generateTimeStamp() {
		return time();
	}
	
	/**
	 * Returns a unique ID (for nonce)
	 *
	 * @return string
	 */
	protected function generateNonce() {
		return md5(uniqid(rand(), true));
	}
	
	
	
	/**
	 * Does a few things that are required before calling go()
	 *
	 * @param array $methodParams Params for the services API method being used
	 * @return void
	 */
	public function prepare(array $methodParams = array()) {
		$this->setParams($methodParams);
		$this->generateSignature();
		$this->signRequest();
	}
	
	/**
	 * Generates the signiture for the request
	 *
	 * @return void
	 */
	public function generateSignature() {
		$baseString = $this->createBaseString();
		$this->setSignature($this->createSignature($baseString));
	}
	
	/**
	 * Create a the base string used for generating the signature
	 *
	 * @return string $baseString
	 */
	protected function createBaseString() {
		$params = $this->getParams();
		
	    // Urlencode both keys and values
	    $keys	= array_keys($params);
	    $values	= array_values($params);
		
	    $keys	= array_map('urlencode', $keys);
	    $values	= array_map('urlencode', $values);
		
	    $paramsEncoded = array_combine($keys, $values);
		
	    uksort($params, 'strcmp');
		
		$baseString	= '';
		
		foreach ($paramsEncoded as $key => $value) {
			$baseString .= $key . '=' . $value . '&';
		}
		
		$baseString = trim($baseString, '&');
		$baseString = $this->getHttpMethod() . '&' . urlencode($this->getCallbackUrl()) . '&' . urlencode($baseString);
		
		return $baseString;
	}
	
	/**
	 * Creates the signature for signing the requests with
	 *
	 * @param string $baseString: The base string
	 * @return string
	 */
	protected function createSignature($baseString) {
		return base64_encode(hash_hmac('sha1', $baseString, '&', true));
	}

	/**
	 * Signs the request (adds the signature to the query)
	 *
	 * @return void
	 */
	public function signRequest() {
		$this->setParam('oauth_signature', $this->getSignatureMethod());
	}
	


	/**
	 * Starts the request query to a service, like scoop.it 
	 *
	 * @param string $url The beginning of the URL
	 * @return array
	 */
	public function go($url) {
		return $this->createRequestUrl($url);
	}
	
	/**
	 * Requests the token
	 *
	 * @param string $urlPrefix The beginning of the URL
	 * @return array
	 */
	protected function createRequestUrl($urlPrefix) {
		$fields = $this->getParams();
		
		$fields_string = '';
		
		foreach ($fields as $key => $value) {
			$fields_string .= $key . '=' . urlencode($value) . '&';
		}
		
		$fields_string = rtrim($fields_string, '&');
		
		$url = '?' . $fields_string;
		
		return $this->contactService($urlPrefix . $url);
	}
	
	/**
	 * Makes a GET query to a service that uses oauth, like flickr, scoop.it etc.
	 *
	 * @return string
	 */
	protected function contactService($url) {
		$curlHandle = curl_init();
		
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 5);
		
		$data = curl_exec($curlHandle);
        $info = curl_getinfo($curlHandle);
		
		curl_close($curlHandle);
		
		return array (
			'data' => $data,
			'info' => $info,
		);
	}
}
?>