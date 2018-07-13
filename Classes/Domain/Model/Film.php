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
class Tx_SbPortfolio2_Domain_Model_Film extends Tx_SbPortfolio2_Domain_Model_BaseRecord {

	/**
	 * This films' host's id for this film.
	 *
	 * @var string
	 */
	protected $hostid;

	/**
	 * The actual film file that this film record is for. This is a reference to a film in fileadmin.
	 *
	 * @var string
	 */
	protected $film;

	/**
	 * A short description of the film.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * An image to be used as a preview of the film.
	 *
	 * @var Tx_SbPortfolio2_Domain_Model_Image $preview
	 */
	protected $preview;

	/**
	 * What type of film is this? A hosted film (i.e. YouTube), a film file located in fileadmin, or a URL to a film.
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $type;

	/**
	 * Which host is used to host this film: YouTube or Vimeo? More can be added via TypoScript. Different templates will be used in the FE based on who the host is.
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $host;

	/**
	 * This film's URL, this will be used to make a link to the film.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * The path to the film in fileadmin.
	 *
	 * @var string
	 */
	protected $filepath;

	/**
	 * The film's file size in bytes - will be converted in the FE to more human readable form.
	 *
	 * @var integer
	 */
	protected $filesize;

	/**
	 * The film's file name.
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * The film's file type / extension.
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
		#$this->initStorageObjects();
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
		#$this->preview = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the hostid
	 *
	 * @return string $hostid
	 */
	public function getHostid() {
		return $this->hostid;
	}

	/**
	 * Sets the hostid
	 *
	 * @param string $hostid
	 * @return void
	 */
	public function setHostid($hostid) {
		$this->hostid = $hostid;
	}

	/**
	 * Returns the film
	 *
	 * @return string $film
	 */
	public function getFilm() {
		return $this->film;
	}

	/**
	 * Sets the film
	 *
	 * @param string $film
	 * @return void
	 */
	public function setFilm($film) {
		$this->film = $film;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the preview
	 *
	 * @return Tx_SbPortfolio2_Domain_Model_Image $preview
	 */
	public function getPreview() {
		return $this->preview;
	}

	/**
	 * Sets the preview
	 *
	 * @param Tx_SbPortfolio2_Domain_Model_Image $preview
	 * @return void
	 */
	public function setPreview(Tx_SbPortfolio2_Domain_Model_Image $preview) {
		$this->preview = $preview;
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
	 * Returns the host
	 *
	 * @return integer $type
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * Sets the host
	 *
	 * @param integer $host
	 * @return void
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	 * Returns the url
	 *
	 * @return integer $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param integer $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
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