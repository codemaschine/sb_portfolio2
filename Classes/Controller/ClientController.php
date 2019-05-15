<?php
namespace StephenBungert\SbPortfolio2\Controller;
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
 use \StephenBungert\SbPortfolio2\Domain\Repository;
 use \StephenBungert\SbPortfolio2\Domain\Model;
/**
 *
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class ClientController extends CoreRecordController {

	/**
	 * clientRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository
	 */
	protected $clientRepository;

	/**
	 * injectClientRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository $clientRepository
	 * @return void
	 */
	public function injectClientRepository(\StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository $clientRepository) {
		$this->clientRepository = $clientRepository;
	}

	/**
	 * action list
	 *
     * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $category A category record to filter the view by.
     * @param \StephenBungert\SbPortfolio2\Domain\Model\Tag $tag A client record to filter the view by.
	 * @return void
	 */
	public function listAction(\StephenBungert\SbPortfolio2\Domain\Model\Category $category = NULL, \StephenBungert\SbPortfolio2\Domain\Model\Tag $tag = NULL) {
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
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Client $client The client to show.
	 * @return void
	 */
	public function singleAction(\StephenBungert\SbPortfolio2\Domain\Model\Client $client = NULL) {
		$this->view->assign('client', $client);
	}

}
?>
