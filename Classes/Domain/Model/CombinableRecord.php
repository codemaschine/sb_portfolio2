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
 * that can be combined (a core record's combinable records and the core record's categories' combinable records)
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Model_CombinableRecord extends Tx_SbPortfolio2_Domain_Model_BaseRecord {
	/**
	 * Is this record a category record. Used to set classes for combinable records with the
	 * Classes VH and the combine VH's.
	 *
	 * @var boolean
	 */
	protected $catRecord;
	
	/**
	 * Is this record an item record. Used to set classes for combinable records with the
	 * Classes VH and the combine VH's.
	 *
	 * @var boolean
	 */
	protected $itemRecord;
	
	/**
	 * Is this record a client record. Used to set classes for combinable records with the
	 * Classes VH and the combine VH's.
	 *
	 * @var boolean
	 */
	protected $clientRecord;

	/**
	 * Returns catRecord
	 *
	 * @return boolean catRecord
	 */
	public function getCatRecord() {
		return $this->catRecord;
	}

	/**
	 * Sets catRecord
	 *
	 * @param boolean $catRecord
	 */
	public function setCatRecord($catRecord) {
		if (is_bool($catRecord))
		{
			$this->catRecord = $catRecord;
		}
	}

	/**
	 * Returns the boolean state of catRecord
	 *
	 * @return boolean catRecord
	 */
	public function isCatRecord() {
		return $this->getCatRecord();
	}

	/**
	 * Returns itemRecord
	 *
	 * @return boolean itemRecord
	 */
	public function getItemRecord() {
		return $this->itemRecord;
	}

	/**
	 * Sets itemRecord
	 *
	 * @param boolean $itemRecord
	 */
	public function setItemRecord($itemRecord) {
		if (is_bool($itemRecord))
		{
			$this->itemRecord = $itemRecord;
		}
	}

	/**
	 * Returns the boolean state of itemRecord
	 *
	 * @return boolean itemRecord
	 */
	public function isItemRecord() {
		return $this->getItemRecord();
	}

	/**
	 * Returns clientRecord
	 *
	 * @return boolean clientRecord
	 */
	public function getClientRecord() {
		return $this->clientRecord;
	}

	/**
	 * Sets clientRecord
	 *
	 * @param boolean clientRecord
	 */
	public function setClientRecord($clientRecord) {
		if (is_bool($clientRecord))
		{
			$this->clientRecord = $clientRecord;
		}
	}

	/**
	 * Returns the boolean state of clientRecord
	 *
	 * @return boolean clientRecord
	 */
	public function isClientRecord() {
		return $this->getClientRecord();
	}
}
?>