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

/**
 *  * ViewHelper for getting items related to another item.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class RelatedItemsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Returns the records related to the current $record.
	 * e.g. if $record is an item, manually created related items are returned along with
	 * category related items and items related by tag.
	 *
	 * @param object $record The current $record.
	 * @param string $tagOp Either OR or AND: how the $record's tag are used in the query.
	 * @param boolean $rec Should $record's related items be returned?
	 * @param boolean $cat Should $record's related items be returned?
	 * @param boolean $tag Should $record's related items be returned?
	 * @return mixed NULL or the related item records.
	 */
	public function render($record, $tagOp = 'OR', $rec = TRUE, $cat = FALSE, $tag = TRUE) {
		$items		= NULL;
		$className	= get_class($record);

		if ($className == '\\StephenBungert\\SbPortfolio2\\Domain\\Model\\Item' || $className == '\\StephenBungert\\SbPortfolio2\\Domain\\Model\\Client') {
			$uid		= $record->getUid();
			$recordType	= $this->getRecordType($className);

				// Get client portfolio
			$repository	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\StephenBungert\\SbPortfolio2\\Domain\\Repository\\' . $recordType . 'Repository');

			$options = array (
				'record'	=> $rec,
				'catgeory'	=> $cat,
				'tag'		=> $tag,
				'tagop'		=> $tagOp,
			);

			$items = $repository->findRelated($uid, $options);

			unset($repository);
		}

		return $items;
	}

	/**
	 * Gets and stores a list of the UIDs collected so far.
	 *
	 * @return void
	 */
	protected function getUids() {
		foreach ($this->relatedRecs as $rec) {
			$this->relatedUids .= $rec->getUid() . ',';
		}

		$this->relatedUids = trim($this->relatedUids, ',');

		\TYPO3\CMS\Core\Utility\DebugUtility::debug($this->relatedUids);
	}

	/**
	 * Returns the type of model that $record is.
	 * e.g. if $record of the class "\StephenBungert\SbPortfolio2\Domain\Model\Item"
	 * "Item" will be returned
	 *
	 * @param string $className $record's class name.
	 * @return string $recordType The type of model.
	 */
	protected function getRecordType($className) {
		$underscorePos	= strrpos($className, '_');
		$recordType		= substr($className, $underscorePos + 1);

		return $recordType;
	}
}
?>
