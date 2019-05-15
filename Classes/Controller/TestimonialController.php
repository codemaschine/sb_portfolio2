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
class TestimonialController extends CoreRecordController {

	/**
	 * testimonialRepository
	 *
	 * @var \StephenBungert\SbPortfolio2\Domain\Repository\TestimonialRepository
	 */
	protected $testimonialRepository;

	/**
	 * injectTestimonialRepository
	 *
	 * @param \StephenBungert\SbPortfolio2\Domain\Repository\TestimonialRepository $testimonialRepository
	 * @return void
	 */
	public function injectTestimonialRepository(\StephenBungert\SbPortfolio2\Domain\Repository\TestimonialRepository $testimonialRepository) {
		$this->testimonialRepository = $testimonialRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$this->mergeFlexFormSettings('testimonial');

		$testimonials = $this->testimonialRepository->findWithConstraints($this->settings['testimonial']['records']);

		$this->view->assign('testimonials', $testimonials);
	}

}
?>
