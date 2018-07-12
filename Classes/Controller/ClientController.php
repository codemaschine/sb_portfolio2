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
class Tx_SbPortfolio2_Controller_ClientController extends Tx_SbPortfolio2_Controller_CoreRecordController {

	/**
	 * clientRepository
	 *
	 * @var Tx_SbPortfolio2_Domain_Repository_ClientRepository
	 */
	protected $clientRepository;

	/**
	 * injectClientRepository
	 *
	 * @param Tx_SbPortfolio2_Domain_Repository_ClientRepository $clientRepository
	 * @return void
	 */
	public function injectClientRepository(Tx_SbPortfolio2_Domain_Repository_ClientRepository $clientRepository) {
		$this->clientRepository = $clientRepository;
	}

	/**
	 * action list
	 *
     * @param Tx_SbPortfolio2_Domain_Model_Category $category A category record to filter the view by.
     * @param Tx_SbPortfolio2_Domain_Model_Tag $tag A client record to filter the view by.
	 * @return void
	 */
	public function listAction(Tx_SbPortfolio2_Domain_Model_Category $category = NULL, Tx_SbPortfolio2_Domain_Model_Tag $tag = NULL) {
		$this->mergeFlexFormSettings('client');
		$filters = array(
			'category'	=> $category,
			'tag'		=> $tag,
		);

		$clients = $this->clientRepository->findRecords($filters, $this->settings['client']['records']);

		$this->view->assign('clients',		$clients['records']);
		$this->view->assign('filtering',	$clients['filterInfo']);
	}

	/**
	 * action single
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Client $client The client to show.
	 * @return void
	 */
	public function singleAction(Tx_SbPortfolio2_Domain_Model_Client $client = NULL) {
		$this->view->assign('client', $client);
	}

}
?>