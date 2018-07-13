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
 * Returns the HTML for one image
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_Flickr_ImageViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * The tag to be made by this tag based VH.
	 * 
	 * @var	string
	 */
	protected $tagName = 'img';
	
	/**
	 * The keys needed in $image in order to be able to make the image URL.
	 * 
	 * @var	array
	 */
	protected static $keys = array('farm', 'server', 'id', 'secret');

	/**
	 * Arguments initialization
	 *
	 * @return void
	 */
	public function initializeArguments() {
			// Required arguments
		$this->registerTagAttribute('alt', 'string', 'The alt text for the image.');
		
			// Optional (deprectated attribute not included)
		$this->registerTagAttribute('width', 'string', 'The width of the image.');
		$this->registerTagAttribute('height', 'string', 'The height of the image.');
		$this->registerTagAttribute('title', 'string', 'The title of the image.');
		$this->registerTagAttribute('ismap', 'string', 'Specifies an image as a server-side image-map');
		$this->registerTagAttribute('longdesc', 'string', 'Specifies the URL to a document that contains a long description of an image');
		$this->registerTagAttribute('usemap', 'string', 'Specifies an image as a client-side image-map');
	}

	/**
	 * Renders an html image tag for a flickr image
	 *
	 * @param array $image The current image.
	 * @return string The image HTML tag, or an error message.
	 */
	public function render(array $image) {
		if ($this->imageArrayIsValid($image)) {
			$imgSrc = 'http://farm' . $image['farm'] . '.static.flickr.com/' . $image['server'] . '/' . $image['id'] . '_' . $image['secret'] . '.jpg';
			
			$this->tag->addAttribute('src', $imgSrc);
			
			return $this->tag->render();
		}
		
		return '<!-- Can not build image url - not all required flickr parameters were present in the image array -->';
	}

	/**
	 * Checks of all required elements exist to make an image url.
	 *
	 * @param array $image The current image.
	 * @return boolean $isValid TRUE if all the required elements exist.
	 */
	protected function imageArrayIsValid(array $image) {
		$isValid = TRUE;
		
		foreach (self::$keys as $key) {
			if (!isset($image[$key])) {
				$isValid = FALSE;
				
				break;
			}
		}
		
		return $isValid;
	}
}
?>