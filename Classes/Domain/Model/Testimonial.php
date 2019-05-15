<?php
namespace StephenBungert\SbPortfolio2\Domain\Model;
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
class Testimonial extends BaseRecord {

	/**
	 * The testimonial title. Mainly used in the BE in table listings, as testimonials don't really need a title.
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * The testimonial's main body text.
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $body;

	/**
	 * The name of the person who has made the testimonial.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The date that the testimonial was made.
	 *
	 * @var DateTime
	 */
	protected $datetime;

	/**
	 * The company that the person making the testimonial works for.
	 *
	 * @var string
	 */
	protected $company;

	/**
	 * The position in the company that the person making the testimonial holds.
	 *
	 * @var string
	 */
	protected $position;

	/**
	 * An image of the person making the testimonial, or the company logo.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Image
	 * @lazy
	 */
	protected $image;

	/**
	 * The uid of this testimonial's parent client.
	 *
	 * @var integer
	 */
	protected $client;

	/**
	 * The uid of this testimonial's parent item.
	 *
	 * @var integer
	 */
	protected $item;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the body
	 *
	 * @return string $body
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * Sets the body
	 *
	 * @param string $body
	 * @return void
	 */
	public function setBody($body) {
		$this->body = $body;
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the datetime
	 *
	 * @return DateTime $datetime
	 */
	public function getDatetime() {
		return $this->datetime;
	}

	/**
	 * Sets the datetime
	 *
	 * @param DateTime $datetime
	 * @return void
	 */
	public function setDatetime($datetime) {
		$this->datetime = $datetime;
	}

	/**
	 * Returns the company
	 *
	 * @return string $company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the company
	 *
	 * @param string $company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the position
	 *
	 * @return string $position
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Sets the position
	 *
	 * @param string $position
	 * @return void
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * Returns the image
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Image $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Image $image
	 * @return void
	 */
	public function setImage(Image $image) {
		$this->image = $image;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns client
	 *
	 * @return integer client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Sets client
	 *
	 * @param integer client
	 */
	public function setClient($client) {
		$this->client = $client;
	}

	/**
	 * Returns item
	 *
	 * @return integer item
	 */
	public function getItem() {
		return $this->item;
	}

	/**
	 * Sets item
	 *
	 * @param integer item
	 */
	public function setItem($item) {
		$this->item = $item;
	}
}
?>
