<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Items',
	array(
		'Item' => 'list,single',
	),
	// non-cacheable actions
	array(
		'Item' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Categories',
	array(
		'Category' => 'list,single',
	),
	// non-cacheable actions
	array(
		'Category' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Clients',
	array(
		'Client' => 'list,single',
	),
	// non-cacheable actions
	array(
		'Client' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Tags',
	array(
		'Tag' => 'list',
	),
	// non-cacheable actions
	array(
		'Tag' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Testimonials',
	array(
		'Testimonial' => 'list',
	),
	// non-cacheable actions
	array(
		'Testimonial' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Slider',
	array(
		'Slider' => 'slider',
	),
	// non-cacheable actions
	array(
		'Slider' => '',
	)
);



	// Hook: TCEmain processDatamapClass
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'EXT:' . $_EXTKEY. '/Classes/Hooks/Tcemain.php:Tx_SbPortfolio2_Hooks_Tcemain';

	// AJAX for BE module
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::import']				= t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Controller/BeImportController.php:Tx_SbPortfolio2_Controller_BeImportController->ajaxImport';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::importRelated']		= t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Controller/BeImportController.php:Tx_SbPortfolio2_Controller_BeImportController->ajaxImportRelated';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::importTranslation']	= t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Controller/BeImportController.php:Tx_SbPortfolio2_Controller_BeImportController->ajaxImportTranslation';
?>