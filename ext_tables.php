<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2CshPath		= 'EXT:sb_portfolio2/Resources/Private/Language/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2ExtPath		= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);
$sbp2ExtRelPath		= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);


### Add Modules ###
### ----------- ###

if (TYPO3_MODE === 'BE') {


	/**
	 * Registers the portfolio backend sub-modules
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		$_EXTKEY,
		'web',
		'sbp2beimport',
		'',
		array(
			'BeImport' => 'import',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_sbp2be.xml',
		)
	);
}




\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_item', 			$sbp2CshPath . ' locallang_csh_item.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_client', 		$sbp2CshPath . ' locallang_csh_client.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_category', 		$sbp2CshPath . ' locallang_csh_category.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_file', 			$sbp2CshPath . ' locallang_csh_file.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_film', 			$sbp2CshPath . ' locallang_csh_film.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_image', 		$sbp2CshPath . ' locallang_csh_image.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_imagefolder', 	$sbp2CshPath . ' locallang_csh_imagefolder.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_link', 			$sbp2CshPath . ' locallang_csh_link.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_tag', 			$sbp2CshPath . ' locallang_csh_tag.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_testimonial', 	$sbp2CshPath . ' locallang_csh_testimonial.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_slider', 		$sbp2CshPath . ' locallang_csh_slider.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_item');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_category');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_client');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_file');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_film');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_image');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_imagefolder');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_link');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_tag');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_testimonial');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sbportfolio2_domain_model_slider');
?>
