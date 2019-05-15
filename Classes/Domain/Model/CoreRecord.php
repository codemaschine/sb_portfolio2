<?php
namespace StephenBungert\SbPortfolio2\Domain\Model;
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
 * A base model class containing functions/properties common to several models in sb_portfolio2
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class CoreRecord extends BaseRecord {

	/**
	 * A short summary of the record.
	 *
	 * @var string
	 */
	protected $summary;

	/**
	 * The record's full description, this can include links and images.
	 *
	 * @var string
	 */
	protected $fulldescription;

	/**
	 * The record's title for SEO metatags.
	 *
	 * @var string
	 */
	protected $seoTitle;

	/**
	 * The record's type for SEO metatags.
	 *
	 * @var string
	 */
	protected $seoType;

	/**
	 * The record's description for SEO metatags.
	 *
	 * @var string
	 */
	protected $seoDescription;

	/**
	 * The records's image for SEO metatags.
	 *
	 * @var string
	 */
	protected $seoImage;

	/**
	 * The item's Facebook Application ID.
	 *
	 * @var string
	 */
	protected $seoFbappid;

	/**
	 * The item's Facebook Admin IDs.
	 *
	 * @var string
	 */
	protected $seoFbadmins;

	/**
	 * Keeps combined records for reuse (records like tags combined with the combine.tags viewhelper for example)
	 *
	 * @var array
	 */
	protected $combinedRecords = array();

	/**
	 * The original sb_portfolio record uid, only set for records that have been imported.
	 *
	 * @var integer
	 */
	protected $sbpuid;



	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
	}




	/**
	 * Returns combinedRecords[combinedRecordType]
	 *
	 * @param string $combinedRecordType The type of combined records (tags for example).
	 * @return string $combinedRecords
	 */
	public function getCombinedRecords($combinedRecordType) {
		if (is_string($combinedRecordType) && isset($this->combinedRecords[$combinedRecordType])) {
			return $this->combinedRecords[$combinedRecordType];
		}

		return NULL;
	}

	/**
	 * Sets combinedRecords[combinedRecordType]
	 *
	 * @param array $combinedRecords The records that have been combined.
	 * @param string $combinedRecordType The type of combined records (tags for example).
	 * @return void
	 */
	public function setCombinedRecords(array $combinedRecords, $combinedRecordType) {
		if (is_string($combinedRecordType)) {
			$this->combinedRecords[$combinedRecordType] = $combinedRecords;
		}
	}

	/**
	 * Returns the summary
	 *
	 * @return string $summary
	 */
	public function getSummary() {
		return $this->summary;
	}

	/**
	 * Sets the summary
	 *
	 * @param string $summary
	 * @return void
	 */
	public function setSummary($summary) {
		$this->summary = $summary;
	}

	/**
	 * Returns the fulldescription
	 *
	 * @return string $fulldescription
	 */
	public function getFulldescription() {
		return $this->fulldescription;
	}

	/**
	 * Sets the fulldescription
	 *
	 * @param string $fulldescription
	 * @return void
	 */
	public function setFulldescription($fulldescription) {
		$this->fulldescription = $fulldescription;
	}

	/**
	 * Returns seoTitle
	 *
	 * @return string $seoTitle
	 */
	public function getSeoTitle() {
		return $this->seoTitle;
	}

	/**
	 * Sets seoTitle
	 *
	 * @param string $seoTitle
	 * @return void
	 */
	public function setSeoTitle($seoTitle) {
		$this->seoTitle = $seoTitle;
	}

	/**
	 * Returns seoDescription
	 *
	 * @return string $seoDescription
	 */
	public function getSeoDescription() {
		return $this->seoDescription;
	}

	/**
	 * Sets seoDescription
	 *
	 * @param string $seoDescription
	 * @return void
	 */
	public function setSeoDescription($seoDescription) {
		$this->seoDescription = $seoDescription;
	}

	/**
	 * Returns seoImage
	 *
	 * @return string $seoImage
	 */
	public function getSeoImage() {
		return $this->seoImage;
	}

	/**
	 * Sets the seoImage
	 *
	 * @param string $seoImage
	 * @return void
	 */
	public function setSeoImage($seoImage) {
		$this->seoImage = $seoImage;
	}

	/**
	 * Returns seoType
	 *
	 * @return string $seoType
	 */
	public function getSeoType() {
		return $this->seoType;
	}

	/**
	 * Sets seoType
	 *
	 * @param string $seoType
	 * @return void
	 */
	public function setSeoType($seoType) {
		$this->seoType = $seoType;
	}

	/**
	 * Returns seoFbappid
	 *
	 * @return string $seoFbappid
	 */
	public function getSeoFbappid() {
		return $this->seoFbappid;
	}

	/**
	 * Sets seoFbappid
	 *
	 * @param string $seoFbappid
	 * @return void
	 */
	public function setSeoFbappid($seoFbappid) {
		$this->seoFbappid = $seoFbappid;
	}

	/**
	 * Returns seoFbadmins
	 *
	 * @return string $seoFbadmins
	 */
	public function getSeoFbadmins() {
		return $this->seoFbadmins;
	}

	/**
	 * Sets seoFbadmins
	 *
	 * @param string $seoFbadmins
	 * @return void
	 */
	public function setSeoFbadmins($seoFbadmins) {
		$this->seoFbadmins = $seoFbadmins;
	}

	/**
	 * Returns sbpuid
	 *
	 * @return integer $sbpuid
	 */
	public function getSbpuid() {
		return $this->sbpuid;
	}

	/**
	 * Sets sbpuid
	 *
	 * @param integer $sbpuid
	 * @return void
	 */
	public function setSbpuid($sbpuid) {
		$this->sbpuid = intval($sbpuid);
	}
}
?>
