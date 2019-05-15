<?php
namespace StephenBungert\SbPortfolio2\Controller;
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
use \StephenBungert\SbPortfolio2\Domain\Repository;

/**
 *
 *
 * @package sb_portfolio2
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class SliderController extends CoreRecordController {

	/**
	 * sliderRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\SliderRepository
	 */
	protected $sliderRepository;

	/**
	 * injectSliderRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\SliderRepository $sliderRepository
	 * @return void
	 */
	public function injectSliderRepository(\StephenBungert\SbPortfolio2\Domain\Repository\SliderRepository $sliderRepository) {
		$this->sliderRepository = $sliderRepository;
	}

	/**
	 * action slider
	 *
	 * @return void
	 */
	public function sliderAction() {
		$this->mergeFlexFormSettings('slider');

		$sliders = $this->sliderRepository->findWithConstraints($this->settings['slider']['records']);
		$this->view->assign('sliders', $sliders);
	}

}
?>
