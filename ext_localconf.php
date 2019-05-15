<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'StephenBungert.'.$_EXTKEY,
	'Items',
	array(
		'Item' => 'list,single',
	),
	// non-cacheable actions
	array(
		'Item' => '',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'StephenBungert.'.$_EXTKEY,
	'Categories',
	array(
		'Category' => 'list,single',
	),
	// non-cacheable actions
	array(
		'Category' => '',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'StephenBungert.'.$_EXTKEY,
	'Clients',
	array(
		'Client' => 'list,single',
	),
	// non-cacheable actions
	array(
		'Client' => '',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'StephenBungert.'.$_EXTKEY,
	'Tags',
	array(
		'Tag' => 'list',
	),
	// non-cacheable actions
	array(
		'Tag' => '',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'StephenBungert.'.$_EXTKEY,
	'Testimonials',
	array(
		'Testimonial' => 'list',
	),
	// non-cacheable actions
	array(
		'Testimonial' => '',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'StephenBungert.'.$_EXTKEY,
	'Slider',
	array(
		'Slider' => 'slider',
	),
	// non-cacheable actions
	array(
		'Slider' => '',
	)
);



//$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sbp2'] = ['StephenBungert\SbPortfolio2\ViewHelpers'];


	// Hook: TCEmain processDatamapClass
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = \StephenBungert\SbPortfolio2\Hooks\Tcemain::class;

	// AJAX for BE module
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::import']				= \StephenBungert\SbPortfolio2\Controller\BeImportController::class . '->ajaxImport';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::importRelated']		= \StephenBungert\SbPortfolio2\Controller\BeImportController::class . '->ajaxImportRelated';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::importTranslation']	= \StephenBungert\SbPortfolio2\Controller\BeImportController::class . '->ajaxImportTranslation';
?>
