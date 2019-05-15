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
class Client extends CoreRecord {

	/**
	 * The date that this client became a client and you started working for them.
	 *
	 * @var DateTime
	 */
	protected $datetime;

	/**
	 * The client's links.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Link>
	 * @lazy
	 */
	protected $links;

	/**
	 * The client's testimonial.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Testimonial
	 * @lazy
	 */
	protected $testimonial;

	/**
	 * An image representing the client.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Image
	 * @lazy
	 */
	protected $image;

	/**
	 * The client's files.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\File>
	 * @lazy
	 */
	protected $files;

	/**
	 * The client's categories.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * The client's tags.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Tag>
	 * @lazy
	 */
	protected $tags;

	/**
	 * The client's main link - could be to a website, file etc.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Link
	 * @lazy
	 */
	protected $linkurl;

	/**
	 * The client's logo.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Image
	 * @lazy
	 */
	protected $logo;


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
		$this->links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->tags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the links
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Link $links
	 */
	public function getLinks() {
		return $this->links;
	}

	/**
	 * Sets the links
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Link $links
	 * @return void
	 */
	public function setLinks(Link $links) {
		$this->links = $links;
	}

	/**
	 * Returns the testimonial
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Testimonial $testimonial
	 */
	public function getTestimonial() {
		return $this->testimonial;
	}

	/**
	 * Sets the testimonial
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Testimonial $testimonial
	 * @return void
	 */
	public function setTestimonial(Testimonial $testimonial) {
		$this->testimonial = $testimonial;
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
	 * Returns the next client
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Client
	 */
	public function getNext() {
		return $this->next;
	}

	/**
	 * Sets the next client
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Client $next
	 * @return void
	 */
	public function setNext(Client $next) {
		$this->next = $next;
	}

	/**
	 * Returns the previous client
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Client
	 */
	public function getPrevious() {
		return $this->previous;
	}

	/**
	 * Sets the previous client
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Client $previous
	 * @return void
	 */
	public function setPrevious(Client $previous) {
		$this->previous = $previous;
	}

	/**
	 * Adds a File
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\File $file
	 * @return void
	 */
	public function addFile(File $file) {
		$this->files->attach($file);
	}

	/**
	 * Removes a File
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\File $fileToRemove The File to be removed
	 * @return void
	 */
	public function removeFile(File $fileToRemove) {
		$this->files->detach($fileToRemove);
	}

	/**
	 * Returns the files
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\File> $files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Sets the files
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\File> $files
	 * @return void
	 */
	public function setFiles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $files) {
		$this->files = $files;
	}

	/**
	 * Adds a Category
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $category
	 * @return void
	 */
	public function addCategory(Category $category) {
		$this->categories->attach($category);
	}

	/**
	 * Removes a Category
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Category $categoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeCategory(Category $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}

	/**
	 * Returns the categories
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Category> $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Sets the categories
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Category> $categories
	 * @return void
	 */
	public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Adds a Tag
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Tag $tag
	 * @return void
	 */
	public function addTag(Tag $tag) {
		$this->tags->attach($tag);
	}

	/**
	 * Removes a Tag
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Tag $tagToRemove The Tag to be removed
	 * @return void
	 */
	public function removeTag(Tag $tagToRemove) {
		$this->tags->detach($tagToRemove);
	}

	/**
	 * Returns the tags
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Tag> $tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Sets the tags
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Tag> $tags
	 * @return void
	 */
	public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags) {
		$this->tags = $tags;
	}
	/**
	 * Returns linkurl
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Link $link
	 */
	public function getLinkurl() {
		return $this->linkurl;
	}

	/**
	 * Sets linkurl
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Link $link
	 * @return void
	 */
	public function setLinkurl(Link $link) {
		$this->linkurl = $link;
	}
	/**
	 * Returns the logo
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Image $logo
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * Sets the logo
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Image $logo
	 * @return void
	 */
	public function setLogo(Image $logo) {
		$this->logo = $logo;
	}
}
?>
