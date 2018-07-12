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
 * A base model class containing functions/properties common to several models in sb_portfolio2
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Model_BaseRecord extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The record's title. Used in the FE and in table listings in the BE.
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * An alternative title for use in the FE.
	 *
	 * @var string
	 */
	protected $titlefull;

	/**
	 * An alternative title for use in the FE when space is restricted.
	 *
	 * @var string
	 */
	protected $titleshort;

	/**
	 * The record's creation date.
	 *
	 * @var DateTime
	 */
	protected $crdate;

	/**
	 * The date the record was last updated.
	 *
	 * @var DateTime
	 */
	protected $tstamp;

	/**
	 * The language uid of the record.
	 *
	 * @var integer
	 */
	protected $sysLanguageUid;

	/**
	 * The date the record should start being shown in the front end.
	 *
	 * @var DateTime
	 */
	protected $starttime;

	/**
	 * The date the record should stop being shown in the front end.
	 *
	 * @var DateTime
	 */
	protected $endtime;

	/**
	 * Is the record "hidden"?
	 *
	 * @var boolean
	 */
	protected $hidden;

	/**
	 * Is the record "deleted"?
	 *
	 * @var boolean
	 */
	protected $deleted;

	/**
	 * The uid of the user that created the record.
	 *
	 * @var integer
	 */
	protected $cruserId;

	/**
	 * The uid of the records translation parent.
	 *
	 * @var integer
	 */
	protected $l10nParent;



	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the titlefull
	 *
	 * @return string $titlefull
	 */
	public function getTitlefull() {
		return $this->titlefull;
	}

	/**
	 * Sets the titlefull
	 *
	 * @param string $titlefull
	 * @return void
	 */
	public function setTitlefull($titlefull) {
		$this->titlefull = $titlefull;
	}

	/**
	 * Returns the titleshort
	 *
	 * @return string $titleshort
	 */
	public function getTitleshort() {
		return $this->titleshort;
	}

	/**
	 * Sets the titleshort
	 *
	 * @param string $titleshort
	 * @return void
	 */
	public function setTitleshort($titleshort) {
		$this->titleshort = $titleshort;
	}

	/**
	 * Get crdate
	 *
	 * @return DateTime
	 */
	public function getCrdate() {
		return $this->crdate;
	}

	/**
	 * Set crdate
	 *
	 * @param DateTime $crdate The new crdate (creation date of the record).
	 * @return void
	 */
	public function setCrdate($crdate) {
		$this->crdate = $crdate;
	}

	/**
	 * Get tstamp
	 *
	 * @return DateTime
	 */
	public function getTstamp() {
		return $this->tstamp;
	}

	/**
	 * Set tstamp
	 *
	 * @param DateTime $tstamp The new tstamp (timestamp of last update).
	 * @return void
	 */
	public function setTstamp($tstamp) {
		$this->tstamp = $tstamp;
	}

	/**
	 * Get endtime
	 *
	 * @return DateTime
	 */
	public function getEndtime() {
		return $this->endtime;
	}

	/**
	 * Set endtime
	 *
	 * @param DateTime $endtime The new endtime.
	 * @return void
	 */
	public function setEndtime($endtime) {
		$this->endtime = $endtime;
	}

	/**
	 * Get starttime
	 *
	 * @return DateTime
	 */
	public function getStarttime() {
		return $this->starttime;
	}

	/**
	 * Set starttime
	 *
	 * @param DateTime $starttime The new starttime.
	 * @return void
	 */
	public function setStarttime($starttime) {
		$this->starttime = $starttime;
	}

	/**
	 * Get sysLanguageUid
	 *
	 * @return integer
	 */
	public function getSyslanguageuid() {
		return $this->sysLanguageUid;
	}

	/**
	 * Set sysLanguageUid
	 *
	 * @param integer $sysLanguageUid The new sysLanguageUid.
	 * @return void
	 */
	public function setSyslanguageuid($sysLanguageUid) {
		$this->sysLanguageUid = intval($sysLanguageUid);
	}

	/**
	 * Get cruserId
	 *
	 * @return integer
	 */
	public function getCruserId() {
		return $this->cruserId;
	}

	/**
	 * Set cruserId
	 *
	 * @param integer $cruserId The cruserId.
	 * @return void
	 */
	public function setCruserId($cruserId) {
		$this->cruserId = intval($cruserId);
	}

	/**
	 * Get hidden
	 *
	 * @return integer
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Set hidden
	 *
	 * @param integer $hidden The hidden value of the record.
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Get deleted
	 *
	 * @return integer
	 */
	public function getDeleted() {
		return $this->deleted;
	}

	/**
	 * Set deleted
	 *
	 * @param integer $deleted The deleted value of the record.
	 * @return void
	 */
	public function setDeleted($deleted) {
		$this->deleted = $deleted;
	}

	/**
	 * Get l10nParent
	 *
	 * @return integer
	 */
	public function getL10nparent() {
		return $this->l10nParent;
	}

	/**
	 * Set l10nParent
	 *
	 * @param integer $l10nParent The new l10n_parent.
	 * @return void
	 */
	public function setL10nparent($l10nParent) {
		$this->l10nParent = intval($l10nParent);
	}
}
?>