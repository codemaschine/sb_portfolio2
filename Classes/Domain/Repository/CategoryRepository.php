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
class Tx_SbPortfolio2_Domain_Repository_CategoryRepository extends Tx_SbPortfolio2_Domain_Repository_CoreRecordRepository {

	/**
	 * If this is a tree rendeing or a flat list.
	 *
	 * @var boolean
	 */
	protected $tree = FALSE;
	
	
	
	/**
	 * Sets tree.
	 *
	 * @param boolean $tree The displayAs property of the TS/FF records array - 2 = tree, 1 = list
	 * @return void.
	 */
	public function setTree($tree) {
		if (is_bool($tree)) {
			$this->tree = $tree;
		}
	}
	
	/**
	 * Returns the boolean state of tree.
	 *
	 * @return boolean $tree
	 */
	public function isTree() {
		return $this->tree;
	}
	
	/**
	 * Finds categories with the tag $tag
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Tag $tag The current filtering tag.
	 * @return array The matching categories.
	 */
	public function findByTags(Tx_SbPortfolio2_Domain_Model_Tag $tag) {
		$query = $this->createQuery();
		$query->matching($query->contains('tags', $tag));

		return $query->execute();
	}

	/**
	 * Creates an sb_portfolio2 category record from an sb_porfolio category record.
	 *
	 * @param array $sbpCat An category record from sb_portfolio to be created as an sb_portfolio2 category.
	 * @param integer $storageTags The Page UID where Tags should be stored.
	 * @param integer $storageFiles The Page UID where Related Files should be stored.
	 * @param integer $storageClients The Page UID where Clients should be stored.
	 * @param integer $storageCategories The Page UID where Categories should be stored.
	 * @return array An array containing the $sbp2Item and information about any child objects that were created.
	 */
	public function import(array $sbpCat, $storageTags, $storageFiles, $storageClients, $storageCategories) {
		$sbp2Cat = array();

		if (!empty($sbpCat))
		{
			$importHelper	= $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Import_Helper', $sbpCat);
			$sbp2Cat		= $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Category');

			$sbp2Cat = $importHelper->setCoreFields($sbp2Cat, TRUE);

			$sbp2Cat->setTitle($sbpCat['title']);
			$sbp2Cat->setTitleshort($sbpCat['titleshort']);
			$sbp2Cat->setSummary($sbpCat['description']);
			$sbp2Cat->setSbpuid($sbpCat['uid']);

				// Image
			if (!empty($sbpCat['image'])) {
				$image = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Image');

				$image = $importHelper->setCoreFields($image);
				$image = $importHelper->setImageFields($image, 'image', $sbpCat['image']);

				$sbp2Cat->setImage($image);
			}

				// Tags
			if (!empty($sbpCat['tags'])) {
				$sepTags	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $sbpCat['tags'], TRUE);
				$tagRepo	= $this->objectManager->get('Tx_SbPortfolio2_Domain_Repository_TagRepository');

					// Change the PID so that the queries work
				$querySettings = $this->objectManager->create('\TYPO3\CMS\Extbase\Persistence\Typo3QuerySettings');
				$querySettings->setStoragePageIds(array($sbpCat['pid']));
				$tagRepo->setDefaultQuerySettings($querySettings);

				foreach ($sepTags as $tagNumber => $tagTitle) {
					$tag = $tagRepo->findOneByTitle($tagTitle);

					if ($tag == NULL) { // Not found, make a new record
						$tag = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Tag');

						$tag = $importHelper->setCoreFields($tag);
						$tag = $importHelper->setTagFields($tag, $tagTitle);
						$tag->setPid($storageTags);
					}

					$sbp2Cat->addTag($tag);

					$importHelper->addChildObject('tag', 'Tag', $tag->getTitle());
				}
			}

			$this->add($sbp2Cat); // Add it...
			$this->persistenceManager->persistAll(); // ...to the database.
		}

		return array($sbp2Cat, $importHelper->getChildObjects());
	}

	/**
	 * Recursively gets subcategories ,if required, upto a maximum depth set in TS.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $categories The current depth's categories.
	 * @param array $portSetup The TS setup for the query.
	 * @param array $filterBy An array with the name of the filter var and its value.
	 * @param integer $currentDepth The current depth level.
	 * @return void
	 */
	public function getSubcategories(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $categories, array $portSetup, array $filterBy, $currentDepth = 1) {
		if($currentDepth < $portSetup['depth'] && count($categories) > 0) {
			foreach ($categories as $category) {
				$portSetup['beginAt'] 	= intval($category->getUid());
				$childCats				= $this->findRecords($filterBy, $portSetup);
				$newDepth				= $currentDepth + 1;
				
				$childCats['records'] = $this->getSubcategories($childCats['records'], $portSetup, $filterBy, $newDepth);
				
				$category->setChildren($childCats['records']);
			}
		}
		
		return $categories;
	}

	/**
	 * Adjusts the query based on properties of this repo's models.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @param array $portSetup The TS setup for the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query The query object making the query, modified.
	 */
	public function adjustQueryConstraints(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query, array $portSetup) {
			// If createing a tree, set the starting level
		if ($portSetup['beginAt'] >= 0 && $this->isTree()) {
			$this->setPortfolioConstraints($query->equals('parentcat', intval($portSetup['beginAt'])));
		}
		
		$query = $this->adjustQueryConstraintsCommon($query, $portSetup);
		$query = $this->setQueryConstraints($query);

		return $query;
	}

	/**
	 * Sets settings to do with the selection type. Overwrites the same function in CoreRecordRepository
	 *
	 * @param array $portSetup The TS setup for the query.
	 * @return void.
	 */
	public function setSelectionType(array $portSetup) {
		if ($portSetup['selection'] == 2) { // Manual record selection
			$this->setAutomatic(FALSE);
			
			if (!empty($portSetup['include'])) { // Manual record selection
				$this->setIncludes(TRUE);
			}
		}
		
		if ($portSetup['displayAs'] == 2) { // Display as tree
			$this->setTree(TRUE);
		}
	}
}
?>