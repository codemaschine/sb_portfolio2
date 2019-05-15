<?php
namespace StephenBungert\SbPortfolio2\Domain\Flickr;
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
use \StephenBungert\SbPortfolio2\Domain\Flickr\Authorisation;

/**
 * A class to contact flickr and get images.
 *
 * Code based on flickrimages code.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Flickr extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The base url for API queries.
	 *
	 * @var string
	 */
	const BASE_URL = 'http://api.flickr.com/services/rest/';

	/**
	 * Possible values for the sort property
	 *
	 * @var string
	 */
	const SORT_OPTIONS = 'date-posted-asc,date-posted-desc,date-taken-asc,date-taken-desc,interestingness-desc,interestingness-asc,relevance';



	/**
	 * An Instance of Tx_Flickrimages_Domain_Model_Authorisation_OAuth
	 *
	 * @var Tx_Flickrimages_Domain_Model_Authorisation_OAuth
	 */
	protected $oAuth;

	 /**
	 * An array of parameters for the API method to be used. These are set in TS / FF.
	 *
	 * @var array
	 */
	protected $methodParams;

	/**
	 * The current API method to be invoked.
	 *
	 * @var string
	 */
	protected $currentMethod;



	/**
	 * __construct
	 *
	 * @param string $apiKey The Flickr API Key for your app.
	 * @return void
	 */
	public function __construct($apiKey) {
		$this->oAuth = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\StephenBungert\SbPortfolio2\Domain\Flickr\Authorisation\OAuth', $apiKey);
	}



	/**
	 * Returns currentMethod
	 *
	 * @return string $currentMethod
	 */
	public function getCurrentMethod() {
		return $this->currentMethod;
	}

	/**
	 * Sets currentMethod
	 *
	 * @param string $currentMethod The current API method to be invoked.
	 * @return void
	 */
	public function setCurrentMethod($currentMethod) {
		$this->currentMethod = $currentMethod;
	}

	/**
	 * Sets methodParams
	 *
	 * @param array $methodParams The TS params for the API method to be used
	 * @return void
	 */
	protected function setMethodParams(array $methodParams) {
		$this->methodParams = $this->cleanMethodParams($methodParams);
	}

	/**
	 * Returns methodParams
	 *
	 * @return array $methodParams
	 */
	protected function getMethodParams() {
		return $this->methodParams;
	}



	/**
	 * Does things that are  required for every method.
	 *
	 * @param array $methodParams The params for this method.
	 * @return array $queryResult
	 */
	public function prepMethod(array $methodParams) {
		$this->setCurrentMethod($methodParams['method']);
		$this->setMethodParams($methodParams);
	}

	/**
	 * Calls the flickr.photosets.getPhotos Method from the Flickr API.
	 *
	 * @param array $methodParams The params for this method.
	 * @return array $queryResult
	 */
	public function getPhotos(array $methodParams) {
		$this->prepMethod($methodParams);

		return $this->getQueryResult();
	}

	/**
	 * Calls the flickr.photosets.getInfo Method from the Flickr API.
	 *
	 * @param array $methodParams The params for this method.
	 * @return array $queryResult
	 */
	public function getInfo(array $methodParams) {
		$this->prepMethod($methodParams);

		return $this->getQueryResult();
	}

	/**
	 * Calls the flickr.photos.search Method from the Flickr API.
	 *
	 * @param array $methodParams The params for this method.
	 * @return array $queryResult
	 */
	public function search(array $methodParams) {
		$this->prepMethod($methodParams);

		return $this->getQueryResult();
	}



	/**
	 * Checks and changes params so that illegal values are not provided, or false param combinations
	 *
	 * @param array $methodParams The params for checking
	 * @return array $newParams $methodParams cleaned of invalid values or false combinations of values.
	 */
	protected function cleanMethodParams(array $methodParams) {
		$newParams	= array();
		$method		= $this->getCurrentMethod();

			# Will always need thses
		if ($methodParams['api_key']) {
			$newParams['api_key'] = trim($methodParams['api_key']);
		}

		if ($methodParams['method']) {
			$newParams['method'] = trim($methodParams['method']);
		}

		if ($methodParams['format']) {
			$newParams['format'] = trim($methodParams['format']);
		}

		switch ($method) {
			case 'flickr.photosets.getPhotos':
				if ($methodParams['photoset_id']) {
					$newParams['photoset_id'] = trim($methodParams['photoset_id']);
				}

				if (!empty($methodParams['extras'])) {
					$newParams['extras'] = trim($methodParams['extras']);
				}

				if ($this->numericParamIsValid($methodParams['per_page']) && intval($methodParams['per_page']) <= 500) {
					$newParams['per_page'] = intval($methodParams['per_page']);

				} else {
					$newParams['per_page'] = 500; // Set default
				}

				if ($this->numericParamIsValid($methodParams['page'])) {
					$newParams['page'] = intval($methodParams['page']);

				} else {
					$newParams['page'] = 1; // Set default
				}

				if (!empty($methodParams['media'])) {
					$methodParams['media'] = strtolower(trim($methodParams['media']));

					if ($methodParams['media'] == 'photos' || $methodParams['media'] == 'videos') {
						$newParams['media'] = $methodParams['media'];
					}
				}

					if (!isset($newParams['media'])) {
						$newParams['media'] = 'all'; // Set default
					}

			break;

			case 'flickr.photosets.getInfo':
				if ($methodParams['photoset_id']) {
					$newParams['photoset_id'] = trim($methodParams['photoset_id']);
				}

			case 'flickr.photos.search':
				if ($methodParams['user_id']) {
					$newParams['photoset_id'] = trim($methodParams['photoset_id']);
				}

				if (!empty($methodParams['tags'])) {
					$newParams['tags'] = trim($methodParams['tags']);
				}

				if (!empty($methodParams['tag_mode'])) {
					$methodParams['tag_mode'] = strtolower(trim($methodParams['tag_mode']));

					if ($methodParams['tag_mode'] == 'all') {
						$newParams['tag_mode'] = $methodParams['tag_mode'];
					}
				}

					if (!isset($newParams['tag_mode'])) {
						$newParams['tag_mode'] = 'any'; // Set default
					}

				if (!empty($methodParams['text'])) {
					$newParams['text'] = trim($methodParams['text']);
				}

				if (!empty($methodParams['min_upload_date'])) {
					$newParams['min_upload_date'] = trim($methodParams['min_upload_date']);
				}

				if (!empty($methodParams['max_upload_date'])) {
					$newParams['max_upload_date'] = trim($methodParams['max_upload_date']);
				}

				if (!empty($methodParams['min_taken_date'])) {
					$newParams['min_taken_date'] = trim($methodParams['min_taken_date']);
				}

				if (!empty($methodParams['max_taken_date'])) {
					$newParams['max_taken_date'] = trim($methodParams['max_taken_date']);
				}

				if (!empty($methodParams['license'])) {
					$newParams['license'] = trim($methodParams['license']);
				}

				if (!empty($methodParams['sort'])) {
					$methodParams['sort'] = trim($methodParams['sort']);

					if (strpos(self::SORT_OPTIONS, $methodParams['sort']) !== FALSE) {
						$newParams['sort'] = $methodParams['sort'];
					}
				}

				if ($this->numericParamIsValid($methodParams['accuracy'])) {
					$methodParams['accuracy'] = intval($methodParams['accuracy']);

					if ($methodParams['accuracy'] <= 16) {
						$newParams['accuracy'] = $methodParams['accuracy'];
					}
				}

				if ($this->numericParamIsValid($methodParams['content_type'])) {
					$methodParams['content_type'] = intval($methodParams['content_type']);

					if ($methodParams['content_type'] <= 7) {
						$newParams['content_type'] = $methodParams['content_type'];
					}
				}

				if (!empty($methodParams['machine_tags'])) {
					$newParams['machine_tags'] = trim($methodParams['machine_tags']);
				}

				if (!empty($methodParams['machine_tag_mode'])) {
					$methodParams['machine_tag_mode'] = strtolower(trim($methodParams['machine_tag_mode']));

					if ($methodParams['machine_tag_mode'] == 'all') {
						$newParams['machine_tag_mode'] = $methodParams['machine_tag_mode'];
					}
				}

					if (!isset($newParams['machine_tag_mode'])) {
						$newParams['machine_tag_mode'] = 'any'; // Set default
					}

				if (!empty($methodParams['group_id'])) {
					$newParams['group_id'] = intval($methodParams['group_id']);
				}

				if (!empty($methodParams['woe_id'])) {
					$newParams['woe_id'] = trim($methodParams['woe_id']);
				}

				if (!empty($methodParams['place_id'])) {
					$newParams['place_id'] = trim($methodParams['place_id']);
				}

				if (!empty($methodParams['media'])) {
					$methodParams['media'] = strtolower(trim($methodParams['media']));

					if ($methodParams['media'] == 'photos' || $methodParams['media'] == 'videos') {
						$newParams['media'] = $methodParams['media'];
					}
				}

					if (!isset($newParams['media'])) {
						$newParams['media'] = 'all'; // Set default
					}

				if (!empty($methodParams['has_geo'])) {
					$methodParams['has_geo'] = strtolower(trim($methodParams['has_geo']));

					if ($methodParams['has_geo'] == 'true' || is_numeric($methodParams['has_geo']) && intval($methodParams['has_geo']) == '1') {
						$newParams['has_geo'] = 1;

					} else {
						$newParams['has_geo'] = 0;
					}
				}

				if ($this->numericParamIsValid($methodParams['geo_context'])) {
					$methodParams['geo_context'] = intval($methodParams['geo_context']);

					if ($methodParams['geo_context'] <= 3) {
						$newParams['geo_context'] = $methodParams['geo_context'];
					}
				}

				if (!empty($methodParams['lat'])) {
					$newParams['lat'] = trim($methodParams['lat']);
				}

				if (!empty($methodParams['lon'])) {
					$newParams['lon'] = trim($methodParams['lon']);
				}

				if (!empty($methodParams['radius_units'])) {
					$methodParams['radius_units'] = strtolower(trim($methodParams['radius_units']));

					if ($methodParams['radius_units'] == 'mi') {
						$newParams['radius_units'] = $methodParams['radius_units'];
					}
				}

					if (!isset($newParams['radius_units'])) {
						$newParams['radius_units'] = 'km'; // Set default
					}

				if ($this->numericParamIsValid($methodParams['radius'])) {
					$methodParams['radius'] = intval($methodParams['radius']);

					if ($newParams['radius_units'] == 'mi' && $methodParams['radius'] <= 20) {
						$newParams['radius'] = $methodParams['radius'];

					} else if ($newParams['radius_units'] == 'km' && $methodParams['radius'] <= 32) {
						$newParams['radius'] = $methodParams['radius'];
					}
				}

					if (!isset($newParams['radius'])) {
						$newParams['radius'] = 5; // Set default
					}

				if (!empty($methodParams['is_commons'])) {
					$methodParams['is_commons'] = strtolower(trim($methodParams['is_commons']));

					if ($methodParams['is_commons'] == 'true' || is_numeric($methodParams['is_commons']) && intval($methodParams['is_commons']) == '1') {
						$newParams['is_commons'] = 1;

					} else {
						$newParams['is_commons'] = 0;
					}
				}

				if (!empty($methodParams['in_gallery'])) {
					$methodParams['in_gallery'] = strtolower(trim($methodParams['in_gallery']));

					if ($methodParams['in_gallery'] == 'true' || is_numeric($methodParams['in_gallery']) && intval($methodParams['in_gallery']) == '1') {
						$newParams['in_gallery'] = 1;

					} else {
						$newParams['in_gallery'] = 0;
					}
				}

				if (!empty($methodParams['is_getty'])) {
					$methodParams['is_getty'] = strtolower(trim($methodParams['is_getty']));

					if ($methodParams['is_getty'] == 'true' || is_numeric($methodParams['is_getty']) && intval($methodParams['is_getty']) == '1') {
						$newParams['is_getty'] = 1;

					} else {
						$newParams['is_getty'] = 0;
					}
				}

				if (!empty($methodParams['extras'])) {
					$newParams['extras'] = trim($methodParams['extras']);
				}

				if ($this->numericParamIsValid($methodParams['per_page']) && intval($methodParams['per_page']) <= 500) {
					$newParams['per_page'] = intval($methodParams['per_page']);

				} else {
					$newParams['per_page'] = 500; // Set default
				}

				if ($this->numericParamIsValid($methodParams['page'])) {
					$newParams['page'] = intval($methodParams['page']);

				} else {
					$newParams['page'] = 1; // Set default
				}

			break;

			default:
			break;
		}

		return $newParams;
	}

	/**
	 * Checks if a numeric param is greater than or equal to 1.
	 * Optionally, 0 can also be a valid value.
	 *
	 * @param string $param The param for checking
	 * @param boolean $zeroAllowed Is zero a valid value?
	 * @return boolean $isValid Is the $param valid? TRUE or FALSE.
	 */
	protected function numericParamIsValid($param, $zeroAllowed = FALSE)  {
		$isValid = FALSE;

		if (trim($param) == '0' && $zeroAllowed) {
			$isValid = TRUE;

		} else {
			if (!empty($param)) {
				$param = intval($param);

				if ($param >= 1) {
					$isValid = TRUE;
				} // Else, if it is now 0, it is not valid because it was obviously not a number, but some other value like a string
			}
		}

		return $isValid;
	}

	/**
	 * Executes the API method and processes the results.
	 *
	 * @return array $queryResult The response from flickr, processed for fluid
	 */
	protected function getQueryResult() {
		$queryResult = $this->executeMethod();

		if (!empty($queryResult['data']))
		{
			$queryResult['data'] = unserialize($queryResult['data']);
		}

		if ($queryResult['data']['stat'] == 'ok') {
			$queryResult['error'] = 0;

		} else {
			$queryResult['error'] = 1;
		}


		return $queryResult;
	}

	/**
	 * Starts oAuth and query Flickr
	 *
	 * @return array
	 */
	public function executeMethod() {
		$this->oAuth->prepare($this->getMethodParams());
		return $this->oAuth->go(self::BASE_URL);
	}
}
?>
