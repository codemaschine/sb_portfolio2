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
 * A repository class containing functions common to several repositories in sb_portfolio2
 * Contains functions to find a record's next/previous records.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Repository_NpRecordRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Finds the single view's record's next record
	 *
	 * @param array $recordData Record data used for getting the next record (uid, datetime, crdate)
	 * @param string $field The field to use when getting the next record.
	 * @return mixed A record object or null
	 */
	public function findNext($recordData, $field = 'uid') {
		if ($field != 'uid' && $field != 'datetime' && $field != 'crdate') { // If not allowed field, set it to uid
			$field = 'uid';
		}

		$value	= $recordData[$field];
		$query	= $this->createQuery();

		if ($field == 'datetime' || $field != 'crdate') {
			$value = $recordData[$field]->getTimestamp();

			$query->matching(
				$query->logicalAnd(
					$query->greaterThanOrEqual($field, $value),
					$query->logicalNot($query->equals('uid', $recordData['uid']))
				)
			);

		} else {
			$query->matching($query->greaterThan($field, $value));
		}

		$next = $query->setOrderings(array($field => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING))
					->setLimit(1)->execute();

		if (count($next) < 1) {
			return NULL;

		} else {
			return $next->getFirst();
		}
	}

	/**
	 * Finds the single view's record's previous record
	 *
	 * @param array $recordData Record data used for getting the previous record (uid, datetime)
	 * @param string $field The field to use when getting the previous record.
	 * @return mixed A record object or null
	 */
	public function findPrevious($recordData, $field = 'uid') {
		if ($field != 'uid' && $field != 'datetime' && $field != 'crdate') { // If not allowed field, set it to uid
			$field = 'uid';
		}

		$query	= $this->createQuery();
		$value	= $recordData[$field];

		if ($field == 'datetime' || $field != 'crdate') {
			$value = $recordData[$field]->getTimestamp();

			$query->matching($query->logicalAnd($query->lessThanOrEqual($field, $value), $query->logicalNot($query->equals('uid', $recordData['uid']))));

		} else {
			$query->matching($query->lessThan($field, $value));
		}

		$previous = $query->setOrderings(array($field => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING))
						->setLimit(1)->execute();

		if (count($previous) < 1) {
			return NULL;

		} else {
			return $previous->getFirst();
		}
	}
}
?>