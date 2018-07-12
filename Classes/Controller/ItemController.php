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
class Tx_SbPortfolio2_Controller_ItemController extends Tx_SbPortfolio2_Controller_CoreRecordController {

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
	public function injectItemRepository(Tx_SbPortfolio2_Domain_Repository_ItemRepository $itemRepository) {
		$this->itemRepository = $itemRepository;
	}
    
    

	/**
	 * action list Shows a list of portfolio items.
	 *
     * @param Tx_SbPortfolio2_Domain_Model_Client $client A client record to filter the view by.
     * @param Tx_SbPortfolio2_Domain_Model_Category $category A category record to filter the view by.
     * @param Tx_SbPortfolio2_Domain_Model_Tag $tag A client record to filter the view by.
	 * @return voidtag	 */
	public function listAction(Tx_SbPortfolio2_Domain_Model_Client $client = NULL, Tx_SbPortfolio2_Domain_Model_Category $category = NULL, Tx_SbPortfolio2_Domain_Model_Tag $tag = NULL) {
		$this->mergeFlexFormSettings('item');
		$filters = array(
			'client'	=> $client,
			'category'	=> $category,
			'tag'		=> $tag,
		);
		
		$items = $this->itemRepository->findRecords($filters, $this->settings['item']['records']);

		$this->view->assign('items', 		$items['records']);
		$this->view->assign('filtering',	$items['filterInfo']);
	}

	/**
	 * action single Shows one portfolio item.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Item $item The item to show
	 * @return void
	 */
	public function singleAction(Tx_SbPortfolio2_Domain_Model_Item $item = NULL) {
		$this->view->assign('item', $item);
	}
}
?>