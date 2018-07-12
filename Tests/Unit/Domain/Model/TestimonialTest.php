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
 * Test case for class Tx_SbPortfolio2_Domain_Model_Testimonial.
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
class Tx_SbPortfolio2_Domain_Model_TestimonialTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SbPortfolio2_Domain_Model_Testimonial
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_SbPortfolio2_Domain_Model_Testimonial();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getBodyReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setBodyForStringSetsBody() { 
		$this->fixture->setBody('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getBody()
		);
	}
	
	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
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
	public function getCompanyReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCompanyForStringSetsCompany() { 
		$this->fixture->setCompany('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCompany()
		);
	}
	
	/**
	 * @test
	 */
	public function getPositionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPositionForStringSetsPosition() { 
		$this->fixture->setPosition('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPosition()
		);
	}
	
	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForTx_SbPortfolio2_Domain_Model_Image() { }

	/**
	 * @test
	 */
	public function setImageForTx_SbPortfolio2_Domain_Model_ImageSetsImage() { }
	
}
?>