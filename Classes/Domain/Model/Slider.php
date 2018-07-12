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
class Tx_SbPortfolio2_Domain_Model_Slider extends Tx_SbPortfolio2_Domain_Model_CoreRecord {

	/**
	 * What type of slider is this? A link to a URL, a page, a portfolio item, category, client, items filtered by client, category or tag, or clients filtered by category or tag.
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $type;

	/**
	 * The URL that this slider links to.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * The page that this slider links to.
	 *
	 * @var string
	 */
	protected $page;

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
	 * The slider's summary.
	 *
	 * @var string
	 */
	protected $summary;

	/**
	 * The slider's description.
	 *
	 * @var string
	 */
	protected $description;
	
	/**
	 * The slider's image.
	 *
	 * @var string
	 */
	protected $image;

	/**
	 * The slider's rollover image.
	 *
	 * @var string
	 */
	protected $imagero;
	
	/**
	 * The slider's icon.
	 *
	 * @var string
	 */
	protected $icon;
	
	/**
	 * The slider's logo.
	 *
	 * @var string
	 */
	protected $logo;


	
	
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
	 * Returns summary
	 *
	 * @return string $summary
	 */
	public function getSummary() {
		return $this->summary;
	}

	/**
	 * Sets summary
	 *
	 * @param string $summary
	 * @return void
	 */
	public function setSummary($summary) {
		$this->summary = $summary;
	}

	/**
	 * Returns description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the image
	 *
	 * @return $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param string $image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns the imagero
	 *
	 * @return $imagero
	 */
	public function getImagero() {
		return $this->imagero;
	}

	/**
	 * Sets the image
	 *
	 * @param string $imagero
	 * @return void
	 */
	public function setImagero($imagero) {
		$this->imagero = $imagero;
	}

	/**
	 * Returns the icon
	 *
	 * @return $icon
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets the icon
	 *
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * Returns the logo
	 *
	 * @return $logo
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * Sets the logo
	 *
	 * @param string $logo
	 * @return void
	 */
	public function setLogo($logo) {
		$this->logo = $logo;
	}
}
?>