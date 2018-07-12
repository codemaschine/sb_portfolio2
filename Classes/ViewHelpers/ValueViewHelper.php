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
 *  ViewHelper for deciding on the which of mutiple values to be used for something (like a tag attribute)
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_ValueViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * Returns the value to be used for something, selects one of upto four values.
	 * $val1 is used, and then the other $Val... arguments are checked to see if they contain anything.
	 * If they do, then these values are used instead.
	 *
	 * @param string $val1 The default value.
	 * @param string $val2 A possible override value $val1.
	 * @param string $val3 A possible override value $val1.
	 * @param string $val4 A possible override value $val1.
	 * @return string $finalValue The value to be used.
	 */
	public function render($val1, $val2 = '', $val3 = '', $val4 = '') {
		$finalValue	= trim($val1);
		$val2		= trim($val2);
		$val3		= trim($val3);
		$val4		= trim($val4);
		
		if (!empty($val4)) {
			$finalValue = $val4;
			
		} else if (!empty($val3)) {
			$finalValue = $val3;
			
		} else if (!empty($val2)) {
			$finalValue = $val2;
		}
		
		return $finalValue;
	}
}
?>