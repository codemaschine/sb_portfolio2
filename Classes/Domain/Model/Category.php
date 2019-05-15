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
class Category extends CoreRecord {

	/**
	 * The category's tags.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Tag>
	 */
	protected $tags;

	/**
	 * The category's image.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Image
	 */
	protected $image;

	/**
	 * The category's links.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Link>
	 * @lazy
	 */
	protected $links;

	/**
	 * The category's files.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\File>
	 * @lazy
	 */
	protected $files;

	/**
	 * The category's related items.
	 * @lazy
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Item>
	 * @lazy
	 */
	protected $relateditems;

	/**
	 * The category's subcategories (when rendering a tree)
	 * @lazy
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
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
		$this->tags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->relateditems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Adds a Link
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Link $link
	 * @return void
	 */
	public function addLink(Link $link) {
		$this->links->attach($link);
	}

	/**
	 * Removes a Link
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Link $linkToRemove The Link to be removed
	 * @return void
	 */
	public function removeLink(Link $linkToRemove) {
		$this->links->detach($linkToRemove);
	}

	/**
	 * Returns the links
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Link> $links
	 */
	public function getLinks() {
		return $this->links;
	}

	/**
	 * Sets the links
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Link> $links
	 * @return void
	 */
	public function setLinks(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $links) {
		$this->links = $links;
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
	 * Adds a relateditem
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Item $item
	 * @return void
	 */
	public function addRelateditem(Item $item) {
		$this->relateditems->attach($item);
	}

	/**
	 * Removes a relateditem
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Item $itemToRemove The Link to be removed
	 * @return void
	 */
	public function removeRelateditem(Item $itemToRemove) {
		$this->relateditems->detach($itemToRemove);
	}

	/**
	 * Returns relateditems
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Item> $links
	 */
	public function getRelateditems() {
		return $this->relateditems;
	}

	/**
	 * Sets relateditems
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Item> $relateditems
	 * @return void
	 */
	public function setRelateditems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $relateditems) {
		$this->relateditems = $relateditems;
	}

	/**
	 * Returns the children
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $children
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * Sets the children
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $children
	 * @return void
	 */
	public function setChildren(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $children) {
		$this->children = $children;
	}
}
?>
