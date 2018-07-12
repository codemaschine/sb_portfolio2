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
 * Hooks for Tcemain, to manipulate records.
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Hooks_Tcemain {

	/**
	 * postProcessFieldArray hook, used to set certain properties of sb_portfolio2 records, like setting file information or image sizes, etc.
	 *
	 * @param string $status The staus of the record.
	 * @param string $table The table that the record is in.
	 * @param integer $uid The uid of the record.
	 * @param array $fields The record itself, an array of fields.
	 * @param t3lib_TCEmain $tceMainObj The tcemain object.
	 * @return void
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $uid, array &$fields, t3lib_TCEmain $tceMainObj) {
		if ($table == 'tx_sbportfolio2_domain_model_link' || $table == 'tx_sbportfolio2_domain_model_file' || $table == 'tx_sbportfolio2_domain_model_item') {
			if (isset($fields['file'])) {
				$fields = $this->updateFileFields($fields, 'file');
			}

		} else if ($table == 'tx_sbportfolio2_domain_model_film') {
			if (isset($fields['film'])) {
				$fields = $this->updateFileFields($fields, 'film');
			}

		} else if ($table == 'tx_sbportfolio2_domain_model_image') {
			$fields = $this->updateImageFields($fields);

		} else if ($table == 'tx_sbportfolio2_domain_model_imagefolder') {
			if (isset($fields['folders']) && !empty($fields['folders'])) {
				$folders = t3lib_div::trimExplode(',', $fields['folders'], true);

					// Check each folder for an image manifest file
				foreach ($folders as $folderIndex => $folderPath) {
					$this->proofManifestFile($folderPath);
				}
			}
		}
	}


	/**
	 * Creates a manifest file for the $folder, if it does not contain one.
	 * If a file already exists, it will be checked to see if it needs updating
	 * with mandatory fields in sb_portfolio2.
	 *
	 * @param array $folder The folder to check for a manifest file.
	 * @return void.
	 */
	protected function proofManifestFile($folder) {
		$manifest = t3lib_div::makeInstance('Tx_SbPortfolio2_Domain_Model_Manifest_File');

		if ($manifest->manifestFileExists($folder)) {
			$manifest->checkManifestFileForCompatability($folder);

		} else {
			$manifest->createManifestFile($folder);
		}
	}


	/**
	 * Updates the fields array with info about an image.
	 *
	 * @param array $fields The record itself, an array of fields.
	 * @return $fields The $fields array, modified.
	 */
	protected function updateImageFields($fields) {
		if (isset($fields['imagefile'])) {
			if (empty($fields['imagefile'])) { // Image is being deleted, and there is no new file
				$fields['imagetype']		= '';
				$fields['imagesize']		= '0';
				$fields['imagename']		= '';
				$fields['imagepath']		= '';
				$fields['imagewidth']		= '0';
				$fields['imageheight']		= '0';
				$fields['imageorientation']	= '';

			} else { // Image is being added
				$imagePathData = pathinfo($fields['imagefile']);
				$imageSizeData = getimagesize(t3lib_div::getFileAbsFileName($fields['imagefile']));

				$fields['imagetype']		= strtolower($imagePathData['extension']);
				$fields['imagesize']		= filesize(t3lib_div::getFileAbsFileName($fields['imagefile']));
				$fields['imagename']		= $imagePathData['filename'];
				$fields['imagepath']		= $imagePathData['dirname'];
				$fields['imagewidth']		= $imageSizeData[0];
				$fields['imageheight']		= $imageSizeData[1];

				if ($fields['imagewidth'] > $fields['imageheight']) {
					$fields['imageorientation'] = '1'; // Landscape

				} else if ($fields['imageheight'] > $fields['imagewidth']) {
					$fields['imageorientation'] = '2'; // Portrait

				} else {
					$fields['imageorientation'] = '0'; // Sqaure
				}
			}
		}

		return $fields;
	}


	/**
	 * Updates the fields array with info about a file.
	 *
	 * @param array $fields The record itself, an array of fields.
	 * @param string $fieldName The field name to check the value of.
	 * @return $fields The $fields array, modified.
	 */
	protected function updateFileFields($fields, $fieldName) {
		if (empty($fields[$fieldName])) { // File is being deleted, and there is no new file
			$fields['filetype'] = '';
			$fields['filesize'] = '0';
			$fields['filename'] = '';
			$fields['filepath'] = '';

		} else { // File is being added
			$filePathData = pathinfo($fields[$fieldName]);

			$fields['filetype'] = strtolower($filePathData['extension']);
			$fields['filesize'] = filesize(t3lib_div::getFileAbsFileName($fields[$fieldName]));
			$fields['filename'] = $filePathData['filename'];
			$fields['filepath'] = $filePathData['dirname'];
		}

		return $fields;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sb_portfolio2/Classes/Hooks/Tcemain.php']) {
	require_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sb_portfolio2/Classes/Hooks/Tcemain.php']);
}

?>