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
use \StephenBungert\SbPortfolio2\Domain\Repository;
use \StephenBungert\SbPortfolio2\Domain\Model;
/**
 *  * ViewHelper for getting clients related to a category.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ClientsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * clientRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository
	 */
	protected $clientRepository;

	/**
	 * injectCategoryRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository $clientRepository
	 * @return void
	 */
	public function injectCategoryRepository(\StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository $clientRepository) {
		$this->clientRepository = $clientRepository;
	}

	/**
	 * Returns the clients related to a category.
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $category The category.
	 * @param array $clientSetup The TS setup for the query.
	 * @return mixed NULL or the category's client records.
	 */
	public function render(\StephenBungert\SbPortfolio2\Domain\Model\Category $category = NULL, array $clientSetup) {
		$clients = NULL;

		if ($category !== NULL) {
			$clients = $this->clientRepository->findByCategory($category, $clientSetup);
		}

		return $clients;
	}
}
?>
