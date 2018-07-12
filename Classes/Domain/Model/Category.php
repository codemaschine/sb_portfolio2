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
class Tx_SbPortfolio2_Domain_Model_Category extends Tx_SbPortfolio2_Domain_Model_CoreRecord {

	/**
	 * The category's tags.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Tag>
	 */
	protected $tags;

	/**
	 * The category's image.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Image
	 */
	protected $image;

	/**
	 * The category's links.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Link>
	 * @lazy
	 */
	protected $links;

	/**
	 * The category's files.
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_File>
	 * @lazy
	 */
	protected $files;

	/**
	 * The category's related items.
	 * @lazy
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Item>
	 * @lazy
	 */
	protected $relateditems;

	/**
	 * The category's subcategories (when rendering a tree)
	 * @lazy
	 *
	 * @var Tx_Extbase_Persistence_QueryResult
	 * @lazy
	 */
	protected $children;

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
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->links = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->files = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->relateditems = new Tx_Extbase_Persistence_ObjectStorage();
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
	 * Adds a Link
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Link $link
	 * @return void
	 */
	public function addLink(Tx_SbPortfolio2_Domain_Model_Link $link) {
		$this->links->attach($link);
	}

	/**
	 * Removes a Link
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Link $linkToRemove The Link to be removed
	 * @return void
	 */
	public function removeLink(Tx_SbPortfolio2_Domain_Model_Link $linkToRemove) {
		$this->links->detach($linkToRemove);
	}

	/**
	 * Returns the links
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Link> $links
	 */
	public function getLinks() {
		return $this->links;
	}

	/**
	 * Sets the links
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Link> $links
	 * @return void
	 */
	public function setLinks(Tx_Extbase_Persistence_ObjectStorage $links) {
		$this->links = $links;
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
	 * Adds a relateditem
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Item $item
	 * @return void
	 */
	public function addRelateditem(Tx_SbPortfolio2_Domain_Model_Item $item) {
		$this->relateditems->attach($item);
	}

	/**
	 * Removes a relateditem
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Item $itemToRemove The Link to be removed
	 * @return void
	 */
	public function removeRelateditem(Tx_SbPortfolio2_Domain_Model_Item $itemToRemove) {
		$this->relateditems->detach($itemToRemove);
	}

	/**
	 * Returns relateditems
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Item> $links
	 */
	public function getRelateditems() {
		return $this->relateditems;
	}

	/**
	 * Sets relateditems
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SbPortfolio2_Domain_Model_Item> $relateditems
	 * @return void
	 */
	public function setRelateditems(Tx_Extbase_Persistence_ObjectStorage $relateditems) {
		$this->relateditems = $relateditems;
	}

	/**
	 * Returns the children
	 *
	 * @return Tx_Extbase_Persistence_QueryResult $children
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * Sets the children
	 *
	 * @param Tx_Extbase_Persistence_QueryResult $children
	 * @return void
	 */
	public function setChildren(Tx_Extbase_Persistence_QueryResult $children) {
		$this->children = $children;
	}
}
?>