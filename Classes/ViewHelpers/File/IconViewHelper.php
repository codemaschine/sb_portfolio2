<?php

namespace StephenBungert\SbPortfolio2\ViewHelpers\File;

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
 * ViewHelper for displaying an icon for a file.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class IconViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Returns the path for an icon based on the file's file type
	 *
	 * @param object $filetype The file's file type extension
	 * @param string $path The path to the folder containing the file type icons.
	 * @return string The classes string.
	 */
	public function render($filetype, $path = '') {
		$iconFilePath	= '';
		$testPrefix		= '';

		if (empty($path)) {
			$path		= 'media/fileicons/';
			$testPrefix	= PATH_typo3 . 'sysext/cms/tslib/';

		} else {
				// Check for trailing slash
			$lastChar = $path[strlen($path)-1];

			if ($lastChar != '/') {
				$path .= '/';
			}
		}

		$iconFilePath = $path . 'default' . '.gif';

		if (is_file($testPrefix . $path . $filetype . '.gif')) {
			$iconFilePath = $path . $filetype . '.gif';
		}

		return $iconFilePath;
	}
}
?>
