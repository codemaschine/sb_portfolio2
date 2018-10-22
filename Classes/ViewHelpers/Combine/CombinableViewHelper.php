<?php

namespace StephenBungert\SbPortfolio2\ViewHelpers\Combine;

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
 * A base ViewHelper for various combining ViewHelpers.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class CombinableViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The type of combinable record: tag, file, or link.
	 *
	 * @var string
	 */
	protected $combineRecType = '';

	/**
	 * The combined combinable records from an Item/Client record and their Categry record.
	 *
	 * @var array
	 */
	protected $combinedRecords = array();

	/**
	 * The Item's/Client's category records.
	 *
	 * @var ArrayObject
	 */
	protected $categories;

	/**
	 * The Item's/Client's combinable records.
	 *
	 * @var ArrayObject
	 */
	protected $combinableRecords = array();

	/**
	 * The Item's/Client's combinable records.
	 *
	 * @var ArrayObject
	 */
	protected $recordClass;

	/**
	 * Processes needed by all combine VH's.
	 *
	 * @param object $record the record with records that need combining.
	 * @return Void
	 */
	public function combineRecords($record) {
		$this->recordClass			= get_class($record);

		if ($this->recordClass != 'Tx_SbPortfolio2_Domain_Model_Category') {
			$this->categories = $record->getCategories();
		}

		$this->setCombinedRecords($record);
	}

	/**
	 * Sets $combinedRecords with $combinableRecords.
	 *
	 * @param object $record the record with records that need combining.
	 * @return Void
	 */
	public function setCombinedRecords($record) {
		if (!empty($this->combinableRecords)) {
			foreach ($this->combinableRecords as $rec) {
				$recUid = $rec->getUid();

				$this->combinedRecords[$recUid] = $rec;

				if ($this->recordClass == 'Tx_SbPortfolio2_Domain_Model_Client') {
					$this->combinedRecords[$recUid]->setClientRecord(true);

				} else { // Assume 'Tx_SbPortfolio2_Domain_Model_Item'
					$this->combinedRecords[$recUid]->setItemRecord(true);
				}
			}
		}

			// Get category combinable records
		if (!empty($this->categories)) {
			foreach ($this->categories as $cat) {
				$categoryRecs = array();

				if ($this->combineRecType == 'file') {
					$categoryRecs = $cat->getFiles();

				} else if ($this->combineRecType == 'link') {
					$categoryRecs = $cat->getLinks();

				} else if ($this->combineRecType == 'tag') {
					$categoryRecs = $cat->getTags();

				} else if ($this->combineRecType == 'item') {
					$categoryRecs = $cat->getRelateditems();
				}

				if (!empty($categoryRecs)) {
						// Get each category's files
					foreach ($categoryRecs as $catRec) {
						$recUid = $catRec->getUid();

							// Add the file if not already found in the record's files
						if (!isset($this->combinedRecords[$recUid])) {
							$this->combinedRecords[$recUid] = $catRec;
						}

						$this->combinedRecords[$recUid]->setCatRecord(true);

							// Store for later reuse
						$record->setCombinedRecords($this->combinedRecords, $this->combineRecType);
					}
				}
			}
		}
	}
}
?>
