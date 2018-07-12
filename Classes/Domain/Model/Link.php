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
class Tx_SbPortfolio2_Domain_Model_Link extends Tx_SbPortfolio2_Domain_Model_CombinableRecord {

	/**
	 * What type of links is this? A link to a URL, a file, a page, a portfolio item or client, or items filtered by client, category or tag.
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $type;

	/**
	 * The URL that this link links to.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * The page that this link links to.
	 *
	 * @var string
	 */
	protected $page;

	/**
	 * The file that this link links to.
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * The path to the file (in file admin) that this link links to.
	 *
	 * @var string
	 */
	protected $filepath;

	/**
	 * The file size in bytes of the file that this link links to - will be converted in the FE to more human readable form.
	 *
	 * @var integer
	 */
	protected $filesize;

	/**
	 * The file name of the file that this link links to.
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * The file type / extension of the file that this link links to.
	 *
	 * @var string
	 */
	protected $filetype;

	/**
	 * The catgeory used to filter item's by.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Category $category
	 * @lazy
	 */
	protected $category;

	/**
	 * The client that this link links to or the client used to filter item's by.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Client $client
	 * @lazy
	 */
	protected $client;
	
	/**
	 * The tag used to filter item's by.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Tag $tag
	 * @lazy
	 */
	protected $tag;
	
	/**
	 * The item that this link links to.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Item $item
	 * @lazy
	 */
	protected $item;

	/**
	 * Used to create a nofollow "rel" attribute for this link - external URL's only, to stop search engines indexing / following sponsored links.
	 *
	 * @var boolean
	 */
	protected $nofollow;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		#$this->initStorageObjects();
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
		#$this->client = new Tx_Extbase_Persistence_ObjectStorage();
		
		#$this->tag = new Tx_Extbase_Persistence_ObjectStorage();
		
		#$this->item = new Tx_Extbase_Persistence_ObjectStorage();
		
		#$this->category = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the type
	 *
	 * @return integer $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param integer $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the url
	 *
	 * @return string $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param string $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns the page
	 *
	 * @return string $page
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * Sets the page
	 *
	 * @param string $page
	 * @return void
	 */
	public function setPage($page) {
		$this->page = $page;
	}

	/**
	 * Returns the file
	 *
	 * @return string $file
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Sets the file
	 *
	 * @param string $file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = $file;
	}

	/**
	 * Returns the tag
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Tag $tags
	 */
	public function getTag() {
		return $this->tag;
	}

	/**
	 * Sets the tag
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Tag $tag
	 * @return void
	 */
	public function setTag(Tx_SbPortfolio2_Domain_Model_Tag $tag) {
		$this->tag = $tag;
	}

	/**
	 * Returns the category
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Category $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Category $category
	 * @return void
	 */
	public function setCategory(Tx_SbPortfolio2_Domain_Model_Category $category) {
		$this->category = $category;
	}

	/**
	 * Returns the client
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Client $client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Sets the client
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Client $client
	 * @return	void
	 */
	public function setClient(Tx_SbPortfolio2_Domain_Model_Client $client) {
		$this->client = $client;
	}

	/**
	 * Returns the item
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Item $item
	 */
	public function getItem() {
		return $this->item;
	}

	/**
	 * Sets the item
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Item $item
	 * @return	void
	 */
	public function setItem(Tx_SbPortfolio2_Domain_Model_Item $item) {
		$this->item = $item;
	}

	/**
	 * Returns nofollow
	 *
	 * @return boolean nofollow
	 */
	public function getNofollow() {
		return $this->nofollow;
	}

	/**
	 * Sets nofollow
	 *
	 * @param boolean $inprogress
	 * @return boolean nofollow
	 */
	public function setNofollow($nofollow) {
		$this->nofollow = $nofollow;
	}

	/**
	 * Returns the boolean state of nofollow
	 *
	 * @return boolean nofollow
	 */
	public function isNofollow() {
		return $this->getNofollow();
	}

	/**
	 * Returns filesize
	 *
	 * @return string $filesize
	 */
	public function getFilesize() {
		return $this->filesize;
	}

	/**
	 * Sets filesize
	 *
	 * @param integer $filesize
	 * @return void
	 */
	public function setFilesize($filesize) {
		$this->filesize = $filesize;
	}

	/**
	 * Returns filetype
	 *
	 * @return string $filetype
	 */
	public function getFiletype() {
		return $this->filetype;
	}

	/**
	 * Sets filetype
	 *
	 * @param string $filetype
	 * @return void
	 */
	public function setFiletype($filetype) {
		$this->filetype = $filetype;
	}

	/**
	 * Returns filepath
	 *
	 * @return string $filepath
	 */
	public function getFilepath() {
		return $this->filepath;
	}

	/**
	 * Sets filepath
	 *
	 * @param string $filepath
	 * @return void
	 */
	public function setFilepath($filepath) {
		$this->filepath = $filepath;
	}

	/**
	 * Returns filename
	 *
	 * @return string $filename
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * Sets filename
	 *
	 * @param string $filename
	 * @return void
	 */
	public function setFilename($filename) {
		$this->filename = $filename;
	}
}
?>