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
 * Session handler for sb_portfolio
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_SbPortfolio2_Domain_Session_Handler implements t3lib_Singleton {
	/**
	 * Returns the object stored in the user´s PHP session
	 * 
	 * @return Object the stored object
	 */
	public function getSessionData() {
		$sessionData = $GLOBALS['BE_USER']->getSessionData('tx_sbportfolio2');
		
		return unserialize($sessionData);
	}
 
	/**
	 * Writes an object into the PHP session
	 * 
	 * @param	$object	any serializable object to store into the session
	 * @return	Tx_SbPortfolio2_Domain_Session_Handler this
	 */
	public function setSessionData($object) {
		$sessionData = serialize($object);
		
		$GLOBALS['BE_USER']->setAndSaveSessionData('tx_sbportfolio2', $sessionData);
		
		return $this;
	}
}
?>