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
 *  ViewHelper for getting the description of a record for SEO purposes. 
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_Meta_DescriptionViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Outputs the seo description for an item.
	 *
	 * @param object $record The current record.
	 * @param boolean $useFulldescription Use the fulldescription field if the summary field is empty.
	 * @param integer $crop The number of characters to crop when using fulldescription as the description.
	 * @param boolean $word Should the crop be made to a whole word?
	 * @param string $indicator The crop mark to be used, defaults to ellipsis.
	 * @return string $description The title text.
	 */
	public function render($record, $useFulldescription = TRUE, $crop = 300, $word = TRUE, $indicator = '...') {
		$description = '';
		
		if (is_object($record)) {
			$description = $record->getSummary();
			
			if ($useFulldescription) {
				$fullDescription = $record->getFulldescription();
				
				if (!empty($fullDescription)) {
					$fullDescription	= strip_tags($fullDescription); // Remove HTML
					$crop				= intval($crop);
					
					if ($crop >= 1) {
						if (!is_string($indicator)) {
							$indicator = '...';
						}
						
						$description = $this->cropValue($fullDescription, $crop, $word, $indicator);
					}
				}
			}
		}
		
		return $description;
	}
	
	/**
	 * Crops $value.
	 *
	 * @param string $value The field value to be stripped and cropped.
	 * @param integer $crop The number of characters to crop $fullDescription by.
	 * @param boolean $wordCropRequired Should the crop be made to a whole word?
	 * @param string $indicator The crop mark to be used, defaults to ellipsis.
	 * @return string $value $value, cropped and with all HTML removed.
	 */
	function cropValue($value, $crop, $wordCropRequired, $indicator) {
		$originalValue	= $value;
		$hasSpaces		= strpos($value, ' ');
		$crop			= ($crop - strlen(utf8_decode($indicator))); // - $indicator length.
		
		if ($crop >= 1) { // Maybe crop is now negative, so check first!
			$value = substr($value, 0, $crop); // Crop
			
			if ($hasSpaces && $wordCropRequired) { // Crop to whole word
				$lastSpacePos		= strrpos($value, ' ');
				$firstCroppedChar	= substr($originalValue, $crop - 1, 1);
				
				// If there is a space in the cropped string, and the cropped string wasn't by chance cropped to a space
				if ($lastSpacePos !== FALSE && (!empty($firstCroppedChar) && $firstCroppedChar != ' ')) {
					$value = substr($value, 0, $lastSpacePos);
				}
			}
			
			$value .= $indicator;
		}
		
		return $value;
	}
}
?>