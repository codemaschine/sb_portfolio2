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
 *  * ViewHelper for getting clients related to a category.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_SbPortfolio2_ViewHelpers_ClientsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * clientRepository
	 *
	 * @var Tx_SbPortfolio2_Domain_Repository_ClientRepository
	 */
	protected $clientRepository;

	/**
	 * injectCategoryRepository
	 *
	 * @param Tx_SbPortfolio2_Domain_Repository_ClientRepository $clientRepository
	 * @return void
	 */
	public function injectCategoryRepository(Tx_SbPortfolio2_Domain_Repository_ClientRepository $clientRepository) {
		$this->clientRepository = $clientRepository;
	}

	/**
	 * Returns the clients related to a category.
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Category $category The category.
	 * @param array $clientSetup The TS setup for the query.
	 * @return mixed NULL or the category's client records.
	 */
	public function render(Tx_SbPortfolio2_Domain_Model_Category $category = NULL, array $clientSetup) {
		$clients = NULL;
		
		if ($category !== NULL) {
			$clients = $this->clientRepository->findByCategory($category, $clientSetup);
		}
		
		return $clients;
	}
}
?>