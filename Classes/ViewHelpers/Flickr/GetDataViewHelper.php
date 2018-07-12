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
 * ViewHelper for getting flickr data.
 *
 * Based on the Flickr Controller in the extension flickrimages.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_Flickr_GetDataViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Flickr model
	 *
	 * @var Tx_Flickrimages_Domain_Model_Flickr
	 */
	protected $flickr;

	/**
	 * Have any basic errors been made, like not adding the default TS, or setting an API key?
	 *
	 * @var boolean
	 */
	protected $basicError = FALSE;

	/**
	 * The Flickr API key, either the key from TS or the FF key (if there was one).
	 *
	 * @var string
	 */
	protected $apiKey = FALSE;

	/**
	 * The current action
	 *
	 * @var string
	 */
	protected $actionName;

	/**
	 * The TS settings for flickr.
	 *
	 * @var string
	 */
	protected $settings;

	/**
	 * The item's setId.
	 *
	 * @var string
	 */
	protected $setId;

	/**
	 * Returns the flickr data if any.
	 *
	 * @param string $setId The current item's setid.
	 * @param array $settings The flickr settings from TS.
	 * @return array $flickrData An empty array or the flickr data.
	 */
	public function render($setId, array $settings) {
		$flickrData = array();
		
		$this->setSettings($settings);
		$this->setSetId($setId);
		$this->setApiKey();
		
		$this->checkForBasicErrors();
		
		if ($this->basicError === FALSE) {
			$this->flickr = t3lib_div::makeInstance('Tx_SbPortfolio2_Domain_Flickr_Flickr', $this->getApiKey());
			
				// Get params
			$methodParams	= $this->getMethodParams('getPhotos');
			$set			= $this->flickr->getPhotos($methodParams);
			
			if ($set['error'] == '0') {
				$set = $set['data']['photoset'];
				
					// Now get information about the set
				$methodParams	= $this->getMethodParams('getInfo');
				$setInfo		= $this->flickr->getInfo($methodParams);
				
				if ($setInfo['error'] == '0') {
					$setInfo	= $setInfo['data']['photoset'];
					$flickrData	= array_merge($set, $setInfo);
					
				} else {
					$flickrData					= $setInfo['data'];
					$flickrData['error']		= 1;
					$flickrData['errorMethod']	= $methodParams['method'];
				}
				
			} else {
				$flickrData					= $set['data'];
				$flickrData['error']		= 1;
				$flickrData['errorMethod']	= $methodParams['method'];
			}
			
			if ($flickrData['error'] == 1) {
				if (intval($flickrData['code']) >= 100) {
					$flickrData['errorMethod'] = 'shared';
				}
			}
			
		} else { // Basic error.
			$flickrData['error']		= 1;
			$flickrData['basicError']	= $this->basicError;
		}
		
		return $flickrData;
	}

	/**
	 * Sets the API key, checking first in TS and then overlaying the key from the FF if any.
	 *
	 * @return void.
	 */
	protected function setApiKey() {
		$tsKey	= trim($this->settings['api_key']);
		$apiKey	= '';
		
		if(!empty($tsKey)) {
			$apiKey = $tsKey;
		}
		
		$this->apiKey = $apiKey;
	}
	
	/**
	 * Returns the API key.
	 *
	 * @return void.
	 */
	protected function getApiKey() {
		return $this->apiKey;
	}

	/**
	 * Sets the setId
	 *
	 * @param string $setId The Item's setId.
	 * @return void
	 */
	protected function setSetId($setId) {
		$this->setId = trim($setId);
	}

	/**
	 * Returns the setId
	 *
	 * @return string $setId
	 */
	protected function getSetId() {
		return $this->setId;
	}

	/**
	 * Sets the setId
	 *
	 * @param array $settings The TS settings.
	 * @return void
	 */
	protected function setSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Returns the settings
	 *
	 * @return string $setId
	 */
	protected function getSettings() {
		return $this->settings;
	}
	
	/**
	 * Decides if a basic error has occured, this could be something like not adding the default TypoScript, or not setting a required TS property.
	 *
	 * @return void.
	 */
	protected function checkForBasicErrors() {
		$apiKey = $this->getApiKey();
		
		if (empty($apiKey)) {
			$this->basicError = 'key';
		} else {
			$setId = $this->getSetId();
			
			if (empty($setId)) {
				$this->basicError = 'setid';
			}
		}
	}



	/**
	 * Returns the settinsg parameters
	 *
	 * @param string $method The API Method to be used, i.e. getPhotos.
	 * @return array $methodParams The merged params for the API method.
	 */
	protected function getMethodParams($method) {
		$tsParams		= $this->settings['photosets'][$method];
		$methodParams	= array();
		
		if (!empty($tsParams)) {
			foreach($tsParams as $key => $value) {
				if (!empty($value) || $value == '0') {
					$methodParams[$key] = $value;
				}
			}
		}
		
			// Add other required params.
		$methodParams['format']			= 'php_serial';
		$methodParams['api_key']		= $this->getApiKey();
		$methodParams['photoset_id']	= $this->getSetId();
		
		return $methodParams;
	}
}
?>