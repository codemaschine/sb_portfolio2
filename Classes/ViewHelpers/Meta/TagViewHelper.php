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
 * ViewHelper for adding a metatag to the page output.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_Meta_TagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * The tag to be made by this tag based VH.
	 * 
	 * @var	string
	 */
	protected $tagName = 'meta';

	/**
	 * Arguments initialization
	 *
	 * @return void
	 */
	public function initializeArguments() {
			// Required arguments
		$this->registerTagAttribute('content', 'string', 'The content of a meta tag.', TRUE);
		
			// Optional
		$this->registerTagAttribute('scheme', 'string', 'Specifies a scheme to be used to interpret the value of the content attribute');
		$this->registerTagAttribute('name', 'string', 'The name property of the meta tag.');
			// http-equiv tags don't seem to get made by tag->render().
	}
	
	/**
	 * Adds a metatag to the page.
	 *
	 * @return void
	 */
	public function render() {
		if (!empty($this->arguments['content']) && !empty($this->arguments['name'])) {
			$GLOBALS['TSFE']->getPageRenderer()->addMetaTag($this->tag->render());
		}
	}
}

?>