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
 * ViewHelper to sort an array by the element objects titles.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_SortTitleViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Returns $records, sorted by title. Used to sort tags, categories etc.
	 *
	 * @param mixed $records The array to be sorted.
	 * @param string Sdir The direction to sort $records by.
	 * @param integer $crop The number of characters to crop the title too (used only for the keys).
	 * @return array $records, sorted (or not).
	 */
	public function render($records, $dir = 'asc', $crop = 30) {
		if (is_array($records) || is_object($records)) {
			$dir		= strtolower($dir);
			$crop		= intval($crop);
			$newRecords	= array();
			
			foreach ($records as $record) {
				$title = str_replace(' ', '_', strtolower($record->getTitle()));
				
				if ($crop >= 1) {
					$title = substr($title, 0, $crop);
				}
				
				$newRecords[$title] = $record;
			}
			
			if (!empty($newRecords)) {
				if ($dir == 'desc') {
					krsort($newRecords);
					
				} else {
					ksort($newRecords);
				}
				
				$records = $newRecords;
				
				unset($newRecords);
			}
		}
		
		return $records;
	}
}
?>