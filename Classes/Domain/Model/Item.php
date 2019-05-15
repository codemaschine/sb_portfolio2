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
class Item extends CombinableCoreRecord {

	/**
	 * The date this item was "published" / "went live" or was completed.
	 *
	 * @var DateTime
	 */
	protected $datetime;

	/**
	 * Is this item a featured item?
	 *
	 * @var boolean
	 */
	protected $featured;

	/**
	 * Is this item "in progress", and not yet published/live - useful for displaying current projects.
	 *
	 * @var boolean
	 */
	protected $inprogress;

	/**
	 * The item's testimonial.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Testimonial
	 * @lazy
	 */
	protected $testimonial;

	/**
	 * The item's tags.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Tag>
	 * @lazy
	 */
	protected $tags;

	/**
	 * The item's image folders (folders in fileadmin that contain images that are to be displayed with this item).
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\ImageFolder>
	 * @lazy
	 */
	protected $imagefolders;

	/**
	 * The item's links.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Link>
	 * @lazy
	 */
	protected $links;

	/**
	 * The item's files.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\File>
	 * @lazy
	 */
	protected $files;

	/**
	 * The item's films.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Film>
	 * @lazy
	 */
	protected $films;

	/**
	 * The item's categories.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * The item's client - the individual or company this item was made for.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Client
	 * @lazy
	 */
	protected $client;

	/**
	 * The item's images.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Image>
	 * @lazy
	 */
	protected $images;

	/**
	 * What type of item is this? A normal item, a shortcut to a page or a link to a remote URL.
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $type;

	/**
	 * The URL that this item should link to instead of showing the Single display.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * The page that this item should link to instead of showing the Single display.
	 *
	 * @var string
	 */
	protected $page;

	/**
	 * A flickr Photo Set ID
	 *
	 * @var string
	 */
	protected $setid;

	/**
	 * An image to be used as a preview of the item.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Image
	 * @lazy
	 */
	protected $preview;

	/**
	 * The item's related items.
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Item>
	 * @lazy
	 */
	protected $relateditems;

	/**
	 * The item's main link - could be to a website, file etc.
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Model\Link
	 * @lazy
	 */
	protected $linkurl;

	/**
	 * The file that this item links to.
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * The path to the file (in file admin) that this item links to.
	 *
	 * @var string
	 */
	protected $filepath;

	/**
	 * The file size in bytes of the file that this item links to - will be converted in the FE to more human readable form.
	 *
	 * @var integer
	 */
	protected $filesize;

	/**
	 * The file name of the file that this item links to.
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * The file type / extension of the file that this item links to.
	 *
	 * @var string
	 */
	protected $filetype;



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

		$this->imagefolders = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->films = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

		$this->relateditems = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
		$this->tags			= $tags;
		$this->tagTypeSet	= FALSE;
	}

	/**
	 * Adds a ImageFolder
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\ImageFolder $imagefolder
	 * @return void
	 */
	public function addImagefolder(ImageFolder $imagefolder) {
		$this->imagefolders->attach($imagefolder);
	}

	/**
	 * Removes a ImageFolder
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\ImageFolder $imagefolderToRemove The ImageFolder to be removed
	 * @return void
	 */
	public function removeImagefolder(ImageFolder $imagefolderToRemove) {
		$this->imagefolders->detach($imagefolderToRemove);
	}

	/**
	 * Returns the imagefolders
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\ImageFolder> $imagefolders
	 */
	public function getImagefolders() {
		return $this->imagefolders;
	}

	/**
	 * Sets the imagefolders
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\ImageFolder> $imagefolders
	 * @return void
	 */
	public function setImagefolders(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $imagefolders) {
		$this->imagefolders = $imagefolders;
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
	 * Adds a Film
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Film $film
	 * @return void
	 */
	public function addFilm(Film $film) {
		$this->films->attach($film);
	}

	/**
	 * Removes a Film
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Film $filmToRemove The Film to be removed
	 * @return void
	 */
	public function removeFilm(Film $filmToRemove) {
		$this->films->detach($filmToRemove);
	}

	/**
	 * Returns the films
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Film> $films
	 */
	public function getFilms() {
		return $this->films;
	}

	/**
	 * Sets the films
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Film> $films
	 * @return void
	 */
	public function setFilms(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $films) {
		$this->films = $films;
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
	 * Adds a Image
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Image $image
	 * @return void
	 */
	public function addImage(Image $image) {
		$this->images->attach($image);
	}

	/**
	 * Removes a Image
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Image $imageToRemove The Image to be removed
	 * @return void
	 */
	public function removeImage(Image $imageToRemove) {
		$this->images->detach($imageToRemove);
	}

	/**
	 * Returns the images
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Image> $images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Sets the images
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StephenBungert\SbPortfolio2\Domain\Model\Image> $images
	 * @return void
	 */
	public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images) {
		$this->images = $images;
	}

	/**
	 * Returns the featured
	 *
	 * @return boolean featured
	 */
	public function getFeatured() {
		return $this->featured;
	}

	/**
	 * Sets the featured
	 *
	 * @param boolean $featured
	 */
	public function setFeatured($featured) {
		$this->featured = $featured;
	}

	/**
	 * Returns the boolean state of featured
	 *
	 * @return boolean featured
	 */
	public function isFeatured() {
		return $this->getFeatured();
	}

	/**
	 * Returns the inprogress
	 *
	 * @return boolean inprogress
	 */
	public function getInprogress() {
		return $this->inprogress;
	}

	/**
	 * Sets the inprogress
	 *
	 * @param boolean $inprogress
	 * @return boolean inprogress
	 */
	public function setInprogress($inprogress) {
		$this->inprogress = $inprogress;
	}

	/**
	 * Returns the boolean state of inprogress
	 *
	 * @return boolean inprogress
	 */
	public function isInprogress() {
		return $this->getInprogress();
	}

	/**
	 * Returns the client
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Client $client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * Sets the client
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Client $client
	 * @return	void
	 */
	public function setClient(Client $client) {
		$this->client = $client;
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
	 * Returns the setid
	 *
	 * @return string $setid
	 */
	public function getSetid() {
		return $this->setid;
	}

	/**
	 * Sets the setid
	 *
	 * @param string $setid
	 * @return void
	 */
	public function setSetid($setid) {
		$this->setid = $setid;
	}

	/**
	 * Returns the preview
	 *
	 * @return \StephenBungert\SbPortfolio2\Domain\Model\Image $preview
	 */
	public function getPreview() {
		return $this->preview;
	}

	/**
	 * Sets the preview
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Model\Image $preview
	 * @return void
	 */
	public function setPreview(Image $preview) {
		$this->preview = $preview;
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
