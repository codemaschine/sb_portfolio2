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
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */

use \TYPO3\CMS\Core\Utility\GeneralUtility as t3lib_div;


class AdditionalHeaderDataViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

  /**
   * @var bool
   */
  protected $escapeOutput = false;

	/**
	 * @param string $key array-key in GLOBALS['TSFE']->additionalHeaderData
	 * @return string nothing
	 * @author Jannes Dinse
	 */
	public function render($key = 'ahdviewhelper') {

		//t3lib_div::devLog('headerdata: '.var_export($GLOBALS['TSFE']->page, true), 'jdtest');


		$renderedContent = $this->renderChildren();

		$GLOBALS['TSFE']->additionalHeaderData[$key] = $renderedContent;



		return '';

	}
}
?>
