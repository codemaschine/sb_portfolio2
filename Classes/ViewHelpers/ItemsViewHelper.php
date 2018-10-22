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
 *  * ViewHelper for getting items related to a client or category.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ItemsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * itemRepository
	 *
	 * @var Tx_SbPortfolio2_Domain_Repository_ItemRepository
	 */
	protected $itemRepository;

	/**
	 * injectItemRepository
	 *
	 * @param Tx_SbPortfolio2_Domain_Repository_ItemRepository $itemRepository
	 * @return void
	 */
	public function injectItemRepository(\Tx_SbPortfolio2_Domain_Repository_ItemRepository $itemRepository) {
		$this->itemRepository = $itemRepository;
	}

	/**
	 * Returns the items related to a client/category.
	 *
	 * @param object $record The client/category.
	 * @param string $type The type of portfolio, either "category", or "client".
	 * @param array $itemSetup The TS setup for the query.
	 * @return mixed NULL or the client's/category's item records.
	 */
	public function render($record = NULL, $type, array $itemSetup) {
		$items	= NULL;
		$type	= ucfirst($type);

		if ($record !== NULL) {
			if ($type == 'Category') {
				$items = $this->itemRepository->findByCategory($record, $itemSetup);

			} else if ($type == 'Client') {
				$items = $this->itemRepository->findByClient($record, $itemSetup);
			}
		}

		return $items;
	}
}
?>
