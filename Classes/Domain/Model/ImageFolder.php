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
 *
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Model_ImageFolder extends Tx_SbPortfolio2_Domain_Model_BaseRecord {

	/**
	 * The actual folders associated with this image folder record. These are references to folders in fileadmin.
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $folders;

	/**
	 * An array containing all the images stored in the folders
	 *
	 * @var array
	 */
	protected $imageFolderImages = array();

	/**
	 * A short description about this image folder.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Have folder images been collected?
	 *
	 * @var boolean
	 */
	protected $imagesCollected;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Returns folders
	 *
	 * @return string $folders
	 */
	public function getFolders() {
		return $this->folders;
	}

	/**
	 * Sets folders
	 *
	 * @param string $folders
	 * @return void
	 */
	public function setFolders($folders) {
		$this->folders = $folders;
	}

	/**
	 * Returns the images array for all the images in this imagefolder's folders
	 *
	 * @return array imageFolderImages
	 */
	public function getImagefolderimages() {
		if (!$this->imagesAreCollected()) {
			$this->getImagesFromDir();
		}

		return $this->imageFolderImages;
	}

	/**
	 * Sets the images array for all the images in the imagefolder's folders
	 *
	 * @param array $imageFolderImages An array of images from all the item's imagefolder folders.
	 * @return void
	 */
	public function setImagefolderimages(array $imageFolderImages) {
		$this->imageFolderImages = $imageFolderImages;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Gets the images from imagefolders
	 *
	 * @return void
	 * @param string $sortOrder: Either '1' or 'mtime': '1' = sort alphabetically, 'mtime' = sort by modified date.
	 * @todo Add manifest file support
	 */
	protected function getImagesFromDir($sortOrder = 'mtime') {
		$folders = t3lib_div::trimExplode(',', $this->getFolders(), true);

		if (!empty($folders)) {
			$images		= array();
			$manifest	= t3lib_div::makeInstance('Tx_SbPortfolio2_Domain_Model_Manifest_File');

			foreach ($folders as $folderIndex => $folderPath) {
				$manifestData	= $manifest->getManifestData($folderPath);
				$folderImgs		= t3lib_div::getFilesInDir($folderPath, $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'], TRUE, $sortOrder);

				// Remove hashed index
				foreach ($folderImgs as $imageHash => $imagePath) {
					$imgManifestData = array();

					if ($manifestData) {
						$imgManifestData = $manifest->getManifestFieldsFromData($manifestData, $imagePath);
					}

					$imgManifestData['imagefile'] = $imagePath; // Add path to image file

					$images[] = $imgManifestData;
				}
			}

			$this->setImagefolderimages($images);
		}

		$this->setImagescollected(true);
	}

	/**
	 * Returns imagesCollected
	 *
	 * @return boolean imagesCollected
	 */
	public function getImagesCollected() {
		return $this->imagesCollected;
	}

	/**
	 * Sets imagesCollected
	 *
	 * @param boolean $imagesCollected
	 * @return boolean imagesCollected
	 */
	public function setImagesCollected($imagesCollected) {
		$this->imagesCollected = $imagesCollected;
	}

	/**
	 * Returns the boolean state of imagesCollected
	 *
	 * @return boolean imagesCollected
	 */
	public function imagesAreCollected() {
		return $this->getImagesCollected();
	}
}
?>