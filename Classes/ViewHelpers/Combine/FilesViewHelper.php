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
 * ViewHelper for combining an item/a client record's files with catgeory files.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_Combine_FilesViewHelper extends Tx_SbPortfolio2_ViewHelpers_Combine_CombinableViewHelper {

	/**
	 * Returns a record's files combined with the record's categories' files.
	 *
	 * @param mixed $record The current object: could be an item, a client etc.
	 * @return array The combined Files.
	 */
	public function render($record) {
		$this->combineRecType		= 'file';
		$alreadyCombinedRecords	= $record->getCombinedRecords($this->combineRecType);
		
		if ($alreadyCombinedRecords) {
			return $alreadyCombinedRecords;
			
		} else {
			$this->combinableRecords	= $record->getFiles();
			
			$this->combineRecords($record);
			
			return $this->combinedRecords;
		}
	}
}
?>