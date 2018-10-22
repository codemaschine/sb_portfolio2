<?php

namespace StephenBungert\SbPortfolio2\ViewHelpers\Meta;

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
 *  ViewHelper for getting the record's tags to be used as keywords.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class KeywordsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Outputs the keywords for an item.
	 *
	 * @param mixed $tags The tags to be used a source of keywords.
	 * @return string $keywords The title text.
	 */
	public function render($tags) {
		$keywords = '';

		if (is_object($tags) || is_array($tags)) {
			foreach ($tags as $tag) {
				$keywords .= ',' .  $tag->getTitle();
			}

			$keywords = trim($keywords, ',');
		}

		return $keywords;
	}
}
?>
