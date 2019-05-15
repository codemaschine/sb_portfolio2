<?php
namespace StephenBungert\SbPortfolio2\Controller;
/***************************************************************
 *	Copyright notice
 *
 *	(c) 2012 Stephen Bungert <stephenbungert@yahoo.de>
 *
 *	All rights reserved
 *
 *	This script is part of the TYPO3 project. The TYPO3 project is
 *	free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	The GNU General Public License can be found at
 *	http://www.gnu.org/copyleft/gpl.html.
 *
 *	This script is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
 *	GNU General Public License for more details.
 *
 *	This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use \StephenBungert\SbPortfolio2\Domain\Repository;
/**
 * The Backend module's controller.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class BeImportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * beImportItemRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\ItemRepository
	 */
	protected $beImportItemRepository;

	/**
	 * beImportClientRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository
	 */
	protected $beImportClientRepository;

	/**
	 * beImportCategoryRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository
	 */
	protected $beImportCategoryRepository;

	/**
	 * An instance of \TYPO3\CMS\Core\Database\QueryGenerator.
	 *
	 * @var \TYPO3\CMS\Core\Database\QueryGenerator
	 */
	protected $queryGen;

	/**
	 * The permissions part of a query for the current BE user.
	 *
	 * @var String
	 */
	protected $permsClause;


	/**
	 * injectBeImportItemRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\ItemRepository $beImportItemRepository
	 * @return void
	 */
	public function injectBeImportItemRepository(\StephenBungert\SbPortfolio2\Domain\Repository\ItemRepository $beImportItemRepository) {
		$this->beImportItemRepository = $beImportItemRepository;
	}

	/**
	 * injectBeImportClientRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository $beImportClientRepository
	 * @return void
	 */
	public function injectBeImportClientRepository(\StephenBungert\SbPortfolio2\Domain\Repository\ClientRepository $beImportClientRepository) {
		$this->beImportClientRepository = $beImportClientRepository;
	}

	/**
	 * injectBeImportCategoryRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository $beImportCategoryRepository
	 * @return void
	 */
	public function injectBeImportCategoryRepository(\StephenBungert\SbPortfolio2\Domain\Repository\CategoryRepository $beImportCategoryRepository) {
		$this->beImportCategoryRepository = $beImportCategoryRepository;
	}

	/**
	 * action import Allows the importation of sb_portfolio records
	 *
	 * @return void
	 */
	public function importAction() {
		$pageId				= intval(\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('id'));
		$this->queryGen		= $this->objectManager->get('TYPO3\CMS\Core\Database\QueryGenerator');
		$this->permsClause	= $GLOBALS['BE_USER']->getPagePermsClause(1);

		$extConfig	= $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$storagePid	= $extConfig['persistence']['storagePid']; // This is the storagePid set for the BE module in TS
		$storagePid = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $storagePid);
		$storagePid = intval($storagePid[0]); // Get first in case of a list

		$branchPids = $this->getBranchUids($pageId);

		// Count records on current page
		$counts = array(
			'categories'		=> $this->beImportCategoryRepository->importCountAll($pageId, 'categories'),
			'clients'			=> $this->beImportClientRepository->importCountAll($pageId, 'clients'),
			'items'				=> $this->beImportItemRepository->importCountAll($pageId, 'items'),
			'categoriesBranch'	=> $this->beImportCategoryRepository->importCountAll($branchPids, 'categories'),
			'clientsBranch'		=> $this->beImportClientRepository->importCountAll($branchPids, 'clients'),
			'itemsBranch'		=> $this->beImportItemRepository->importCountAll($branchPids, 'items')
		);

		$this->view->assignMultiple(array(
			'counts'		=> $counts,
			'beEmail'		=> $GLOBALS['BE_USER']->user['email'], // Not yet used
			'branchPids'	=> $branchPids,
			'storagePid'	=> $storagePid
		));
	}

	/**
	 * Function called by AJAX to import sb_portfolio records.
	 * See: http://typo3.org/documentation/document-library/core-documentation/doc_core_api/4.2.0/view/3/9/
	 *
	 * @param array $params An array of parameters - not yet used.
	 * @param object $ajaxObj The TYPO3 AJAX Object.
	 * @return void
	 */
	public function ajaxImport(array $params, &$ajaxObj) {
		$repo				= $this->getPostVar('sbp2Repo');
		$type				= $this->getPostVar('sbp2Type');
		$pageId				= $this->getPostVar('sbp2PageId');
		$branchIds			= $this->getPostVar('sbp2BranchIds');
		$requestIndex		= $this->getPostVar('sbp2RequestIndex');
		$storageTags		= $this->getPostVar('sbp2StorageTags');
		$storageFiles		= $this->getPostVar('sbp2StorageFiles');
		$storageClients		= $this->getPostVar('sbp2StorageClients');
		$storageCategories	= $this->getPostVar('sbp2StorageCategories');

		if ($pageId > 0) {
			$findPids = $pageId;

			if ($branchIds != 0 && $branchIds != '') {
				$findPids = $branchIds;
			}

			$recRepo	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\StephenBungert\\SbPortfolio2\\Domain\\Repository\\' . $repo . 'Repository');
			$records	= $recRepo->findImportRecords($findPids, $requestIndex, $type);

			if ($records == null) {
				$ajaxObj->setError('sb_portfolio ' . strtolower($repo) . ' not found.');

			} else {
					// Import data
				$importResult = $recRepo->import($records[0], $storageTags, $storageFiles, $storageClients, $storageCategories);

					// Unset a few fields that cause problems when encoding client-side or are just not required
				unset($records[0]['l10n_diffsource']);
				unset($records[0]['fulldescription']);

				$resultData = array(
					'sbpRec'		=> $records[0],
					'children'		=> $importResult[1],	// The child objects created (see the import helper)
					'numOfChildren'	=> count($importResult[1]),
					'iconPath'		=> '../typo3conf/ext/sb_portfolio2/Resources/Public/Icons/'
				);

					$ajaxObj->addContent('Import', json_encode($resultData));
			}

		} else {
			$ajaxObj->setError('Unable to detect the current page ID.');
		}
	}

	/**
	 * Function called by AJAX to create related items for sb_portfolio records that have been imported.
	 * See: http://typo3.org/documentation/document-library/core-documentation/doc_core_api/4.2.0/view/3/9/
	 *
	 * @param array $params An array of parameters - not yet used.
	 * @param object $ajaxObj The TYPO3 AJAX Object.
	 * @return void
	 */
	public function ajaxImportRelated(array $params, &$ajaxObj) {
		$repo			= $this->getPostVar('sbp2Repo');
		$type			= $this->getPostVar('sbp2Type');
		$pageId			= $this->getPostVar('sbp2PageId');
		$branchIds		= $this->getPostVar('sbp2BranchIds');
		$requestIndex	= $this->getPostVar('sbp2RequestIndex');
		$uid			= $this->getPostVar('sbp2RelatedUid');

		if ($pageId > 0) {
			$findPids		= $pageId;
			$findPidsArray	= array($pageId);

			if ($branchIds != 0 && $branchIds != '') {
				$findPids		= $branchIds;
				$findPidsArray	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $branchIds);
			}

			$itemRepo	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\StephenBungert\\SbPortfolio2\\Domain\\Repository\\ItemRepository');
			$recRepo	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\StephenBungert\\SbPortfolio2\\Domain\\Repository\\' . $repo . 'Repository');

			$querySettings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Typo3QuerySettings');
			$querySettings->setStoragePageIds($findPidsArray);
			$itemRepo->setDefaultQuerySettings($querySettings);
			$recRepo->setDefaultQuerySettings($querySettings);

			$relatedType = 'relateditems';

			if ($repo == 'Category') {
				$relatedType = 'catrelateditems';
			}

			$items = $itemRepo->findImportRelatedRecords($findPids, $requestIndex, $uid, $relatedType);

			if ($items == null) {
				$ajaxObj->setError('Related sb_portfolio ' . strtolower($repo) . ' records not found.');

			} else {
					// Import data
				$importResult = $recRepo->importRelated($uid, $pageId, $items);

				$ajaxObj->addContent('ImportRelated', json_encode($importResult));
			}

		} else {
			$ajaxObj->setError('Unable to detect the current page ID.');
		}
	}

	/**
	 * Function called by AJAX to correct traslations fields for sb_portfolio records that have been imported.
	 * See: http://typo3.org/documentation/document-library/core-documentation/doc_core_api/4.2.0/view/3/9/
	 *
	 * @param array $params An array of parameters - not yet used.
	 * @param object $ajaxObj The TYPO3 AJAX Object.
	 * @return void
	 */
	public function ajaxImportTranslation(array $params, &$ajaxObj) {
		$repo			= $this->getPostVar('sbp2Repo');
		$type			= $this->getPostVar('sbp2Type');
		$pageId			= $this->getPostVar('sbp2PageId');
		$branchIds		= $this->getPostVar('sbp2BranchIds');
		$requestIndex	= $this->getPostVar('sbp2RequestIndex');
		$uid			= $this->getPostVar('sbp2TranslationUid');
		$parentUid		= $this->getPostVar('sbp2TranslationParent');

		if ($pageId > 0) {
			$findPids		= $pageId;
			$findPidsArray	= array($pageId);

			if ($branchIds != 0 && $branchIds != '') {
				$findPids		= $branchIds;
				$findPidsArray	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $branchIds);
			}

			$recRepo = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\StephenBungert\\SbPortfolio2\\Domain\\Repository\\' . $repo . 'Repository');

			$querySettings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Extbase\Persistence\Typo3QuerySettings');
			$querySettings->setStoragePageIds($findPidsArray);
			$recRepo->setDefaultQuerySettings($querySettings);

			$record = $recRepo->findOneBySbpuid($parentUid);

			if ($record == null) {
				$ajaxObj->setError(strtolower($repo) . ' parent translation record not found.');

			} else {
					// Import data
				$importResult = $recRepo->importTranslation($parentUid, $uid, $pageId, $record);

				$ajaxObj->addContent('ImportTranslation', json_encode($importResult));
				#$ajaxObj->addContent('ImportTranslation', json_encode('parent translation found!'));
			}

		} else {
			$ajaxObj->setError('Unable to detect the current page ID.');
		}
	}

	/**
	 * Gets a variable fro the GET array.
	 *
	 * @param string $getVar The name of the variable.
	 * @return integer $value The value of the variable.
	 */
	public function getPostVar($getVar) {
		$value	= 0;

		if ($getVar == 'sbp2Type' || $getVar == 'sbp2Repo') {
			$getVar	= trim(\TYPO3\CMS\Core\Utility\GeneralUtility::_POST($getVar));

			if (!empty($getVar)) {
				$value = json_decode($getVar);
			}

		} else {
			if ($getVar == 'sbp2BranchIds') {
				$value = $GLOBALS['TYPO3_DB']->cleanIntList(\TYPO3\CMS\Core\Utility\GeneralUtility::_POST($getVar));

			} else {
				$getVar	= intval(\TYPO3\CMS\Core\Utility\GeneralUtility::_POST($getVar));

				if ($getVar > 0) {
					$value = $getVar;
				}
			}
		}

		return $value;
	}



	/**
	 * Get the UIDs of a branch.
	 *
	 * @param integer $uid The uid of the current page.
	 * @return string $pids The UIDs of the current page and all pages in the branch.es in the branch.
	 */
	public function getBranchUids($uid, $numOfLevels = 100) {
		$uid	= intval($uid);
		$uids	= $uid;


		if ($uid > 0) {
			$numOfLevels = intval($numOfLevels);

			if ($numOfLevels > 0) {
				$uids = $this->queryGen->getTreeList($uid, $numOfLevels, 0, $this->permsClause);
			}
		}

		return $uids;
	}
}
?>
