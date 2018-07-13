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
 *  * ViewHelper for getting title. Defaults to the record's title, or if set the full title. If titleshort is set, this is returned instead. 
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_TitleViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	
	/**
	 * Outputs the title for an item.
	 *
	 * @param object $record The current record
	 * @param boolean $short Should titleshort be used, if set?
	 * @return string $title The title text.
	 */
	public function render($record, $short = FALSE) {
		$title = '';
		
		if (is_object($record)) {
			$title		= $record->getTitle();
			$titleFull	= $record->getTitlefull();
			
			if (!empty($titleFull)) {
				$title = $titleFull;
			}
			
			if ($short) {
				$titleShort	= $record->getTitleshort();
				
				if (!empty($titleShort)) {
					$title = $titleShort;
				}
			}
		}
		
		return $title;
	}
}
?>