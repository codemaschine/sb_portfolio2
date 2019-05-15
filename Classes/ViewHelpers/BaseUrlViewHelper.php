<?php
namespace StephenBungert\SbPortfolio2\ViewHelpers;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * A view helper to show seconds like a watch-time as M:SS
 */

use \TYPO3\CMS\Core\Utility\GeneralUtility as t3lib_div;


class BaseUrlViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

  /**
   * @var bool
   */
  protected $escapeOutput = false;

	/**
	 * @return string reference linked with tooltip
	 */
  public function render() {
    return 'https://'.t3lib_div::getHostname().'/';
  }
}
?>
