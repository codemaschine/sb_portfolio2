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
 * ViewHelper for List classes
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_ClassesViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * The type of model that $record is.
	 * e.g. if $record is of the class "Tx_SbPortfolio2_Domain_Model_Item"
	 * $recordType will be "item"
	 *
	 * @var string
	 */
	protected $recordType = '';

	/**
	 * Outputs the classes for a record
	 *
	 * @param mixed $record The current object: could be an item, a client etc.
	 * @param array $info Information about the currrent loop iteration, if any
	 * @return string The classes string.
	 */
	public function render($record, array $info = array()) {
		$classString	= '';
		$classes		= array();
		$className		= '';
		$recordIsObject	= false;

		if (is_object($record)) {
			$recordIsObject	= true;
			$className		= get_class($record);

			$this->setRecordType($className);
		}

		// Classes based on loop info
		if (!empty($info)) {
			if ($info['isEven']) {
				$classes[] = 'even';

			} else if ($info['isOdd']) {
				$classes[] = 'odd';
			}

			if ($info['isFirst']) {
				$classes[] = 'first';

			} else if ($info['isLast']) {
				$classes[] = 'last';
			}

			$classes[] = 'number-' . $info['cycle'];
		} // Else: no info supplied, probably a Detail view of some kind.


			// Classes based on object type
		if ($recordIsObject) {
			$classes[] = $this->recordType;
			$classes[] = $this->recordType . '-' . $record->getUid();

			if ($className == 'Tx_SbPortfolio2_Domain_Model_Item') {
				$classes = $this->getClassesItem($record, $classes);

			} else if ($className == 'Tx_SbPortfolio2_Domain_Model_Image') {
				 $classes = $this->getClassesImage($record, $classes);

			} else if ($className == 'Tx_SbPortfolio2_Domain_Model_File') {
				 $classes = $this->getClassesFile($record, $classes);

			} else if ($className == 'Tx_SbPortfolio2_Domain_Model_Link') {
				$classes = $this->getClassesLink($record, $classes);

			} else if ($className == 'Tx_SbPortfolio2_Domain_Model_Tag') {
				 $classes = $this->getClassesTag($record, $classes);

			}  else if ($className == 'Tx_SbPortfolio2_Domain_Model_Film') {
				 $classes = $this->getClassesFilm($record, $classes);

			}  else if ($className == 'Tx_SbPortfolio2_Domain_Model_Testimonial') {
				 $classes = $this->getClassesTestimonial($record, $classes);

			}  else if ($className == 'Tx_SbPortfolio2_Domain_Model_Client') {
				 $classes = $this->getClassesClient($record, $classes);

			}  else if ($className == 'Tx_SbPortfolio2_Domain_Model_Slider') {
				 $classes = $this->getClassesSlider($record, $classes);
			}
		}


			// Create the class string
		if (!empty($classes)) {
			$classString = implode(' ', $classes);
		}

		return $classString;
	}

	protected function getClassesLink(Tx_SbPortfolio2_Domain_Model_Link $record, array $classes)
	{
		$linkType	= $record->getType();
		$classes[]	= 'linkType-' . $linkType;

		if ($linkType == 1) {
			$classes[] = 'file-' . $record->getFiletype();
		}

		$classes = $this->getTypeClasses($record, $classes);


		return $classes;
	}

	protected function getClassesTestimonial(Tx_SbPortfolio2_Domain_Model_Testimonial $record, array $classes)
	{
		if ($record->getClient() > 0) {
			$classes[] = 'testimonialClient';

		} else if ($record->getItem() > 0) {
			$classes[] = 'testimonialItem';
		}

		return $classes;
	}

	protected function getClassesTag(Tx_SbPortfolio2_Domain_Model_Tag $record, array $classes)
	{
		$classes = $this->getTypeClasses($record, $classes);

		return $classes;
	}

	protected function getClassesFile(Tx_SbPortfolio2_Domain_Model_File $record, array $classes)
	{
		$classes = $this->getTypeClasses($record, $classes);

		$classes[] = 'file-' . $record->getFiletype();

		return $classes;
	}

	protected function getClassesImage(Tx_SbPortfolio2_Domain_Model_Image $record, array $classes)
	{
		$classes[] = 'file-' . $record->getImagetype();
		$classes[] = 'imageOrientation-' . $record->getImageorientation();

		return $classes;
	}

	protected function getClassesFilm(Tx_SbPortfolio2_Domain_Model_Film $record, array $classes)
	{
		$filmType = $record->getType();
		$classes[] = 'filmType-' . $filmType;

		if ($filmType == 0) {
			$classes[] = 'filmHost-' . $record->getHost();
		}

		return $classes;
	}

	protected function getClassesClient(Tx_SbPortfolio2_Domain_Model_Client $record, array $classes)
	{
		$classes = $this->getCatIdClasses($record->getCategories(), $classes);

		return $classes;
	}

	protected function getClassesItem(Tx_SbPortfolio2_Domain_Model_Item $record, array $classes)
	{
		if ($record->isFeatured()) {
			$classes[] = 'featured';
		}

		if ($record->isInprogress()) {
			$classes[] = 'inprogress';
		}

		$classes[] = 'itemType-' . $record->getType();

		$classes = $this->getCatIdClasses($record->getCategories(), $classes);

		return $classes;
	}

	protected function getClassesSlider(Tx_SbPortfolio2_Domain_Model_Slider $record, array $classes)
	{
		$classes[] = 'sliderType-' . $record->getType();

		return $classes;
	}

	/**
	 * Set the type of model that $record is.
	 * e.g. if $record is of the class "Tx_SbPortfolio2_Domain_Model_Item"
	 * "item" will be returned
	 *
	 * @param string $className $record's class name.
	 * @return void
	 */
	protected function setRecordType($className) {
		$underscorePos	= strrpos($className, '_');
		$recordType		= strtolower(substr($className, $underscorePos + 1));

		$this->recordType = strtolower($recordType);
	}

	/**
	 * Adds classes to the $classes array based on category id's.
	 *
	 * @param Tx_Extbase_Persistence_LazyObjectStorage $categories The record's categories.
	 * @param array $classes The array of classes.
	 * @return array $classes The array of classes.
	 */
	protected function getCatIdClasses(Tx_Extbase_Persistence_LazyObjectStorage $categories, array $classes) {
		foreach ($categories as $key => $cat) {
			$classes[] = 'category-' . $cat->getUid();
		}

		return $classes;
	}

	/**
	 * Adds classes to the $classes array based on category id's.
	 *
	 * @param object $record The record.
	 * @param array $classes The array of classes.
	 * @return array $classes The array of classes.
	 */
	protected function getTypeClasses($record, array $classes) {
		if ($record->isCatRecord()) {
			$classes[] = $this->recordType . 'Category';
		}

		if ($record->isItemRecord()) {
			$classes[] = $this->recordType . 'Item';
		}

		if ($record->isClientRecord()) {
			$classes[] = $this->recordType . 'Client';
		}

		return $classes;
	}
}
?>