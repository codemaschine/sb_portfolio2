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
use \StephenBungert\SbPortfolio2\Domain\Model\Import;
/**
 *
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class ClientRepository extends CoreRecordRepository {

	/**
	 * Finds clients with the category $category. Used for getting category related clients.
	 *
	 * @param integer $category The category's UID
	 * @param array $portSetup The TS setup for the query.
	 * @return array An array of items
	 */
	public function findByCategory($category, array $portSetup) {
		$query = $this->createQuery();

		$query->matching($query->contains('categories', $category));

		$query = $this->adjustQueryConstraints($query, $portSetup);
		$query = $this->adjustQueryOrder($query, $portSetup);
		$query = $this->adjustQueryLimit($query, $portSetup);

		return $query->execute();
	}

	/**
	 * Creates an sb_portfolio2 category record from an sb_porfolio client record.
	 *
	 * @param array $sbpClient An client record from sb_portfolio to be created as an sb_portfolio2 client.
	 * @param integer $storageTags The Page UID where Tags should be stored.
	 * @param integer $storageFiles The Page UID where Related Files should be stored.
	 * @param integer $storageClients The Page UID where Clients should be stored.
	 * @param integer $storageCategories The Page UID where Categories should be stored.
	 * @return array An array containing the $sbp2Client and information about any child objects that were created.
	 */
	public function import(array $sbpClient, $storageTags, $storageFiles, $storageClients, $storageCategories) {
		$sbp2Client = array();

		if (!empty($sbpClient))
		{
			$importHelper	= $this->objectManager->get('\StephenBungert\SbPortfolio2\Domain\Model\Import\Helper', $sbpClient);
			$sbp2Client		= $this->objectManager->get('\StephenBungert\SbPortfolio2\Domain\Model\Client');

			$sbp2Client = $importHelper->setCoreFields($sbp2Client, TRUE);

			$sbp2Client->setTitle($sbpClient['title']);
			$sbp2Client->setTitleshort($sbpClient['titleshort']);
			$sbp2Client->setSummary($sbpClient['description']);
			$sbp2Client->setFulldescription($sbpClient['fulldescription']);
			$sbp2Client->setDatetime($sbpClient['datetime']);
			$sbp2Client->setSbpuid($sbpClient['uid']);

			$sbp2Client = $importHelper->setSeoFields($sbp2Client);

				// Image
			if (!empty($sbpClient['image'])) {
				$image = $this->objectManager->get('\StephenBungert\SbPortfolio2\Domain\Model\Image');

				$image = $importHelper->setCoreFields($image);
				$image = $importHelper->setImageFields($image, 'image', $sbpClient['image']);

				$sbp2Client->setImage($image);
			}

				// Link
			if (!empty($sbpClient['url'])) {
				$link = $this->objectManager->get('\StephenBungert\SbPortfolio2\Domain\Model\Link');

				$link = $importHelper->setCoreFields($link);
				$link = $importHelper->setLinkFields($link, 'main link', $sbpClient['url']);

				$sbp2Client->setLinkurl($link);
			}

				// Testimonial
			if (!empty($sbpClient['testimonial'])) {
				$testimonial = $this->objectManager->get('\StephenBungert\SbPortfolio2\Domain\Model\Testimonial');

				$testimonial = $importHelper->setCoreFields($testimonial);
				$testimonial = $importHelper->setTestimonialFields($testimonial);

					// Testimonial image
				if (!empty($sbpClient['testimonial_image']))
				{
					$importHelper->setParentId($importHelper->getChildId());

					$testimonialImage = $this->objectManager->get('\StephenBungert\SbPortfolio2\Domain\Model\Image');
					$testimonialImage = $importHelper->setCoreFields($testimonialImage);
					$testimonialImage = $importHelper->setImageFields($testimonialImage, 'testimonial image', $sbpClient['testimonial_image']);

					$testimonial->setImage($testimonialImage);
				}

				$sbp2Client->setTestimonial($testimonial);
			}

			$this->add($sbp2Client); // Add it...
			$this->persistenceManager->persistAll(); // ...to the database.
		}

		return array($sbp2Client, $importHelper->getChildObjects());
	}
}
?>
