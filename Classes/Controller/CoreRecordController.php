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
 * A base controller class containing functions common to several controllers in sb_portfolio2
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Controller_CoreRecordController extends \TYPO3\CMS\Extbase\MVC\Controller\ActionController {

	/**
	 * Merges two TS setting arrays.
	 *
	 * @param array $tsSettings1 The "default" settings.
	 * @param array $tsSettings2 The settings that should over-write the "default" settings (if not empty).
	 * @return array Returns the merged array.
	 */
	protected function mergeSettings(array $tsSettings1, array $tsSettings2) {
		$tsSettings2 = $this->removeEmptyValues($tsSettings2);
		
		\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($tsSettings1, $tsSettings2);

		return $tsSettings1;
	}

	/**
	 * Removes empty values from an array using array_filter. This function will call itself recursively if needed.
	 *
	 * @param array $arrayToCheck An array to remove empty values from.
	 * @return array Returns the merged array.
	 */
	protected function removeEmptyValues(array $arrayToCheck) {
		foreach ($arrayToCheck as &$keyValue) {
			if (is_array($keyValue)) $keyValue = $this->removeEmptyValues($keyValue);
		}

		return array_filter($arrayToCheck);
	}

	/**
	 * Merges the plugin's FlexForm fields with the TypoScript settings.
	 *
	 * @param string $pluginSettings The TS settings array for the current plugin.
	 * @return void
	 */
	public function mergeFlexFormSettings($pluginSettings) {
		if ($this->settings['ff']) {
				// Make any changes required to FF settings before merging
			$this->settings['ff'] = $this->adjustFlexFormSettings($this->settings['ff']); // Changes for the current plugin (optional)
				
				// Merge
			$this->settings[$pluginSettings]['records'] = $this->mergeSettings($this->settings[$pluginSettings]['records'], $this->settings['ff']);

			if (!empty($this->settings['ff']['itemsPerPage'])) { // Use FF limit for page browser
				$this->settings[$pluginSettings]['pageBrowser']['itemsPerPage'] = $this->settings['ff']['itemsPerPage'];
			}

				// Update settings now that they have changed
			$this->view->assign('settings', $this->settings);
		}
	}

	/**
	 * Does any changes needed for a specific plugin to the FF settings.
	 * This is just a dummy function, should be overwritten in a controller if things need changing.
	 *
	 * @param array $pluginSettings The plugin's FF settings.
	 * @return array $pluginSettings The plugin's FF settings.
	 */
	public function adjustFlexFormSettings(array $ffSettings) {
		return $ffSettings;
	}
}
?>