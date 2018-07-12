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
 * A class that contains utility functions used during import or sb_portfolio records to sb_portfolio2
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Model_Import_Helper {

	/**
	 * A record from an sb_portfolio.
	 *
	 * @var array
	 */
	protected $sbpRec;

	/**
	 * A instance of t3lib_basicFileFunctions used for file manipulation.
	 *
	 * @var t3lib_basicFileFunctions
	 */
	protected $filer;

	/**
	 * The folder where sb_portfolio images are uploaded to.
	 *
	 * @var string
	 */
	protected $imgUploadPath = 'uploads/tx_sbportfolio/';

	/**
	 * An array of all objects created: their type and title
	 *
	 * @var array
	 */
	protected $childObjects = array();

	/**
	 * A count of the number of child objects
	 *
	 * @var integer
	 */
	protected $childId = 1;

	/**
	 * The current "parent" child of the current child object
	 *
	 * @var integer
	 */
	protected $parentId = -1;



	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct($sbpRec) {
		$this->setSbpRec($sbpRec);
		#$this->filer = t3lib_div::makeInstance('t3lib_basicFileFunctions');
	}



	/**
	 * Returns sbpRec.
	 *
	 * @return array $sbpRec
	 */
	public function getSbpRec() {
		return $this->sbpRec;
	}

	/**
	 * Sets the sbpRec.
	 *
	 * @param array $sbpRec
	 * @return void
	 */
	public function setSbpRec(array $sbpRec) {
		$this->sbpRec = $sbpRec;
	}

	/**
	 * Returns parentId.
	 *
	 * @return integer parentId
	 */
	public function getParentId() {
		return $this->parentId;
	}

	/**
	 * Sets parentId.
	 *
	 * @param integer $parentId
	 * @return void
	 */
	public function setParentId($parentId) {
		$this->parentId = $parentId - 1;
	}

	/**
	 * Returns childId.
	 *
	 * @return integer childId
	 */
	public function getChildId() {
		return $this->childId;
	}

	/**
	 * Sets childId.
	 *
	 * @param integer $childId
	 * @return void
	 */
	public function setChildId($childId) {
		$this->childId = $childId;
	}

	/**
	 * Returns childObjects.
	 *
	 * @return array $childObjects
	 */
	public function getChildObjects() {
		return $this->childObjects;
	}

	/**
	 * Sets childObjects.
	 *
	 * @param array $childObjects
	 * @return void
	 */
	public function setChildObjects($childObjects) {
		$this->childObjects = $childObjects;
	}

	/**
	 * Adds a child objects.
	 *
	 * @param string $type The type of the child object.
	 * @param string $folder The folder where the child object's icon is stored.
	 * @param string $title The title of the child object.
	 * @return void
	 */
	public function addChildObject($type, $folder, $title) {
		$this->childObjects[] = array(
			'type'		=> 	$type,
			'folder'	=> 	$folder,
			'title'		=> 	$title,
			'id'		=> 	$this->childId,
		);

		if ($type == 'image' && $this->getParentId() >= 1)
		{
			$this->childObjects[$this->childId - 1]['parent'] = $this->getParentId();
			$this->setParentId(-1);
		}

		$this->childId ++;
	}

	/**
	 * A function that tries to detect what type an sb_portfolio2 link should be
	 *
	 * @param string $linkUrl The link url from the sb_portfolio record
	 * @return array $linkType The links type number: 0 = url, 1 = file, 2 = page, and the value for the data base
	 */
	public function getLinkType($linkUrl) {
		$linkType = array(
			0 => 0,
			1 => $linkUrl
		);

		$indexPos		= strpos($linkUrl, 'index.php?');
		$fileadminPos	= strpos($linkUrl, 'fileadmin/');
		$linkPathData	= pathinfo($linkUrl);

		if ($fileadminPos !== FALSE) { // A link to a file in fileadmin or on another server
			$linkType[0] = 1;

		}  else if (intval($linkUrl) > 0) { // Probably just a number, which would mean someone was using the linkurl field to store a page id
			$linkType[0] = 2;

		} else if ($indexPos !== FALSE) { // Could be a url to a TYPO3 page
			$queryString	= substr($linkUrl, $indexPos + 10);
			$queryVars		= t3lib_div::trimExplode('&', $queryString, TRUE);

			foreach ($queryVars as $value) {
				if (strpos($value, 'id') !== FALSE) {
					$idVar = t3lib_div::trimExplode('=', $value, TRUE);

					if (intval($idVar[1]) > 0) {
						$linkType[0] = 2;
						$linkType[1] = $idVar[1];
						break;
					}
				}
			}
		}

		return $linkType;
	}

	/**
	 * Sets core field that all records need.
	 *
	 * @param mixed $sbp2Rec A new sb_portfolio2 record, could be an item, and image...
	 * @param boolean $coreRecord Is the record a core record: item, cleint, or category?
	 * @return array $sbp2Rec The sb_portfolio2 record with certain fields set.
	 */
	public function setCoreFields($sbp2Rec, $coreRecord = FALSE) {
		if(is_object($sbp2Rec)) {
			$sbp2Rec->setPid($this->sbpRec['pid']);
			$sbp2Rec->setCrdate($this->sbpRec['crdate']);
			$sbp2Rec->setCruserId($this->sbpRec['cruser_id']);
			$sbp2Rec->setTstamp($this->sbpRec['tstamp']);

			if ($coreRecord) {
				$sbp2Rec->setDeleted($this->sbpRec['deleted']);
				$sbp2Rec->setHidden($this->sbpRec['hidden']);
				$sbp2Rec->setStarttime($this->sbpRec['starttime']);
				$sbp2Rec->setEndtime($this->sbpRec['endtime']);

				$sbp2Rec->setSyslanguageuid($this->sbpRec['sys_language_uid']);
				$sbp2Rec->setL10nparent($this->sbpRec['l10n_parent']);
			}
		}

		return $sbp2Rec;
	}

	/**
	 * Sets seofields, the seofields from sbp-seo
	 *
	 * @param mixed $sbp2Rec A new sb_portfolio2 record, could be an item, and image...
	 * @param boolean $coreRecord Is the record a core record: item, cleint, or category?
	 * @return array $sbp2Rec The sb_portfolio2 record with certain fields set.
	 */
	public function setSeoFields($sbp2Rec) {
		if(is_object($sbp2Rec)) {
				// If one exists they all do...
			if (array_key_exists('tx_sbpseo_title', $this->sbpRec))
			{
				$sbp2Rec->setSeoTitle($this->sbpRec['tx_sbpseo_title']);
				$sbp2Rec->setSeoType($this->sbpRec['tx_sbpseo_type']);
				$sbp2Rec->setSeoImage($this->sbpRec['tx_sbpseo_image']);
				$sbp2Rec->setSeoDescription($this->sbpRec['tx_sbpseo_description']);
				$sbp2Rec->setSeoFbappid($this->sbpRec['tx_sbpseo_fbappid']);
				$sbp2Rec->setSeoFbadmins($this->sbpRec['tx_sbpseo_fbadmins']);
			}
		}

		return $sbp2Rec;
	}

	/**
	 * Sets Link record fields.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Link $link An sb_portfolio2 Link record.
	 * @param string $suffix The suffix for the title - could be "main link" for example.
	 * @param string $linkField The field with the link
	 * @return Tx_SbPortfolio2_Domain_Model_Link $link The Link record with certain fields set.
	 */
	public function setLinkFields(Tx_SbPortfolio2_Domain_Model_Link $link, $suffix, $linkField) {
		$title		= $this->sbpRec['title'] . ' ' . $suffix;
		$linkType	= $this->getLinkType($linkField);

		$link->setTitle($title);
		$link->setType($linkType[0]);

		if ($linkType[0] == 0) {
			$link->setUrl($linkType[1]);

		} else if ($linkType[0] == 1) {
			$link->setFile($linkType[1]);

			// Set file data fields
			$filePathData = pathinfo($linkType[1]);

			$link->setFiletype(strtolower($filePathData['extension']));
			$link->setFilesize(filesize(t3lib_div::getFileAbsFileName($linkType[1])));
			$link->setFilename($filePathData['filename']);
			$link->setFilepath($filePathData['dirname']);

		} else if ($linkType[0] == 2) {
			$link->setPage($linkType[1]);
		}

		$this->addChildObject('link', 'Link', $title);

		return $link;
	}

	/**
	 * Sets Image Folder record fields.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_ImageFolder $imageFolder An sb_portfolio2 Image Folder record.
	 * @return Tx_SbPortfolio2_Domain_Model_ImageFolder $imageFolder The Image folder record with certain fields set.
	 */
	public function setImageFolderFields(Tx_SbPortfolio2_Domain_Model_ImageFolder $imageFolder) {
		$title = $this->sbpRec['title'] . ' image folder';

		$imageFolder->setTitle($title);
		$imageFolder->setFolders($this->sbpRec['image_folders']);

		$this->addChildObject('imagefolder', 'Imagefolder', $title);

		return $imageFolder;
	}

	/**
	 * Sets Image record fields.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Image $image An sb_portfolio2 Image record.
	 * @param string $suffix The suffix for the title - could be preview for example.
	 * @param string $imagePath The file path of the image
	 * @param integer $imgNumber The number of the image - in cases where there are more than one, otherwise this is -1.
	 * @return Tx_SbPortfolio2_Domain_Model_Image $image The Image record with certain fields set.
	 */
	public function setImageFields(Tx_SbPortfolio2_Domain_Model_Image $image, $suffix, $imagePath, $imgNumber = -1) {
		$filePath	= $this->imgUploadPath . $imagePath;
		$title		= $this->sbpRec['title'] . ' ' . $suffix;

		if ($imgNumber >= 0) {
			$title .= ' ' . $imgNumber;
		}

		$image->setTitle($title);
		$image->setImagefile($filePath);

			// Set image data fields
		$imagePathData = pathinfo($filePath);
		$imageSizeData = getimagesize(t3lib_div::getFileAbsFileName($filePath));

		$image->setImagetype(strtolower($imagePathData['extension']));
		$image->setImagesize(filesize(t3lib_div::getFileAbsFileName($filePath)));
		$image->setImagename($imagePathData['filename']);
		$image->setImagepath($imagePathData['dirname']);
		$image->setImagewidth($imageSizeData[0]);
		$image->setImageheight($imageSizeData[1]);

		$imageOrientation = 0; // Square

		if ($imageSizeData[0] > $imageSizeData[1]) {
			$imageOrientation = 1; // Landscape

		} else if ($imageSizeData[1] > $imageSizeData[0]) {
			$imageOrientation = 2; // Portrait
		}

		$image->setImageorientation($imageOrientation);

		$this->addChildObject('image', 'Image', $title);

		return $image;
	}

	/**
	 * Sets Film record fields.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Film $film An sb_portfolio2 Film record.
	 * @return Tx_SbPortfolio2_Domain_Model_Film $film The Film record with certain fields set.
	 */
	public function setFilmFields(Tx_SbPortfolio2_Domain_Model_Film $film) {
		$title = $this->sbpRec['title'] . ' film';

		$film->setTitle($title);
		$film->setHostid($this->sbpRec['youtube']);

		$this->addChildObject('film', 'Film', $title);

		return $film;
	}

	/**
	 * Sets Image record fields.
	 *
	 * @todo Add image
	 * @param Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial An sb_portfolio2 Testimonial record.
	 * @return Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial The Testimonial record with certain fields set.
	 */
	public function setTestimonialFields(Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial) {
		$title = $this->sbpRec['title'] . ' testimonial';

		$testimonial->setTitle($title);
		$testimonial->setBody($this->sbpRec['testimonial']);
		$testimonial->setDatetime($this->sbpRec['testimonial_date']);
		$testimonial->setClient($this->sbpRec['testimonial_date']);
		$testimonial->setName($this->sbpRec['testimonial_name']);

			// Fields from sb_portfolioextended - doesn't matter if it is still installed
			// just check if the extended fields are in the sb_portfolio record or not.
			// If they are, use the content
		if (array_key_exists('tx_sbportfolioextended_testimonial_position', $this->sbpRec)) {
			$testimonial->setPosition($this->sbpRec['tx_sbportfolioextended_testimonial_position']);
		}

		if (array_key_exists('tx_sbportfolioextended_testimonial_company', $this->sbpRec)) {
			$testimonial->setCompany($this->sbpRec['tx_sbportfolioextended_testimonial_company']);
		}

		$this->addChildObject('testimonial', 'Testimonial', $title);

		return $testimonial;
	}

	/**
	 * Sets File record fields.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_File $file An sb_portfolio2 File record.
	 * @param string $filePath The file path of the file
	 * @param integer $fileNumber The number of the file - in cases where there are more than one, otherwise this is -1.
	 * @return Tx_SbPortfolio2_Domain_Model_File $file The File record with certain fields set.
	 */
	public function setFileFields(Tx_SbPortfolio2_Domain_Model_File $file, $filePath, $fileNumber = -1) {
		$title = $this->sbpRec['title'] . ' file';

		if ($fileNumber >= 0) {
			$title .= ' ' . $fileNumber;
		}

		$file->setTitle($title);
		$file->setFile($filePath);

		// Set file data fields
		$filePathData = pathinfo($filePath);

		$file->setFiletype(strtolower($filePathData['extension']));
		$file->setFilesize(filesize(t3lib_div::getFileAbsFileName($filePath)));
		$file->setFilename($filePathData['filename']);
		$file->setFilepath($filePathData['dirname']);

		$this->addChildObject('file', 'File', $title);

		return $file;
	}

	/**
	 * Sets Tag record fields.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Tag $tag An sb_portfolio2 Tag record.
	 * @param string $tagTitle The tag itself.
	 * @return Tx_SbPortfolio2_Domain_Model_Tag $tag The Tag record with certain fields set.
	 */
	public function setTagFields(Tx_SbPortfolio2_Domain_Model_Tag $tag, $tagTitle) {
		$tag->setTitle($tagTitle);

		return $tag;
	}
}
?>