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
class Tx_SbPortfolio2_Domain_Repository_ItemRepository extends Tx_SbPortfolio2_Domain_Repository_CoreRecordRepository {

	/**
	 * Finds items with the client $client
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Client $client The client.
	 * @param array $portSetup The TS setup for the query.
	 * @return array An array of items
	 */
	public function findByClient(Tx_SbPortfolio2_Domain_Model_Client $client, array $portSetup) {
		$query = $this->createQuery();

		$this->setPortfolioConstraints($query->equals('client', $client));

		$query = $this->adjustQueryConstraints($query, $portSetup);
		$query = $this->adjustQueryOrder($query, $portSetup);
		$query = $this->adjustQueryLimit($query, $portSetup);

		return $query->execute();
	}

	/**
	 * Finds items with the category $category. Used for getting category related items.
	 *
	 * @param integer $category The category's UID
	 * @param array $portSetup The TS setup for the query.
	 * @return array An array of items
	 */
	public function findByCategory($category, array $portSetup) {
		$query = $this->createQuery();

		$this->setPortfolioConstraints($query->contains('categories', $category));

		$query = $this->adjustQueryConstraints($query, $portSetup);
		$query = $this->adjustQueryOrder($query, $portSetup);
		$query = $this->adjustQueryLimit($query, $portSetup);

		return $query->execute();
	}

	/**
	 * Creates an sb_portfolio2 item record from an sb_porfolio item record.
	 *
	 * @param array $sbpItem An item record from sb_portfolio to be created as an sb_portfolio2 item.
	 * @param integer $storageTags The Page UID where Tags should be stored.
	 * @param integer $storageFiles The Page UID where Related Files should be stored.
	 * @param integer $storageClients The Page UID where Clients should be stored.
	 * @param integer $storageCategories The Page UID where Categories should be stored.
	 * @return array An array containing the $sbp2Item and information about any child objects that were created.
	 */
	public function import(array $sbpItem, $storageTags, $storageFiles, $storageClients, $storageCategories) {
		$sbp2Item = array();

		if (!empty($sbpItem))
		{
			$importHelper	= $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Import_Helper', $sbpItem);
			$sbp2Item		= $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Item');

			$sbp2Item = $importHelper->setCoreFields($sbp2Item, TRUE);

			$sbp2Item->setTitle($sbpItem['title']);
			$sbp2Item->setTitleshort($sbpItem['titleshort']);
			$sbp2Item->setSummary($sbpItem['summary']);
			$sbp2Item->setFulldescription($sbpItem['fulldescription']);
			$sbp2Item->setDatetime($sbpItem['datetime']);
			$sbp2Item->setInprogress($sbpItem['in_progress']);
			$sbp2Item->setFeatured($sbpItem['featured']);
			$sbp2Item->setSbpuid($sbpItem['uid']);

			$sbp2Item = $importHelper->setSeoFields($sbp2Item);

				// Images
			if (!empty($sbpItem['image'])) {
				$sepImages = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $sbpItem['image'], TRUE);

				foreach ($sepImages as $imageNumber => $imagePath) {
					$image = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Image');

					$image = $importHelper->setCoreFields($image);
					$image = $importHelper->setImageFields($image, 'image', $imagePath, $imageNumber + 1);

					$sbp2Item->addImage($image);
				}
			}

				// Image Folders
			if (!empty($sbpItem['image_folders'])) {
				$imageFolder = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_ImageFolder');

				$imageFolder = $importHelper->setCoreFields($imageFolder);
				$imageFolder = $importHelper->setImageFolderFields($imageFolder);

				$sbp2Item->addImagefolder($imageFolder);
			}

				// Preview
			if (!empty($sbpItem['preview'])) {
				$preview = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Image');

				$preview = $importHelper->setCoreFields($preview);
				$preview = $importHelper->setImageFields($preview, 'preview image', $sbpItem['preview']);

				$sbp2Item->setPreview($preview);
			}

				// Films
			if (!empty($sbpItem['youtube'])) {
				$film = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Film');

				$film = $importHelper->setCoreFields($film);
				$film = $importHelper->setFilmFields($film);

				$sbp2Item->addFilm($film);
			}

				// Files
			if (!empty($sbpItem['files'])) {
				$sepFiles = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $sbpItem['files'], TRUE);

				foreach ($sepFiles as $fileNumber => $filePath) {
					$file = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_File');

					$file = $importHelper->setCoreFields($file);
					$file = $importHelper->setFileFields($file, $filePath, $fileNumber + 1);
					$file->setPid($storageFiles);

					$sbp2Item->addFile($file);
				}
			}

				// Link
			if (!empty($sbpItem['linkurl'])) {
				$link = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Link');

				$link = $importHelper->setCoreFields($link);
				$link = $importHelper->setLinkFields($link, 'main link', $sbpItem['linkurl']);

				$sbp2Item->setLinkurl($link);
			}

				// Testimonial
			if (!empty($sbpItem['testimonial'])) {
				$testimonial = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Testimonial');

				$testimonial = $importHelper->setCoreFields($testimonial);
				$testimonial = $importHelper->setTestimonialFields($testimonial);

					// Testimonial image
				if (!empty($sbpItem['testimonial_image']))
				{
					$importHelper->setParentId($importHelper->getChildId());

					$testimonialImage = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Image');
					$testimonialImage = $importHelper->setCoreFields($testimonialImage);
					$testimonialImage = $importHelper->setImageFields($testimonialImage, 'testimonial image', $sbpItem['testimonial_image']);

					$testimonial->setImage($testimonialImage);
				}

				$sbp2Item->setTestimonial($testimonial);
			}

			$countInSession	= 0;
			$countInRepo	= 0;
			$countNew		= 0;

				// Tags
			if (!empty($sbpItem['tags'])) {
				$sepTags	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $sbpItem['tags'], TRUE);
				$tagRepo	= $this->objectManager->get('Tx_SbPortfolio2_Domain_Repository_TagRepository');

					// Change the PID so that the queries work
				$querySettings = $this->objectManager->create('\TYPO3\CMS\Extbase\Persistence\Typo3QuerySettings');
				$querySettings->setStoragePageIds(array($storageTags));
				$tagRepo->setDefaultQuerySettings($querySettings);

				foreach ($sepTags as $tagNumber => $tagTitle) {
					$tag = $tagRepo->findOneByTitle($tagTitle);

					if ($tag == NULL) { // Not found, make a new record
						$tag = $this->objectManager->get('Tx_SbPortfolio2_Domain_Model_Tag');

						$tag = $importHelper->setCoreFields($tag);
						$tag = $importHelper->setTagFields($tag, $tagTitle);
						$tag->setPid($storageTags);
					}

					$sbp2Item->addTag($tag);

					$importHelper->addChildObject('tag', 'Tag', $tag->getTitle());
				}
			}

				// Categories
			if ($sbpItem['category'] > 0) {
				$sbpCats = $this->getMmUids($sbpItem['uid']);

				if (count($sbpCats) > 0) {
					$sbpCatUids = $this->getSbpUids($sbpCats);

					if (!empty($sbpCatUids)) {
						$sepCats	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $sbpCatUids, TRUE);
						$catRepo	= $this->objectManager->get('Tx_SbPortfolio2_Domain_Repository_CategoryRepository');

							// Change the PID so that the queries work
						$querySettings = $this->objectManager->create('\TYPO3\CMS\Extbase\Persistence\Typo3QuerySettings');
						$querySettings->setStoragePageIds(array($storageCategories));
						$catRepo->setDefaultQuerySettings($querySettings);

						foreach ($sepCats as $catIndex => $catUid) {
							$cat = $catRepo->findOneBySbpuid($catUid);

							if ($cat != NULL) {
								$sbp2Item->addCategory($cat);

								$importHelper->addChildObject('category', 'Category', $cat->getTitle());
							}
						}
					}
				}
			}

				// Client
			if ($sbpItem['client'] > 0) {
				$sbpClient = $this->getMmUids($sbpItem['uid'], 'clients', TRUE);

				if (count($sbpClient) > 0) {
					$sbpClientUids = $this->getSbpUids($sbpClient);

					if (!empty($sbpClientUids)) {
						$sepClient	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $sbpClientUids, TRUE);
						$sepClient	= $sepClient[0]; // Should only be one
						$clientRepo	= $this->objectManager->get('Tx_SbPortfolio2_Domain_Repository_ClientRepository');

							// Change the PID so that the queries work
						$querySettings = $this->objectManager->create('\TYPO3\CMS\Extbase\Persistence\Typo3QuerySettings');
						$querySettings->setStoragePageIds(array($storageClients));
						$clientRepo->setDefaultQuerySettings($querySettings);

						$client = $clientRepo->findOneBySbpuid($sepClient['uid']);

						if ($client != NULL) {
							$sbp2Item->setClient($client);

							$importHelper->addChildObject('client', 'Client', $client->getTitle());
						}
					}
				}
			}


			$this->add($sbp2Item); // Add it...
			$this->persistenceManager->persistAll(); // ...to the database.
		}

		return array($sbp2Item, $importHelper->getChildObjects());
	}

	 /**
	 * Converts an array of uid_foreigns to a string.
	 *
	 * @param array $sbpUids The uid_foreigns that need making into a string.
	 * @param boolean $returnAsArray Should an array be returned or a string?
	 * @return mixed $uids A comma sep. string of uids or an array of uids.
	 */
	public function getSbpUids(array $sbpUids, $returnAsArray = FALSE) {
		$uids = '';

		if ($returnAsArray) {
			$uidArray = array();

			foreach ($sbpUids as $row => $value) {
				$uidArray[] = $value['uid_foreign'];
			}

			$uids = $uidArray;

		} else {
			$uidString = '';

			foreach ($sbpUids as $row => $value) {
				$uidString .= $value['uid_foreign'] . ',';
			}

			$uids = trim($uidString, ',');
		}

		return $uids;
	}

	 /**
	 * Finds sb_portfolio MM relations for an sb_portfolio item
	 *
	 * @param integer $uid The uid of the item.
	 * @param string $type A string: either "clients" or "categories".
	 * @param boolean $onlyOne Should a limit be set so that only the first result is returned?
	 * @return array An array of records
	 */
	public function getMmUids($uid, $type = 'categories', $onlyOne = false) {
		$type = strtolower(trim($type));

		if ($type !== 'categories' && $type !== 'clients' && $type !== 'relateditems') {
			$type = 'categories';
		}

		$limit = '';

		if ($onlyOne === true) {
			$limit = ' LIMIT 0,1';
		}

		$statement = 'SELECT uid_foreign FROM tx_sbportfolio_' . $type . '_mm WHERE uid_local = ' . intval($uid) . ' ORDER BY sorting ASC' . $limit;

		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		return $query->statement($statement)->execute();
	}

	 /**
	 * Finds imported sb_portfolio2 records that have relationship to other imported sb_portfolio2 records.
	 *
	 * @param integer $pids The pids to use in the query.
	 * @param integer $requestIndex The offset to use for the limit.
	 * @param integer $uid The uid of the sb_portfolio item that has related items.
	 * @param string $type A table suffix.
	 * @return array An array of records
	 */
	public function findImportRelatedRecords($pids, $requestIndex, $uid, $type = 'relateditems') {
		$type = strtolower(trim($type));

		if ($type !== 'relateditems' && $type !== 'catrelateditems') {
			$type = 'relateditems';
		}

		$sbpRelatedUids = $this->getMmUids($uid, $type);

		if (count($sbpRelatedUids) > 0) {
			$sbpItemUids = $this->getSbpUids($sbpRelatedUids, TRUE);

			if (!empty($sbpItemUids)) {

				$query = $this->createQuery();
				$query->matching($query->in('sbpuid', $sbpItemUids));

				return $query->execute();
			}
		}
	}

	/**
	 * Adjusts the query based on properties of this repo's models.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\Query $query The query object making the query.
	 * @param array $portSetup The TS setup for the query.
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query The query object making the query, modified.
	 */
	public function adjustQueryConstraints(\TYPO3\CMS\Extbase\Persistence\Generic\Query $query, array $portSetup) {
		if ($this->isAutomatic()) {
			$featured	= -1;
			$inprogress	= -1;

			if (isset($portSetup['featured'])) {
				if ($portSetup['featured'] == 'exclude') {
					$featured = 0;

				} else if ($portSetup['featured'] == 'only') {
					$featured = 1;
				} // Else 'include' - don't add any constraint
			}

			if (isset($portSetup['inprogress'])) {
				if ($portSetup['inprogress'] == 'exclude') {
					$inprogress = 0;

				} else if ($portSetup['inprogress'] == 'only') {
					$inprogress = 1;
				} // Else 'include' - don't add any constraint
			}

			if ($featured >= 0 || $inprogress >= 0) {

				/* ??? why is this loaded ??? */
				/* added is statement */
				$currentConstraints			= $query->getConstraint();
				if ($currentConstraints !== null) {
					$currentConstraintsClass	= get_Class($currentConstraints);
				}


				if ($featured >= 0 && $inprogress >= 0) { // Featured && Inprogress
					$this->setPortfolioConstraints($query->equals('inprogress', $inprogress));
					$this->setPortfolioConstraints($query->equals('featured', $featured));

				} else if ($featured == -1 && $inprogress >= 0) { // Inprogress
					$this->setPortfolioConstraints($query->equals('inprogress', $inprogress));

				} else if ($featured >= 0 && $inprogress == -1) { // Featured
					$this->setPortfolioConstraints($query->equals('featured', $featured));
				}
			}
		}

		$query = $this->adjustQueryConstraintsCommon($query, $portSetup);
		$query = $this->setQueryConstraints($query);

		return $query;
	}
}
?>
