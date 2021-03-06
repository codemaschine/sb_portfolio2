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
 * ViewHelper for combining an item/a client record's tags with catgeory tags.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class TagsViewHelper extends CombinableViewHelper {

	/**
	 * Returns a record's tags combined with the record's categories' tags.
	 *
	 * @param mixed $record The current object: could be an item, a client etc.
	 * @return array The combined Tags.
	 */
	public function render($record) {
		$this->combineRecType	= 'tag';
		$alreadyCombinedRecords	= $record->getCombinedRecords($this->combineRecType);

		if ($alreadyCombinedRecords) {
			return $alreadyCombinedRecords;

		} else {
			$this->combinableRecords = $record->getTags();

			$this->combineRecords($record);

			return $this->combinedRecords;
		}
	}
}
?>
