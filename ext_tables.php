<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}



$sbp2CshPath		= 'EXT:sb_portfolio2/Resources/Private/Language/';
$sbp2IconPath		= 'Resources/Public/Icons/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2ExtPath		= t3lib_extMgm::extPath($_EXTKEY);
$sbp2ExtRelPath		= t3lib_extMgm::extRelPath($_EXTKEY);



### Add Plugins ###
### ----------- ###

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Items',
	'Portfolio Items',
	$sbp2ExtRelPath	 . $sbp2IconPath . 'Item/sbp2_item.gif'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Categories',
	'Portfolio Categories',
	$sbp2ExtRelPath	 . $sbp2IconPath . 'Category/sbp2_category.gif'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Clients',
	'Portfolio Clients',
	$sbp2ExtRelPath	 . $sbp2IconPath . 'Client/sbp2_client.gif'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Tags',
	'Portfolio Tags',
	$sbp2ExtRelPath	 . $sbp2IconPath . 'Tag/sbp2_tag.gif'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Testimonials',
	'Portfolio Testimonials',
	$sbp2ExtRelPath	 . $sbp2IconPath . 'Testimonial/sbp2_testimonial.gif'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Slider',
	'Portfolio Sliders',
	$sbp2ExtRelPath	 . $sbp2IconPath . 'Slider/sbp2_slider.gif'
);



### Add FlexForms ###
### ------------- ###

$pluginSignaturePrefix = str_replace('_','',$_EXTKEY);

$pluginSignature = $pluginSignaturePrefix . '_items';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ff_sbp2_items.xml');

$pluginSignature = $pluginSignaturePrefix . '_clients';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ff_sbp2_clients.xml');

$pluginSignature = $pluginSignaturePrefix . '_categories';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ff_sbp2_categories.xml');

$pluginSignature = $pluginSignaturePrefix . '_tags';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ff_sbp2_tags.xml');

$pluginSignature = $pluginSignaturePrefix . '_testimonials';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ff_sbp2_testimonials.xml');

$pluginSignature = $pluginSignaturePrefix . '_slider';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ff_sbp2_sliders.xml');



### Add Modules ###
### ----------- ###

if (TYPO3_MODE === 'BE') {
	/**
	 * Registers the portfolio backend sub-modules
	 */
	Tx_Extbase_Utility_Extension::registerModule(
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


### Add TypoScript ###
### -------------- ###

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'SB Portfolio 2');



### Tables ###
### ------ ###

$TCA['tx_sbportfolio2_domain_model_item'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_item',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'type' => 'type',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Item.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Item/sbp2_item.gif',
		'searchFields' => 'title,titlefull,titleshort,fulldescription,summary',
		'typeicon_column' => 'type',
		'typeicons' => array(
			'0' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Item/sbp2_item.gif',
			'1' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Item/sbp2_item_page.gif',
			'2' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Item/sbp2_item_url.gif',
			'3' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Item/sbp2_item_file.gif',
		),
	),
);

$TCA['tx_sbportfolio2_domain_model_category'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_category',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Category.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Category/sbp2_category.gif',
		'searchFields' => 'title,titlefull,titleshort,fulldescription,summary'
	),
);

$TCA['tx_sbportfolio2_domain_model_client'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_client',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Client.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Client/sbp2_client.gif',
		'searchFields' => 'title,titlefull,titleshort,fulldescription,summary'
	),
);



$TCA['tx_sbportfolio2_domain_model_file'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_file',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/File.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'File/sbp2_file.gif',
		'searchFields' => 'title,titlefull,titleshort,description'
	),
);



$TCA['tx_sbportfolio2_domain_model_film'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_film',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'type' => 'type',
		'typeicon_column' => 'type',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Film.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film.gif',
		'searchFields' => 'title,titlefull,titleshort,description',
		'typeicon_column' => 'type',
		'typeicons' => array(
			'0' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film.gif',
			'1' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film_file.gif',
			'2' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film_url.gif',
		),
	),
);



$TCA['tx_sbportfolio2_domain_model_image'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_image',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Image.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Image/sbp2_image.gif',
		'searchFields' => 'title,titlefull,titleshort,description,caption'
	),
);



$TCA['tx_sbportfolio2_domain_model_imagefolder'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_imagefolder',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/ImageFolder.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Imagefolder/sbp2_imagefolder.gif',
		'searchFields' => 'title,titlefull,titleshort'
	),
);

$TCA['tx_sbportfolio2_domain_model_link'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_link',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'type' => 'type',
		'typeicon_column' => 'type',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Link.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link.gif',
		'searchFields' => 'title,titlefull,titleshort',
		'typeicon_column' => 'type',
		'typeicons' => array(
			'0' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link.gif',
			'1' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_file.gif',
			'2' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_page.gif',
			'10' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_item.gif',
			'11' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_client.gif',
			'12' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_category.gif',
			'20' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_item_category.gif',
			'21' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_item_client.gif',
			'22' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_item_tag.gif',
			'23' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_client_category.gif',
			'24' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Link/sbp2_link_client_tag.gif',
		),
	),
);

$TCA['tx_sbportfolio2_domain_model_tag'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_tag',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Tag.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Tag/sbp2_tag.gif',
		'searchFields' => 'title'
	),
);



$TCA['tx_sbportfolio2_domain_model_testimonial'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_testimonial',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Testimonial.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Testimonial/sbp2_testimonial.gif',
		'searchFields' => 'title,body,name,company,position'
	),
);

$TCA['tx_sbportfolio2_domain_model_slider'] = array(
	'ctrl' => array(
		'title'	=> $sbp2LabelPath . 'sbp2_slider',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY title ASC',
		'delete' => 'deleted',
		'type' => 'type',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => $sbp2ExtPath . 'Configuration/TCA/Slider.php',
		'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Slider/sbp2_slider.gif',
		'searchFields' => 'title,titlefull,titleshort,fulldescription,summary',
		'typeicon_column' => 'type',
		'typeicons' => array(
            '0' => $sbp2ExtRelPath   . $sbp2IconPath . 'Slider/sbp2_slider_link.gif',
            '2' => $sbp2ExtRelPath   . $sbp2IconPath . 'Slider/sbp2_slider_page.gif',
            '10' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_item.gif',
            '11' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_client.gif',
            '12' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_category.gif',
            '20' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_item_category.gif',
            '21' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_item_client.gif',
            '22' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_item_tag.gif',
            '23' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_client_category.gif',
            '24' => $sbp2ExtRelPath  . $sbp2IconPath . 'Slider/sbp2_slider_client_tag.gif',
		),
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_item', 			$sbp2CshPath . ' locallang_csh_item.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_client', 		$sbp2CshPath . ' locallang_csh_client.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_category', 		$sbp2CshPath . ' locallang_csh_category.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_file', 			$sbp2CshPath . ' locallang_csh_file.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_film', 			$sbp2CshPath . ' locallang_csh_film.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_image', 		$sbp2CshPath . ' locallang_csh_image.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_imagefolder', 	$sbp2CshPath . ' locallang_csh_imagefolder.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_link', 			$sbp2CshPath . ' locallang_csh_link.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_tag', 			$sbp2CshPath . ' locallang_csh_tag.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_testimonial', 	$sbp2CshPath . ' locallang_csh_testimonial.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_sbportfolio2_domain_model_slider', 		$sbp2CshPath . ' locallang_csh_slider.xml');

t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_item');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_category');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_client');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_file');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_film');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_image');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_imagefolder');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_link');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_tag');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_testimonial');
t3lib_extMgm::allowTableOnStandardPages('tx_sbportfolio2_domain_model_slider');
?>