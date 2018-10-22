<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}



### Add Plugins ###
### ----------- ###

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'sb_portfolio2',
	'Items',
	'Portfolio Items',
	'EXT:sb_portfolio2/Resources/Public/Icons/Item/sbp2_item.gif'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'sb_portfolio2',
	'Categories',
	'Portfolio Categories',
	'EXT:sb_portfolio2/Resources/Public/Icons/Category/sbp2_category.gif'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'sb_portfolio2',
	'Clients',
	'Portfolio Clients',
	'EXT:sb_portfolio2/Resources/Public/Icons/Client/sbp2_client.gif'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'sb_portfolio2',
	'Tags',
	'Portfolio Tags',
	'EXT:sb_portfolio2/Resources/Public/Icons/Tag/sbp2_tag.gif'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'sb_portfolio2',
	'Testimonials',
	'Portfolio Testimonials',
	'EXT:sb_portfolio2/Resources/Public/Icons/Testimonial/sbp2_testimonial.gif'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'sb_portfolio2',
	'Slider',
	'Portfolio Sliders',
	'EXT:sb_portfolio2/Resources/Public/Icons/Slider/sbp2_slider.gif'
);

### Add FlexForms ###
### ------------- ###




$pluginSignature = 'sbportfolio2_items';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:sb_portfolio2/Configuration/FlexForms/ff_sbp2_items.xml');

$pluginSignature = 'sbportfolio2_clients';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:sb_portfolio2/Configuration/FlexForms/ff_sbp2_clients.xml');

$pluginSignature = 'sbportfolio2_categories';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:sb_portfolio2/Configuration/FlexForms/ff_sbp2_categories.xml');

$pluginSignature = 'sbportfolio2_tags';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:sb_portfolio2/Configuration/FlexForms/ff_sbp2_tags.xml');

$pluginSignature = 'sbportfolio2_testimonials';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:sb_portfolio2/Configuration/FlexForms/ff_sbp2_testimonials.xml');

$pluginSignature = 'sbportfolio2_slider';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:sb_portfolio2/Configuration/FlexForms/ff_sbp2_sliders.xml');
