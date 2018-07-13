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
 *  * ViewHelper for getting a testimonial's parent item/client record.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_TestimonialParentViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	
	/**
	 * What type of record is this a testimonial for? Either "item", or "client".
	 *
	 * @var string
	 */
	protected $testimonialType = '';
	
	/**
	 * Returns the testimonial parent record.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial The current testimonial record
	 * @return mixed $parentRecord The testimonial parent record or NULL.
	 */
	public function render(Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial) {
		$parentRecord = NULL;
		
			// See if this testimonial is for an item
		$parentId = $testimonial->getItem();
		
		if ($parentId == 0) { // Not an item.
				// Then see if this testimonial is for a client
			$parentId = $testimonial->getClient();
			
			if ($parentId >= 1) { // Yes it is.
				$this->testimonialType = 'Client';
			}
			
		} else { // An item.
			$this->testimonialType = 'Item';
		}
		
		if ($parentId >= 1) {
			$repository		= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_SbPortfolio2_Domain_Repository_' . $this->testimonialType .'Repository');
			$parentRecord	= $repository->findByUid($parentId);
		}
		
		return $parentRecord;
	}
}
?>