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
class Tx_SbPortfolio2_Domain_Model_Client extends Tx_SbPortfolio2_Domain_Model_CoreRecord {

	/**
	 * The date that this client became a client and you started working for them.
	 *
	 * @var DateTime
	 */
	protected $datetime;

	/**
	 * The client's links.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Link>
	 * @lazy
	 */
	protected $links;

	/**
	 * The client's testimonial.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Testimonial
	 * @lazy
	 */
	protected $testimonial;

	/**
	 * An image representing the client.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Image
	 * @lazy
	 */
	protected $image;

	/**
	 * The client's files.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_File>
	 * @lazy
	 */
	protected $files;

	/**
	 * The client's categories.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * The client's tags.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Tag>
	 * @lazy
	 */
	protected $tags;
	
	/**
	 * The client's main link - could be to a website, file etc.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Link
	 * @lazy
	 */
	protected $linkurl;

	/**
	 * The client's logo.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Image
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
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->links = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->files = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->categories = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * @return Tx_SbPortfolio2_Domain_Model_Link $links
	 */
	public function getLinks() {
		return $this->links;
	}

	/**
	 * Sets the links
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Link $links
	 * @return void
	 */
	public function setLinks(Tx_SbPortfolio2_Domain_Model_Link $links) {
		$this->links = $links;
	}

	/**
	 * Returns the testimonial
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial
	 */
	public function getTestimonial() {
		return $this->testimonial;
	}

	/**
	 * Sets the testimonial
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial
	 * @return void
	 */
	public function setTestimonial(Tx_SbPortfolio2_Domain_Model_Testimonial $testimonial) {
		$this->testimonial = $testimonial;
	}
	
	/**
	 * Returns the image
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Image $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Image $image
	 * @return void
	 */
	public function setImage(Tx_SbPortfolio2_Domain_Model_Image $image) {
		$this->image = $image;
	}

	/**
	 * Returns the next client
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Client
	 */
	public function getNext() {
		return $this->next;
	}

	/**
	 * Sets the next client
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Client $next
	 * @return void
	 */
	public function setNext(Tx_SbPortfolio2_Domain_Model_Client $next) {
		$this->next = $next;
	}

	/**
	 * Returns the previous client
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Client
	 */
	public function getPrevious() {
		return $this->previous;
	}

	/**
	 * Sets the previous client
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Client $previous
	 * @return void
	 */
	public function setPrevious(Tx_SbPortfolio2_Domain_Model_Client $previous) {
		$this->previous = $previous;
	}

	/**
	 * Adds a File
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_File $file
	 * @return void
	 */
	public function addFile(Tx_SbPortfolio2_Domain_Model_File $file) {
		$this->files->attach($file);
	}

	/**
	 * Removes a File
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_File $fileToRemove The File to be removed
	 * @return void
	 */
	public function removeFile(Tx_SbPortfolio2_Domain_Model_File $fileToRemove) {
		$this->files->detach($fileToRemove);
	}

	/**
	 * Returns the files
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_File> $files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Sets the files
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_File> $files
	 * @return void
	 */
	public function setFiles(Tx_Extbase_Persistence_ObjectStorage $files) {
		$this->files = $files;
	}

	/**
	 * Adds a Category
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Category $category
	 * @return void
	 */
	public function addCategory(Tx_SbPortfolio2_Domain_Model_Category $category) {
		$this->categories->attach($category);
	}

	/**
	 * Removes a Category
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Category $categoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeCategory(Tx_SbPortfolio2_Domain_Model_Category $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}

	/**
	 * Returns the categories
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Category> $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Sets the categories
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Category> $categories
	 * @return void
	 */
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Adds a Tag
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Tag $tag
	 * @return void
	 */
	public function addTag(Tx_SbPortfolio2_Domain_Model_Tag $tag) {
		$this->tags->attach($tag);
	}

	/**
	 * Removes a Tag
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Tag $tagToRemove The Tag to be removed
	 * @return void
	 */
	public function removeTag(Tx_SbPortfolio2_Domain_Model_Tag $tagToRemove) {
		$this->tags->detach($tagToRemove);
	}

	/**
	 * Returns the tags
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Tag> $tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Sets the tags
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Tag> $tags
	 * @return void
	 */
	public function setTags(Tx_Extbase_Persistence_ObjectStorage $tags) {
		$this->tags = $tags;
	}
	/**
	 * Returns linkurl
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Link $link
	 */
	public function getLinkurl() {
		return $this->linkurl;
	}

	/**
	 * Sets linkurl
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Link $link
	 * @return void
	 */
	public function setLinkurl(Tx_SbPortfolio2_Domain_Model_Link $link) {
		$this->linkurl = $link;
	}
	/**
	 * Returns the logo
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Image $logo
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * Sets the logo
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Image $logo
	 * @return void
	 */
	public function setLogo(Tx_SbPortfolio2_Domain_Model_Image $logo) {
		$this->logo = $logo;
	}
}
?>