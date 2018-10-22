<?php

namespace StephenBungert\SbPortfolio2\ViewHelpers;

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
 *  * ViewHelper for getting the current record's next/previous records.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class NextPreviousViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Returns the next or previous record.
	 *
	 * @param string $npType The type of next/previous record: either 'next' or 'previous'.
	 * @param string $recordType The type of record to be collected, ie: 'item'. This should be the keypart of the repo name so that the repo class string can be built (see below).
	 * @param string $npField The field used to determine the next record: either "uid", "crdate", or "datetime" (not for cats).
	 * @param string $uid The current record's uid.
	 * @param mixed $datetime The current record's datetime/crdate.
	 * @return mixed $npRecord NULL or the next/previous record.
	 */
	public function render($npType, $recordType, $npField, $uid, $datetime) {
		$recData = array(
			'uid'		=> $uid,
			$npField	=> $datetime,
		);

		$recordType = ucfirst($recordType);

		$repository	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_SbPortfolio2_Domain_Repository_' . $recordType .'Repository');
		$npRecord	= NULL;

		if ($npType == 'next') {
			$npRecord = $repository->findNext($recData, $npField);

		} else if ($npType == 'previous') {
			$npRecord = $repository->findPrevious($recData, $npField);
		}

		unset($repository);

		return $npRecord;
	}
}
?>
