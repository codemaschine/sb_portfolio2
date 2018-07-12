<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Stephen Bungert <stephenbungert@yahoo.de>
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_SbPortfolio2_Domain_Model_Item.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage SB Portfolio 2
 *
 * @author Stephen Bungert <stephenbungert@yahoo.de>
 */
class Tx_SbPortfolio2_Domain_Model_ItemTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SbPortfolio2_Domain_Model_Item
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_SbPortfolio2_Domain_Model_Item();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getTitleshortReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleshortForStringSetsTitleshort() { 
		$this->fixture->setTitleshort('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitleshort()
		);
	}
	
	/**
	 * @test
	 */
	public function getSummaryReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSummaryForStringSetsSummary() { 
		$this->fixture->setSummary('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSummary()
		);
	}
	
	/**
	 * @test
	 */
	public function getFulldescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFulldescriptionForStringSetsFulldescription() { 
		$this->fixture->setFulldescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFulldescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getDatetimeReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setDatetimeForDateTimeSetsDatetime() { }
	
	/**
	 * @test
	 */
	public function getFeaturedReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getFeatured()
		);
	}

	/**
	 * @test
	 */
	public function setFeaturedForBooleanSetsFeatured() { 
		$this->fixture->setFeatured(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getFeatured()
		);
	}
	
	/**
	 * @test
	 */
	public function getInprogressReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getInprogress()
		);
	}

	/**
	 * @test
	 */
	public function setInprogressForBooleanSetsInprogress() { 
		$this->fixture->setInprogress(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getInprogress()
		);
	}
	
	/**
	 * @test
	 */
	public function getTestimonialReturnsInitialValueForTx_SbPortfolio2_Domain_Model_Testimonial() { }

	/**
	 * @test
	 */
	public function setTestimonialForTx_SbPortfolio2_Domain_Model_TestimonialSetsTestimonial() { }
	
	/**
	 * @test
	 */
	public function getTagsReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_Tag() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getTags()
		);
	}

	/**
	 * @test
	 */
	public function setTagsForObjectStorageContainingTx_SbPortfolio2_Domain_Model_TagSetsTags() { 
		$tag = new Tx_SbPortfolio2_Domain_Model_Tag();
		$objectStorageHoldingExactlyOneTags = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneTags->attach($tag);
		$this->fixture->setTags($objectStorageHoldingExactlyOneTags);

		$this->assertSame(
			$objectStorageHoldingExactlyOneTags,
			$this->fixture->getTags()
		);
	}
	
	/**
	 * @test
	 */
	public function addTagToObjectStorageHoldingTags() {
		$tag = new Tx_SbPortfolio2_Domain_Model_Tag();
		$objectStorageHoldingExactlyOneTag = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneTag->attach($tag);
		$this->fixture->addTag($tag);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneTag,
			$this->fixture->getTags()
		);
	}

	/**
	 * @test
	 */
	public function removeTagFromObjectStorageHoldingTags() {
		$tag = new Tx_SbPortfolio2_Domain_Model_Tag();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($tag);
		$localObjectStorage->detach($tag);
		$this->fixture->addTag($tag);
		$this->fixture->removeTag($tag);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getTags()
		);
	}
	
	/**
	 * @test
	 */
	public function getImagefoldersReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_ImageFolder() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getImagefolders()
		);
	}

	/**
	 * @test
	 */
	public function setImagefoldersForObjectStorageContainingTx_SbPortfolio2_Domain_Model_ImageFolderSetsImagefolders() { 
		$imagefolder = new Tx_SbPortfolio2_Domain_Model_ImageFolder();
		$objectStorageHoldingExactlyOneImagefolders = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneImagefolders->attach($imagefolder);
		$this->fixture->setImagefolders($objectStorageHoldingExactlyOneImagefolders);

		$this->assertSame(
			$objectStorageHoldingExactlyOneImagefolders,
			$this->fixture->getImagefolders()
		);
	}
	
	/**
	 * @test
	 */
	public function addImagefolderToObjectStorageHoldingImagefolders() {
		$imagefolder = new Tx_SbPortfolio2_Domain_Model_ImageFolder();
		$objectStorageHoldingExactlyOneImagefolder = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneImagefolder->attach($imagefolder);
		$this->fixture->addImagefolder($imagefolder);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneImagefolder,
			$this->fixture->getImagefolders()
		);
	}

	/**
	 * @test
	 */
	public function removeImagefolderFromObjectStorageHoldingImagefolders() {
		$imagefolder = new Tx_SbPortfolio2_Domain_Model_ImageFolder();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($imagefolder);
		$localObjectStorage->detach($imagefolder);
		$this->fixture->addImagefolder($imagefolder);
		$this->fixture->removeImagefolder($imagefolder);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getImagefolders()
		);
	}
	
	/**
	 * @test
	 */
	public function getLinksReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_Link() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLinks()
		);
	}

	/**
	 * @test
	 */
	public function setLinksForObjectStorageContainingTx_SbPortfolio2_Domain_Model_LinkSetsLinks() { 
		$link = new Tx_SbPortfolio2_Domain_Model_Link();
		$objectStorageHoldingExactlyOneLinks = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLinks->attach($link);
		$this->fixture->setLinks($objectStorageHoldingExactlyOneLinks);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLinks,
			$this->fixture->getLinks()
		);
	}
	
	/**
	 * @test
	 */
	public function addLinkToObjectStorageHoldingLinks() {
		$link = new Tx_SbPortfolio2_Domain_Model_Link();
		$objectStorageHoldingExactlyOneLink = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneLink->attach($link);
		$this->fixture->addLink($link);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLink,
			$this->fixture->getLinks()
		);
	}

	/**
	 * @test
	 */
	public function removeLinkFromObjectStorageHoldingLinks() {
		$link = new Tx_SbPortfolio2_Domain_Model_Link();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($link);
		$localObjectStorage->detach($link);
		$this->fixture->addLink($link);
		$this->fixture->removeLink($link);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLinks()
		);
	}
	
	/**
	 * @test
	 */
	public function getFilesReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_File() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function setFilesForObjectStorageContainingTx_SbPortfolio2_Domain_Model_FileSetsFiles() { 
		$file = new Tx_SbPortfolio2_Domain_Model_File();
		$objectStorageHoldingExactlyOneFiles = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFiles->attach($file);
		$this->fixture->setFiles($objectStorageHoldingExactlyOneFiles);

		$this->assertSame(
			$objectStorageHoldingExactlyOneFiles,
			$this->fixture->getFiles()
		);
	}
	
	/**
	 * @test
	 */
	public function addFileToObjectStorageHoldingFiles() {
		$file = new Tx_SbPortfolio2_Domain_Model_File();
		$objectStorageHoldingExactlyOneFile = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFile->attach($file);
		$this->fixture->addFile($file);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneFile,
			$this->fixture->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function removeFileFromObjectStorageHoldingFiles() {
		$file = new Tx_SbPortfolio2_Domain_Model_File();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($file);
		$localObjectStorage->detach($file);
		$this->fixture->addFile($file);
		$this->fixture->removeFile($file);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getFiles()
		);
	}
	
	/**
	 * @test
	 */
	public function getFilmsReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_Film() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getFilms()
		);
	}

	/**
	 * @test
	 */
	public function setFilmsForObjectStorageContainingTx_SbPortfolio2_Domain_Model_FilmSetsFilms() { 
		$film = new Tx_SbPortfolio2_Domain_Model_Film();
		$objectStorageHoldingExactlyOneFilms = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFilms->attach($film);
		$this->fixture->setFilms($objectStorageHoldingExactlyOneFilms);

		$this->assertSame(
			$objectStorageHoldingExactlyOneFilms,
			$this->fixture->getFilms()
		);
	}
	
	/**
	 * @test
	 */
	public function addFilmToObjectStorageHoldingFilms() {
		$film = new Tx_SbPortfolio2_Domain_Model_Film();
		$objectStorageHoldingExactlyOneFilm = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFilm->attach($film);
		$this->fixture->addFilm($film);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneFilm,
			$this->fixture->getFilms()
		);
	}

	/**
	 * @test
	 */
	public function removeFilmFromObjectStorageHoldingFilms() {
		$film = new Tx_SbPortfolio2_Domain_Model_Film();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($film);
		$localObjectStorage->detach($film);
		$this->fixture->addFilm($film);
		$this->fixture->removeFilm($film);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getFilms()
		);
	}
	
	/**
	 * @test
	 */
	public function getCategoriesReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_Category() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function setCategoriesForObjectStorageContainingTx_SbPortfolio2_Domain_Model_CategorySetsCategories() { 
		$category = new Tx_SbPortfolio2_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategories = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategories->attach($category);
		$this->fixture->setCategories($objectStorageHoldingExactlyOneCategories);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCategories,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategories() {
		$category = new Tx_SbPortfolio2_Domain_Model_Category();
		$objectStorageHoldingExactlyOneCategory = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->addCategory($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategories() {
		$category = new Tx_SbPortfolio2_Domain_Model_Category();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($category);
		$localObjectStorage->detach($category);
		$this->fixture->addCategory($category);
		$this->fixture->removeCategory($category);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function getClientReturnsInitialValueForTx_SbPortfolio2_Domain_Model_Client() { }

	/**
	 * @test
	 */
	public function setClientForTx_SbPortfolio2_Domain_Model_ClientSetsClient() { }
	
	/**
	 * @test
	 */
	public function getImagesReturnsInitialValueForObjectStorageContainingTx_SbPortfolio2_Domain_Model_Image() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getImages()
		);
	}

	/**
	 * @test
	 */
	public function setImagesForObjectStorageContainingTx_SbPortfolio2_Domain_Model_ImageSetsImages() { 
		$image = new Tx_SbPortfolio2_Domain_Model_Image();
		$objectStorageHoldingExactlyOneImages = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneImages->attach($image);
		$this->fixture->setImages($objectStorageHoldingExactlyOneImages);

		$this->assertSame(
			$objectStorageHoldingExactlyOneImages,
			$this->fixture->getImages()
		);
	}
	
	/**
	 * @test
	 */
	public function addImageToObjectStorageHoldingImages() {
		$image = new Tx_SbPortfolio2_Domain_Model_Image();
		$objectStorageHoldingExactlyOneImage = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneImage->attach($image);
		$this->fixture->addImage($image);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneImage,
			$this->fixture->getImages()
		);
	}

	/**
	 * @test
	 */
	public function removeImageFromObjectStorageHoldingImages() {
		$image = new Tx_SbPortfolio2_Domain_Model_Image();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($image);
		$localObjectStorage->detach($image);
		$this->fixture->addImage($image);
		$this->fixture->removeImage($image);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getImages()
		);
	}
	
}
?>