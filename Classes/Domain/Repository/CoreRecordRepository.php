<?php
namespace StephenBungert\SbPortfolio2\Domain\Repository;
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
use \StephenBungert\SbPortfolio2\Domain\Model;

/**
 * A base repository class containing functions common to several repositories in sb_portfolio2
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class CoreRecordRepository extends NpRecordRepository {

	/**
	 * Are records being selected automatically? If FALSE, they are being selected manually.
	 *
	 * @var boolean
	 */
	protected $automatic = TRUE;

	/**
	 * If this is not an automatic selection, are there manual records?
	 *
	 * @var boolean
	 */
	protected $includes = FALSE;

	/**
	 * Constraints for the current query.
	 *
	 * @var array
	 */
	protected $portfolioConstraints = array();



	/**
	 * Sets automatic.
	 *
	 * @param boolean $automatic The selection property of the TS/FF records array.
	 * @return void.
	 */
	public function setAutomatic($automatic) {
		if (is_bool($automatic)) {
			$this->automatic = $automatic;
		}
	}

	/**
	 * Returns the boolean state of automatic.
	 *
	 * @return boolean $automatic
	 */
	public function isAutomatic() {
		return $this->automatic;
	}

	/**
	 * Sets includes.
	 *
	 * @param boolean $includes The new constraint for the query.
	 * @return void.
	 */
	public function setIncludes($includes) {
		if (is_bool($includes)) {
			$this->includes = $includes;
		}
	}

	/**
	 * Returns the boolean state of includes.
	 *
	 * @return boolean $includes
	 */
	public function hasIncludes() {
		return $this->includes;
	}

	/**
	 * Adds a portfolio query constraint.
	 *
	 * @param mixed $newConstraint The new constraint for the query.
	 * @return void.
	 */
	public function setPortfolioConstraints($newConstraint) {
		$this->portfolioConstraints[] = $newConstraint;
	}

	/**
	 * Gets portfolioConstraints
	 *
	 * @return array $portfolioConstraints The constraints for the current query.
	 */
	public function getPortfolioConstraints() {
		if ($this->countPortfolioConstraints() == 1) {
			return $this->portfolioConstraints[0];

		} else {
			return $this->portfolioConstraints;
		}
	}

	/**
	 * Counts the number of portfolioConstraints
	 *
	 * @return integer The number of constraints.
	 */
	public function countPortfolioConstraints() {
		return count($this->portfolioConstraints);
	}



	/**
	 * Finds records with the tag $tag.
	 *
	 * @param integer $tag The tag's UID.
	 * @param array $portSetup The TS setup for the query.
	 * @return array An array of records.
	 */
	public function findByTags($tag, array $portSetup) {
		// Get cats with the $tag
		$catUids	= $this->findCategoriesByTag($tag);
		$query		= $this->createQuery();

		if (!empty($catUids)) { // If there are categories with the tag
			$this->setPortfolioConstraints($query->logicalOr($query->contains('tags', $tag), $query->contains('categories', $catUids)));

		} else { // Else, just check records for the tag - no cats have the tag
			$this->setPortfolioConstraints($query->contains('tags', $tag));
		}

		$query = $this->adjustQueryConstraints($query, $portSetup);
		$query = $this->adjustQueryOrder($query, $portSetup);
		$query = $this->adjustQueryLimit($query, $portSetup);

		return $query->execute();
	}

	/**
	 * Finds records with the category $category.
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $category The category.
	 * @param array $portSetup The TS setup for the query.
	 * @return array An array of records.
	 */
	public function findByCategories(\StephenBungert\SbPortfolio2\Domain\Model\Category $category, array $portSetup) {
		$query = $this->createQuery();

		$this->setPortfolioConstraints($query->contains('categories', $category));

		$query = $this->adjustQueryConstraints($query, $portSetup);
		$query = $this->adjustQueryOrder($query, $portSetup);
		$query = $this->adjustQueryLimit($query, $portSetup);

		return $query->execute();
	}

	/**
	 * Finds categories with a mm relation to $tag. Used when filtering records by a tag,
	 * as records inherit tags from catgeories.
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Tag $tag The current filtering tag.
	 * @return string A string of category UIDs.
	 */
	protected function findCategoriesByTag(\StephenBungert\SbPortfolio2\Domain\Model\Tag $tag) {
		$categoryRepository	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository');
		$categories			= $categoryRepository->findByTags($tag); // This is the findByTags() method in the category repository!
		$categoryUids		= '';

		if (count($categories) >= 1) {
			foreach ($categories as $key => $value) {
				$categoryUids .= $value->getUid() . ',';
			}

			if (!empty($categoryUids)) {
				$categoryUids = trim($categoryUids, ',');
			}
		}

		unset($categoryRepository);
		unset($categories);
		return $categoryUids;
	}

	/**
	 * Finds records, either based on filtering or not.
     *
	 * @param array $filters The filter objects, client, category and tag.
	 * @param array $portSetup The TS setup for the current sb_portfolio2 plugin.
	 * @return array An array of records and filter information.
	 */
	public function findRecords(array $filters, array $portSetup) {
		$records			= array();
		$filters['enabled']	= TRUE;

		$this->setSelectionType($portSetup);

		if (isset($filters['client']) && $filters['client'] !== NULL) {
			$records				= $this->findByClient($filters['client'], $portSetup);
			$filterInfo['type']		= 'client';

		} else if (isset($filters['category']) && $filters['category'] !== NULL) {
			$records				= $this->findByCategories($filters['category'], $portSetup);
			$filters['type']		= 'category';

		} else if (isset($filters['tag']) && $filters['tag'] !== NULL) {
			$records				= $this->findByTags($filters['tag'], $portSetup);
			$filters['type']		= 'tag';
		} else {
			$records				= $this->findWithConstraints($portSetup);
			$filters['enabled']		= FALSE;
		}

		return array('records' => $records, 'filterInfo' => $filters);
	}

	/**
	 * Finds records related to the record with the UID = $uid,.
	 *
	 * @param integer $uid The current record's uid
	 * @param array $options An array with options for getting the related records.
	 * @return array An array of records and filter information.
	 */
	public function findRelated($uid, array $options) {
		$query = $this->createQuery();
		$query->matching($query->contains('categories', $category));

		$temp = $query->execute();
		return array('cdscdd');
	}

	/**
	 * Finds all records, possibly restricting the search if TS/FF settings require it
	 *
	 * @param array $portSetup The TS setup for the query.
	 * @return array An array of items
	 */
	public function findWithConstraints(array $portSetup) {
		$this->setSelectionType($portSetup);

		$query = $this->createQuery();

		$query = $this->adjustQueryConstraints($query, $portSetup);
		$query = $this->adjustQueryOrder($query, $portSetup);
		$query = $this->adjustQueryLimit($query, $portSetup);

		return $query->execute();
	}

	 /**
	 * Finds sb_portfolio categories, clients, or items
	 *
	 * @param mixed $pids The pids to use in the query.
	 * @param integer $requestIndex The offset to use for the limit.
	 * @param string $type A table suffix.
	 * @return array An array of records
	 */
	public function findImportRecords($pids, $requestIndex, $type = 'items') {
		$type = strtolower(trim($type));

		if ($type !== 'items' && $type !== 'clients' && $type !== 'categories') {
			$type = 'items';
		}

		$pids = $this->getPidClause($pids);

		$statement = 'SELECT * FROM tx_sbportfolio_' . $type . ' WHERE ' . $pids . ' AND hidden = 0 AND deleted = 0 ORDER BY title ASC LIMIT ' . intval($requestIndex) . ', 1';

		$query = $this->createQuery();
		//$query->getQuerySettings()->setReturnRawQueryResult(true);

		return $query->statement($statement)->execute(TRUE);
	}

	 /**
	 * Counts sb_portfolio categories, clients, or items on the page with the $pid
	 *
	 * @param integer $pids The pid to use in the query.
	 * @param string $type A table suffix.
	 * @return mixed
	 */
	public function importCountAll($pids, $type = 'items') {
		$type = strtolower(trim($type));

		if ($type !== 'items' && $type !== 'clients' && $type !== 'categories') {
			$type = 'items';
		}

		$pids = $this->getPidClause($pids);

		$statement = 'SELECT COUNT(*) FROM tx_sbportfolio_' . $type . ' WHERE ' . $pids . ' AND hidden = 0 AND deleted = 0';

		$query = $this->createQuery();

		//$query->getQuerySettings()->setReturnRawQueryResult(true);

		$result = $query->statement($statement)->execute(TRUE);

		return $result[0]['COUNT(*)'];
	}

	/**
	 * Creates related sb_portfolio2 items for sb_portfolio2 records.
	 *
	 * @param integer $uid The uid of the sb_portfolio item that has related items.
	 * @param integer $pageId The pid to use in the query.
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $items The items found.
	 * @return string $result The result of the attempt to related items.
	 */
	public function importRelated($uid, $pageId, \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $items) {
		$sbp2Item	= $this->findOneBySbpuid($uid);
		$result		= array('success' => FALSE, 'relatedrecords' => array());

		if ($sbp2Item != NULL) {
			foreach ($items as $itemKey => $itemRec) {
				$sbp2Item->addRelateditem($itemRec);

				$relRecData = array(
					'title' =>	$itemRec->getTitle(),
					'uid' =>	$itemRec->getUid()
				);

				$result['relatedrecords'][] = $relRecData;
			}

			$this->persistenceManager->persistAll();

			$recData = array(
				'title' =>		$sbp2Item->getTitle(),
				'uid' => 		$sbp2Item->getUid(),
				'origUid' => 	$uid
			);

			$result['success']				= TRUE;
			$result['record']				= $recData;
			$result['numOfRelatedrecords']	= count($items);
		}

		return $result;
	}

	/**
	 * Creates the correct parent id for trsanslated records.
	 *
	 * @param integer $parentUid The uid of the sb_portfolio record that was the parent.
	 * @param integer $uid The uid of the sb_portfolio record that was a translation of the record.
	 * @param integer $pageId The pid to use in the query.
	 * @param object $record The parent default translation sb_portfolio2 record.
	 * @return string $result The result of the attempt to related items.
	 */
	public function importTranslation($parentUid, $uid, $pageId, $record) {
		$sbp2TranslatedRecord = $this->findOneBySbpuid($uid);

		$result = array('success' => FALSE);

		if ($sbp2TranslatedRecord != NULL) {
			$sbp2TranslatedRecord->setL10nparent($record->getUid());

			$this->persistenceManager->persistAll();

			$recData = array(
				'title'		=>		$sbp2TranslatedRecord->getTitle(),
				'uid'		=> 		$sbp2TranslatedRecord->getUid(),
				'parentUid'	=> 		$parentUid,
				'sbpuid'	=> 		$sbp2TranslatedRecord->getSbpuid()
			);

			$result['success']		= TRUE;
			$result['translation']	= $recData;
		}

		return $result;
	}

	/**
	 * Get PID clause for a query
	 *
	 * @param mixed $pids Either a single pid or a string (comma sep.)
	 * @return string $pids A string for a query.
	 */
	protected function getPidClause($pids) {
		if (strpos($pids, ',') !== FALSE) {
			$pids = 'pid IN (' . $GLOBALS['TYPO3_DB']->cleanIntList($pids) . ')';
		} else {
			$pids = 'pid = ' . intval($pids);
		}

		return $pids;
	}

	/**
	 * Sets the query limit if required.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @param array $portSetup The TS setup for the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query, modified.
	 */
	public function adjustQueryOrder(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query, array $portSetup) {
		if ($this->isAutomatic()) {
			if (isset($portSetup['sortBy']) && isset($portSetup['sortDir'])) {
				$sortDir = strtoupper($portSetup['sortDir']);

				if ($sortDir == 'ASC') {
					$sortDir = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;

				} else {
					$sortDir = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
				}

				$sortBy = strtolower($portSetup['sortBy']);

				if (!array_key_exists($sortBy, $portSetup['sortByFields'])) {
					$sortBy = 'crdate';
				}

				$query->setOrderings(array($sortBy => $sortDir));
			}
		}

		return $query;
	}

	/**
	 * Sets the query limit if required.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @param array $portSetup The TS setup for the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query, modified.
	 */
	public function adjustQueryLimit(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query, array $portSetup) {
		if ($this->isAutomatic()) {
			$limit = intval($portSetup['limit']);

			if ($limit >= 1) {
				$query->setLimit($limit);
			}
		}

		return $query;
	}

	/**
	 * Adjusts the query based on properties of this repo's models. Over-ride this function
	 * in the model specific repo if you queries need model specific constraints (see the item repo as an example).
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @param array $portSetup The TS setup for the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query, modified.
	 */
	public function adjustQueryConstraints(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query, array $portSetup) {
		$query = $this->adjustQueryConstraintsCommon($query, $portSetup);
		$query = $this->setQueryConstraints($query);

		return $query;
	}

	/**
	 * Makes changes to the query used by all plugins.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @param array $portSetup The TS setup for the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query, modified.
	 */
	public function adjustQueryConstraintsCommon(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query, array $portSetup) {
		if (!$this->isAutomatic() && $this->hasIncludes()) { // Manual record selection
			$inValues = $this->getValuesForInClause($portSetup['include']);
			$this->setPortfolioConstraints($query->in('uid', $inValues));
		}
		else if ($this->isAutomatic() && !empty($portSetup['exclude'])) { // Automatic record selction
			$inValues = $this->getValuesForInClause($portSetup['exclude']);
			$this->setPortfolioConstraints($query->logicalNot($query->in('uid', $inValues)));
		}

		$query = $this->setQueryConstraints($query);

		return $query;
	}

	/**
	 * Adds the creaated query constraint objects to the current query.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query, modified.
	 */
	public function setQueryConstraints(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query) {
		$numOfConstraints = $this->countPortfolioConstraints();

		if ($numOfConstraints > 0){
			$constraints = $this->getPortfolioConstraints();

			if ($numOfConstraints == 1){
				$query->matching($constraints);

			} else if ($numOfConstraints > 1){
				$query->matching($query->logicalAnd($constraints));
			}

			$this->portfolioConstraints = array();
		}

		return $query;
	}

	/**
	 * Adjusts the query based on properties of this repo's models.
	 *
	 * @param string $intList A comma sep. list of integers.
	 * @return array $intListArray $intList cleaned and exploded to an array.
	 */
	public function getValuesForInClause($intList) {
		$intListCleanded	= $GLOBALS['TYPO3_DB']->cleanIntList($intList);
		$intListArray		= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $intListCleanded);

		return $intListArray;
	}

	/**
	 * Sets settings to do with the selection type.
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
	}
}
?>
