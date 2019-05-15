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
class Image extends BaseRecord {

	/**
	 * A short description of the image.
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * The actual image that this image record is for. This is a reference to an image in fileadmin.
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $imagefile;

	/**
	 * A caption for this image.
	 *
	 * @var string
	 */
	protected $caption;

	/**
	 * The path to the image in fileadmin.
	 *
	 * @var string
	 */
	protected $imagepath;

	/**
	 * The image's image size in bytes - will be converted in the FE to more human readable form.
	 *
	 * @var integer
	 */
	protected $imagesize;

	/**
	 * The image's image name.
	 *
	 * @var string
	 */
	protected $imagename;

	/**
	 * The image's image type / extension.
	 *
	 * @var string
	 */
	protected $imagetype;

	/**
	 * The image's width in pixels.
	 *
	 * @var integer
	 */
	protected $imagewidth;

	/**
	 * The image's height in pixels.
	 *
	 * @var integer
	 */
	protected $imageheight;

	/**
	 * The image's orientation: 0 = Square, 1 = Landscape, 2 = Portrait. Could be used to change the TS image config based on image orientation.
	 *
	 * @var integer
	 */
	protected $imageorientation;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {

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
	 * Returns imagefile
	 *
	 * @return string $imagefile
	 */
	public function getImagefile() {
		return $this->imagefile;
	}

	/**
	 * Sets imagefile
	 *
	 * @param string $imagefile
	 * @return void
	 */
	public function setImagefile($imagefile) {
		$this->imagefile = $imagefile;
	}

	/**
	 * Returns the caption
	 *
	 * @return string $caption
	 */
	public function getCaption() {
		return $this->caption;
	}

	/**
	 * Sets the caption
	 *
	 * @param string $caption
	 * @return void
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}


	/**
	 * Returns imagesize
	 *
	 * @return string $imagesize
	 */
	public function getImagesize() {
		return $this->imagesize;
	}

	/**
	 * Sets imagesize
	 *
	 * @param integer $imagesize
	 * @return void
	 */
	public function setImagesize($imagesize) {
		$this->imagesize = $imagesize;
	}

	/**
	 * Returns imagetype
	 *
	 * @return string $imagetype
	 */
	public function getImagetype() {
		return $this->imagetype;
	}

	/**
	 * Sets imagetype
	 *
	 * @param string $imagetype
	 * @return void
	 */
	public function setImagetype($imagetype) {
		$this->imagetype = $imagetype;
	}

	/**
	 * Returns imagepath
	 *
	 * @return string $imagepath
	 */
	public function getImagepath() {
		return $this->imagepath;
	}

	/**
	 * Sets imagepath
	 *
	 * @param string $imagepath
	 * @return void
	 */
	public function setImagepath($imagepath) {
		$this->imagepath = $imagepath;
	}

	/**
	 * Returns imagename
	 *
	 * @return string $imagename
	 */
	public function getImagename() {
		return $this->imagename;
	}

	/**
	 * Sets imagename
	 *
	 * @param string $imagename
	 * @return void
	 */
	public function setImagename($imagename) {
		$this->imagename = $imagename;
	}

	/**
	 * Returns imagewidth
	 *
	 * @return string $imagewidth
	 */
	public function getImagewidth() {
		return $this->imagewidth;
	}

	/**
	 * Sets imagewidth
	 *
	 * @param string $imagewidth
	 * @return void
	 */
	public function setImagewidth($imagewidth) {
		$this->imagewidth = $imagewidth;
	}

	/**
	 * Returns imageheight
	 *
	 * @return string $imageheight
	 */
	public function getImageheight() {
		return $this->imageheight;
	}

	/**
	 * Sets imageheight
	 *
	 * @param string $imageheight
	 * @return void
	 */
	public function setImageheight($imageheight) {
		$this->imageheight = $imageheight;
	}

	/**
	 * Returns imageorientation
	 *
	 * @return string $imageorientation
	 */
	public function getImageorientation() {
		return $this->imageorientation;
	}

	/**
	 * Sets imageorientation
	 *
	 * @param string $imageorientation
	 * @return void
	 */
	public function setImageorientation($imageorientation) {
		$this->imageorientation = $imageorientation;
	}
}
?>
