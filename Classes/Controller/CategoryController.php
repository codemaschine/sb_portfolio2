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
class CategoryController extends CoreRecordController {

	/**
	 * categoryRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * injectCategoryRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository $categoryRepository
	 * @return void
	 */
	public function injectCategoryRepository(\StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * action list Shows a list of categories
	 *
     * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $category A category record to filter the view by.
     * @param \StephenBungert\SbPortfolio2\Domain\Model\Tag $tag A client record to filter the view by.
	 * @return void
	 */
	public function listAction(\StephenBungert\SbPortfolio2\Domain\Model\Category $category = NULL, \StephenBungert\SbPortfolio2\Domain\Model\Tag $tag = NULL) {
		$this->mergeFlexFormSettings('category');
		$filters = array(
			'category'	=> $category,
			'tag'		=> $tag,
		);

		$portSetup = $this->getPortSetup();

		$categories = $this->categoryRepository->findRecords($filters, $portSetup);

			// Get sub-categories, if required
		if($portSetup['displayAs'] == 2 && $portSetup['beginAt'] >= 0 && $portSetup['depth'] > 1) {
			$categories['records'] = $this->categoryRepository->getSubcategories($categories['records'], $portSetup, $filters);
		}

		$this->view->assign('categories',	$categories['records']);
		$this->view->assign('filtering',	$categories['filterInfo']);
	}

	/**
	 * action list Shows a list of categories
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $category The category to show.
	 * @return void
	 */
	public function singleAction(\StephenBungert\SbPortfolio2\Domain\Model\Category $category) {
		$this->view->assign('category', $category);
	}

	/**
	 * Returns the settings for the action's queries.
	 *
	 * @return $portSetup the records array from settings with any requried changes.
	 */
	public function getPortSetup() {
		$portSetup = $this->settings['category']['records'];

		if (isset($portSetup['beginAt'])) {
			$portSetup['beginAt'] = intval($portSetup['beginAt']);

		} else {
			$portSetup['beginAt'] = 0;
		}

		if (isset($portSetup['depth'])) {
			$portSetup['depth'] = intval($portSetup['depth']);

			if ($portSetup['depth'] < 1) {
				$portSetup['depth'] = 1;
			}

		} else {
			$portSetup['depth'] = 1;
		}

		return $portSetup;
	}

	/**
	 * Does any changes needed for a specific plugin to the FF settings.
	 *
	 * @param array $pluginSettings The plugin's FF settings.
	 * @return array $pluginSettings The plugin's FF settings.
	 */
	public function adjustFlexFormSettings(array $ffSettings) {
			// Tree view is selected
		if ($ffSettings['displayAs'] == 2) {
			if (empty($ffSettings['beginAt'])) { // And no category is selected, set the start category to 0
				$ffSettings['beginAt'] = 0;
			}
		}

		return $ffSettings;
	}
}
?>
