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
 * ViewHelper for detecting if filtering is occuring (either via tag, client, or category)
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class FilteringViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Returns true if the passed uid is found,
	 *
	 * @param string $name The name of the getvar: tx_sbportfolio2_sbp2fe1[$name]
	 * @param string $comparison The id of the current tag/category/client that should be compared with the get var
	 * @return boolean true or false.
	 */
	public function render($name, $comparison) {
		$itemVars = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_sbportfolio2_items');

		if (isset($itemVars[$name])) {
			$itemVars = $itemVars[$name];

			if (intval($itemVars) == intval($comparison)) {
				return true;
			}
		}

		return false;
	}
}
?>
