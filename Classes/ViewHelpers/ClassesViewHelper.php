<?php

namespace StephenBungert\SbPortfolio2\ViewHelpers;

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
use \StephenBungert\SbPortfolio2\Domain\Model;
/**
 * ViewHelper for List classes
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ClassesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * The type of model that $record is.
	 * e.g. if $record is of the class "\StephenBungert\SbPortfolio2\Domain_Model_Item"
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





			if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Item') {
				$classes = $this->getClassesItem($record, $classes);

			} else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Image') {
				 $classes = $this->getClassesImage($record, $classes);

			} else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\File') {
				 $classes = $this->getClassesFile($record, $classes);

			} else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Link') {
				$classes = $this->getClassesLink($record, $classes);

			} else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Tag') {
				 $classes = $this->getClassesTag($record, $classes);

			}  else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Film') {
				 $classes = $this->getClassesFilm($record, $classes);

			}  else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Testimonial') {
				 $classes = $this->getClassesTestimonial($record, $classes);

			}  else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Client') {
				 $classes = $this->getClassesClient($record, $classes);

			}  else if ($className == '\StephenBungert\SbPortfolio2\Domain\Model\Slider') {
				 $classes = $this->getClassesSlider($record, $classes);
			}
		}


			// Create the class string
		if (!empty($classes)) {
			$classString = implode(' ', $classes);
		}

		return $classString;
	}

	protected function getClassesLink(\StephenBungert\SbPortfolio2\Domain\Model\Link $record, array $classes)
	{
		$linkType	= $record->getType();
		$classes[]	= 'linkType-' . $linkType;

		if ($linkType == 1) {
			$classes[] = 'file-' . $record->getFiletype();
		}

		$classes = $this->getTypeClasses($record, $classes);


		return $classes;
	}

	protected function getClassesTestimonial(\StephenBungert\SbPortfolio2\Domain\Model\Testimonial $record, array $classes)
	{
		if ($record->getClient() > 0) {
			$classes[] = 'testimonialClient';

		} else if ($record->getItem() > 0) {
			$classes[] = 'testimonialItem';
		}

		return $classes;
	}

	protected function getClassesTag(\StephenBungert\SbPortfolio2\Domain\Model\Tag $record, array $classes)
	{
		$classes = $this->getTypeClasses($record, $classes);

		return $classes;
	}

	protected function getClassesFile(\StephenBungert\SbPortfolio2\Domain\Model\File $record, array $classes)
	{
		$classes = $this->getTypeClasses($record, $classes);

		$classes[] = 'file-' . $record->getFiletype();

		return $classes;
	}

	protected function getClassesImage(\StephenBungert\SbPortfolio2\Domain\Model\Image $record, array $classes)
	{
		$classes[] = 'file-' . $record->getImagetype();
		$classes[] = 'imageOrientation-' . $record->getImageorientation();

		return $classes;
	}

	protected function getClassesFilm(\StephenBungert\SbPortfolio2\Domain\Model\Film $record, array $classes)
	{
		$filmType = $record->getType();
		$classes[] = 'filmType-' . $filmType;

		if ($filmType == 0) {
			$classes[] = 'filmHost-' . $record->getHost();
		}

		return $classes;
	}

	protected function getClassesClient(\StephenBungert\SbPortfolio2\Domain\Model\Client $record, array $classes)
	{
		$classes = $this->getCatIdClasses($record->getCategories(), $classes);

		return $classes;
	}

	protected function getClassesItem(\StephenBungert\SbPortfolio2\Domain\Model\Item $record, array $classes)
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

	protected function getClassesSlider(\StephenBungert\SbPortfolio2\Domain\Model\Slider $record, array $classes)
	{
		$classes[] = 'sliderType-' . $record->getType();

		return $classes;
	}

	/**
	 * Set the type of model that $record is.
	 * e.g. if $record is of the class "\StephenBungert\SbPortfolio2\Domain\Model\Item"
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
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage $categories The record's categories.
	 * @param array $classes The array of classes.
	 * @return array $classes The array of classes.
	 */
	protected function getCatIdClasses(\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage $categories, array $classes) {
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
