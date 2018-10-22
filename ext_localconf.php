<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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



//$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sbp2'] = ['Tx_SbPortfolio2_ViewHelpers'];


	// Hook: TCEmain processDatamapClass
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'EXT:' . $_EXTKEY. '/Classes/Hooks/Tcemain.php:Tx_SbPortfolio2_Hooks_Tcemain';

	// AJAX for BE module
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::import']				= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/BeImportController.php:Tx_SbPortfolio2_Controller_BeImportController->ajaxImport';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::importRelated']		= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/BeImportController.php:Tx_SbPortfolio2_Controller_BeImportController->ajaxImportRelated';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_sbportfolio2::importTranslation']	= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/BeImportController.php:Tx_SbPortfolio2_Controller_BeImportController->ajaxImportTranslation';
?>
