<?php
namespace StephenBungert\SbPortfolio2\Domain\Model\Manifest;
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
 * Reads mainfest files and returns file data arrays.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class File extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * The name of manifest files.
	 *
	 * @var string
	 */
	const MANIFEST_FILE_NAME = 'sbp_manifest.xml';

	/**
	 * An integer representation of the TYPO3 version.
	 *
	 * @var integer
	 */
	protected $t3Version;

	/**
	 * Required fields for a manifest file in sb_portfolio2.
	 *
	 * @var array
	 */
	protected $reqFields = array(
		'imagetype'			=> '',
		'imagesize'			=> '0',
		'imagename'			=> '',
		'imagepath'			=> '',
		'imagewidth'		=> '0',
		'imageheight'		=> '0',
		'imageorientation'	=> ''
	);

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->t3Version = class_exists('\TYPO3\CMS\Core\Utility\VersionNumberUtility') ? \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) : \TYPO3\CMS\Core\Utility\GeneralUtility::int_from_ver(TYPO3_version);
	}

	/**
	 * Gets manifest data from an image_folders folder, if the manifest file exists.
	 *
	 * @param string $folder An imagefolder folder.
	 * @return mixed False if file is empty or does not exist, an array if it does and contains valid data.
	 */
	public function getManifestData($folder) {
		$fileData	= false;
		$file		= $folder . self::MANIFEST_FILE_NAME;

		if (\TYPO3\CMS\Core\Utility\GeneralUtility::validPathStr($folder) && file_exists($file)) {
			if ($this->t3Version >= 4007000) {
				$llXmlParser	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('t3lib_l10n_parser_Llxml');
				$fileData		= $llXmlParser->getParsedData($file, $GLOBALS['LANG']->lang, $GLOBALS['TSFE']->renderCharset);

			} else if ($this->t3Version >= 4006000) {
				$fileData = \TYPO3\CMS\Core\Utility\GeneralUtility::readLLXMLfile($file, $GLOBALS['LANG']->lang, $GLOBALS['TSFE']->renderCharset);

			} else {
				$fileData = \TYPO3\CMS\Core\Utility\GeneralUtility::readLLfile($file, $GLOBALS['LANG']->lang, $GLOBALS['TSFE']->renderCharset);
			}

			$defaultLangStrings	= $fileData['default'];
			$fileData			= $fileData[$GLOBALS['LANG']->lang];

			if (is_array($fileData) && !empty($fileData)) {
				$fileData = array_merge($defaultLangStrings, $fileData);
			} else {
				$fileData = $defaultLangStrings;
			}

			if (!is_array($fileData) || empty($fileData)) {
				$fileData = false;
			}
		}

		return $fileData;
	}

	/**
	 * Gets manifest data fields form a parsed manifest file.
	 *
	 * @param array $manifestData The manifest array (a reference).
	 * @param string $imagePath The path and file name of an image.
	 * @param boolean $addImageNameKey Should the data be returned within an array element with the key = image name?
	 * @return mixed False if file is empty or does not exist, an array if it does and contains valid data.
	 */
	public function getManifestFieldsFromData(array &$manifestData, $imagePath, $addImageNameKey = FALSE) {
		$fileName	= $this->getFileName($imagePath);
		$fileFields	= array();

		foreach ($manifestData as $mdKey => $mdValue) {
			$mdKeyWithoutFieldName = $this->getFileNameFromLabelIndex($mdKey);

			if ($mdKeyWithoutFieldName == $fileName) {
				$fieldName	= substr($mdKey, strlen($fileName) + 1);
				$fieldValue	= $mdValue;

				if (is_array($fieldValue)) {
					$fieldValue	= $fieldValue[0]['target'];
				}

				if ($addImageNameKey) {
					$fileFields[$fileName . '.' . $fieldName] = $fieldValue;

				} else {
					$fileFields[$fieldName] = $fieldValue;
				}

				unset($manifestData[$mdKey]);
			}
		}

		return $fileFields;
	}

	/**
	 * Returns a file name from a file path without the file extension.
	 *
	 * @param	string $labelIndex The index attribute from a label tag in a TYPO3 LLL file.
	 * @return	string $fileName The file name.
	 */
	protected function getFileNameFromLabelIndex($labelIndex) {
		$lastDotPos = strrpos($labelIndex, '.');
		$fileName	= $labelIndex;

		if ($lastDotPos !== false) {
			$fileName = substr($labelIndex, 0, $lastDotPos);
		}

		return $fileName;
	}

	/**
	 * Returns a file name from a file path without the file extension.
	 *
	 * @param	string $filepath The path that contains a file's name.
	 * @return	string The file name without extension or $filepath unedited.
	 */
	protected function getFileName($filepath) {
		if (is_string($filepath)) {
			$filepath = pathinfo($filepath);
			$filepath = $filepath['filename'];
		}

		return $filepath;
	}

	/**
	 * Returns TRUE if $folder contains a manifest file
	 *
	 * @param	string $folder The folder to check for a manifest file.
	 * @return	boolean $fileExists TRUE if the $folder contains a manifest file.
	 */
	public function manifestFileExists($folder) {
		$fileExists	= FALSE;
		$file		= $folder . self::MANIFEST_FILE_NAME;

		if (TYPO3_MODE == 'BE') {
			$file = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($file, FALSE);
		}

		if (file_exists($file)) {
			$fileExists	= TRUE;
		}

		return $fileExists;
	}

	/**
	 * Creates a manifest file.
	 *
	 * @param	string $folder The folder where a manifest file needs creating.
	 * @param	array $existingImgData The existing data element from a manifest file.
	 * @return	void.
	 */
	public function createManifestFile($folder, array $existingImgData = array()) {
		$folderImgs = $this->getFolderImages($folder);

		if (!empty($folderImgs)) {
			$manifestXML = $this->getManifestXml($folder, $folderImgs, $existingImgData);

			$this->writeManifestFile($folder, $manifestXML);
		}
	}

	/**
	 * Returns an array of images, if the folder contains images.
	 *
	 * @param string $folder The folder where images should be looked for.
	 * @return array An array of images and their fields or an empty array if no images.
	 */
	protected function getFolderImages($folder) {
		if (TYPO3_MODE == 'BE') {
			$folder = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($folder, FALSE);
		}

		return \TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir($folder, $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'], TRUE, '1');
	}

	/**
	 * Checks if an already existing manifest file has sb_portfolio2 mandatory fields, or is not empty.
	 * Used by TCA hooks on saving imagefolder records to check manifest files.
	 *
	 * @param	string $folder The folder where the manifest file is that needs checking.
	 * @return	void.
	 */
	public function checkManifestFileForCompatability($folder) {
		$file = $folder . self::MANIFEST_FILE_NAME;

		if (TYPO3_MODE == 'BE') {
			$file = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($file, FALSE);
		}

		if (@is_file($file)) {
				// Could use a TYPO3 API function for reading an LL file but this only returns one language key
				// We want to edit all languages, so read the data in as a string
			$fileData = file_get_contents($file);

				// And use TYPO3's own native functions to convert an xml string to an array
			$manifestData = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($fileData);

				// If not already updated for sb_portfolio2
			if (!empty($manifestData)) {
				if (!isset($manifestData['meta']['compatibility']) || $manifestData['meta']['compatibility'] != 'sb_portfolio2') {
					$this->createManifestFile($folder, $manifestData['data']);
				}

			} else {
					// The file exists but there is no content or the content is not formatted correctly so make a new file.
				$this->createManifestFile($folder);
			}
		}
	}

	/**
	 * Writes a manifest file in $folder.
	 *
	 * @param	string $folder The folder where a manifest file needs creating.
	 * @param	string $manifestXML The XML content for the file.
	 * @return	void.
	 */
	public function writeManifestFile($folder, $manifestXML) {
		$absFilePath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($folder);

		return \TYPO3\CMS\Core\Utility\GeneralUtility::writeFile($absFilePath . self::MANIFEST_FILE_NAME, $manifestXML);
	}

	/**
	 * Creates the XML for a manifest file.
	 *
	 * @param	string $folder The folder where a manifest file needs creating.
	 * @param	array $folderImgs Images in the folder.
	 * @param	array $existingData Already existing fields as an array: $existingData[$languageKey][$fileName.$fieldName] = $fieldValue
	 * @return	string The manifest file XML.
	 */
	public function getManifestXml($folder, array $folderImgs, array $existingData = array()) {
		$manifestData	= array();
		$extName		= 'sb_portfolio2';

			// Meta data
		$manifestData['meta'] = array (
			'description'	=> htmlspecialchars('An automatically created image folder manifest file for ' . $extName),
			'folder'		=> htmlspecialchars($folder),
			'date'			=> htmlspecialchars(date('d/m/Y')),
			'time'			=> htmlspecialchars(date('H:i:s')),
			'user'			=> htmlspecialchars($GLOBALS['BE_USER']->user['username']),
			'compatibility'	=> htmlspecialchars($extName),
			'version'		=> htmlspecialchars(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion($extName))
		);

		$manifestData['data'] = $existingData;

			// Image data
		if (!array_key_exists('default', $manifestData['data'])) {
			$manifestData['data']['default'] = array ();
		}

		foreach ($manifestData['data'] as $langKey => $langFieldValues) {
			foreach ($folderImgs as $imageKey => $imageFile) {
				$imagePathData	= pathinfo($imageFile);
				$imageName		= $imagePathData['filename'];

				$imageSizeData	= getimagesize(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($imageFile));
				$imageWidth		= $imageSizeData[0];
				$imageHeight	= $imageSizeData[1];

				$manifestData['data'][$langKey][$imageName . '.imagetype']		= strtolower($imagePathData['extension']);
				$manifestData['data'][$langKey][$imageName . '.imagesize']		= filesize(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($imageFile));
				$manifestData['data'][$langKey][$imageName . '.imagename']		= $imagePathData['filename'];
				$manifestData['data'][$langKey][$imageName . '.imagepath']		= $folder;
				$manifestData['data'][$langKey][$imageName . '.imagewidth']		= $imageWidth;
				$manifestData['data'][$langKey][$imageName . '.imageheight']	= $imageHeight;

				if ($imageWidth > $imageHeight) {
					$manifestData['data'][$langKey][$imageName . '.imageorientation'] = '1'; // Landscape

				} else if ($imageHeight > $imageWidth) {
					$manifestData['data'][$langKey][$imageName . '.imageorientation'] = '2'; // Portrait

				} else {
					$manifestData['data'][$langKey][$imageName . '.imageorientation'] = '0'; // Sqaure
				}
			}
		}

		$options = array(
				// Setup tag names ('tag_name' => 'name_for_child_tags'
				// this then sets the actual array element value as the index attribute instead of the tag name)
			'parentTagMap' => array(
				'data'         => 'languageKey',
				'languageKey'  => 'label'
			)
		);

		return \TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs($manifestData, 'T3locallang', $options, 'utf-8');
	}
}
?>
