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
class Tx_SbPortfolio2_Controller_TagController extends Tx_SbPortfolio2_Controller_CoreRecordController {

	/**
	 * tagRepository
	 *
	 * @var Tx_SbPortfolio2_Domain_Repository_TagRepository
	 */
	protected $tagRepository;

	/**
	 * injectTagRepository
	 *
	 * @param Tx_SbPortfolio2_Domain_Repository_TagRepository $tagRepository
	 * @return void
	 */
	public function injectTagRepository(Tx_SbPortfolio2_Domain_Repository_TagRepository $tagRepository) {
		$this->tagRepository = $tagRepository;
	}

	/**
	 * action list Shows a list of portfolio tags.
	 *
	 * @return void
	 */
	public function listAction() {
		$this->mergeFlexFormSettings('tag');

		$tags = $this->tagRepository->findWithConstraints($this->settings['tag']['records']);

		$this->view->assign('tags', $tags);
	}

	/**
	 * action single Shows one portfolio tag.
	 *
	 * @param $tag
	 * @return void
	 */
	public function singleAction(Tx_SbPortfolio2_Domain_Model_Tag $tag) {
		$this->view->assign('tag', $tag);
	}
}
?>