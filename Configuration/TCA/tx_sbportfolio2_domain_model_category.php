<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2ExtRelPath		= 'EXT:sb_portfolio2/';
$sbp2IconPath		= 'Resources/Public/Icons/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2Label			= $sbp2LabelPath . 'sbp2_category.';
$sbp2LabelShared	= $sbp2LabelPath . 'sbp2_shared.';
$sbp2Tab			= '--div--;' . $sbp2LabelPath . 'sbp2_tab';
$sbp2Pal			= '--palette--;' . $sbp2LabelPath . 'sbp2_palette';

return array(
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
        'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Category/sbp2_category.gif',
        'searchFields' => 'title,titlefull,titleshort,fulldescription,summary'
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, titlefull, titleshort, summary, tags, parentcat, image, links, files, relateditems, slider_title, slider_image, slider_description',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, ' . $sbp2Pal . '.title;titlePalette, summary, fulldescription;;;richtext::rte_transform[flag=rte_enabled|mode=ts_css], ' . $sbp2Tab . '.media, image, ' . $sbp2Tab . '.related, links, files, relateditems, ' . $sbp2Tab . '.categorisation, parentcat, tags, ' . $sbp2Tab . '.seo, ' . $sbp2Pal . '.og;ogPalette, ' . $sbp2Pal . '.facebook;facebookPalette, ' . $sbp2Tab . '.access, hidden;;1, ' . $sbp2Pal . '.publishDates;publishDatesPalette'),
	),
	'palettes' => array(
		'titlePalette' => array(
			'showitem'			=> 'title, --linebreak--, titlefull, titleshort',
			'canNotCollapse'	=> 1
		),
		'publishDatesPalette' => array(
			'showitem'			=> 'starttime, endtime',
			'canNotCollapse'	=> 1
		),
		'facebookPalette' => array(
			'showitem'			=> 'seo_fbappid, seo_fbadmins',
			'canNotCollapse'	=> 1
		),
		'ogPalette' => array(
			'showitem'			=> 'seo_title;;;;1-1-1, seo_type, --linebreak--, seo_image, --linebreak--, seo_description',
			'canNotCollapse'	=> 1
		),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_sbportfolio2_domain_model_category',
				'foreign_table_where' => 'AND tx_sbportfolio2_domain_model_category.pid=###CURRENT_PID### AND tx_sbportfolio2_domain_model_category.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'tstamp' => array(
			'label'   => $sbp2LabelShared . 'tstamp',
			'l10n_mode' => 'mergeIfNotBlank',
			'config'  => array(
				'type'     => 'input',
				'size'     => 8,
				'max'      => 20,
				'eval'     => 'date',
				'default'  => 0,
			)
		),
		'crdate' => array(
			'label'   => $sbp2LabelShared . 'crdate',
			'l10n_mode' => 'mergeIfNotBlank',
			'config'  => array(
				'type'     => 'input',
				'size'     => 8,
				'max'      => 20,
				'eval'     => 'date',
				'default'  => 0,
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim,required'
			),
		),
		'titlefull' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'titlefull',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			),
		),
		'titleshort' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'titleshort',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'max' => 33,
				'eval' => 'trim'
			),
		),
		'summary' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'summary',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 3,
				'eval' => 'trim'
			),
		),
		'fulldescription' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'fulldescription',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 3,
				'eval' => 'trim'
			),
		),
		'image' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'image',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_sbportfolio2_domain_model_image',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'newRecordLinkAddTitle' => 1,
					'expandSingle' => 1,
					'newRecordLinkAddTitle' => 1,
					'enabledControls' => array(
						'info' => true,
						'new' => true,
						'dragdrop' => false,
						'sort' => false,
						'hide' => true,
						'delete' => true,
					),
				),
			),
		),
		'links' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'links',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_sbportfolio2_domain_model_link',
				'foreign_table' => 'tx_sbportfolio2_domain_model_link',
				'MM' => 'tx_sbportfolio2_category_link_mm',
				'foreign_table_where' => 'ORDER BY tx_sbportfolio2_domain_model_link.title',
				'size' => 5,
				'autoSizeMax' => 10,
				'minitems' => 0,
				'maxitems' => 20,
				'module' => array(
					'name' => 'wizard_edit',
				),
			),
		),
		'files' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'files',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_sbportfolio2_domain_model_file',
				'foreign_table' => 'tx_sbportfolio2_domain_model_file',
				'foreign_table_where' => 'ORDER BY tx_sbportfolio2_domain_model_file.title',
				'MM' => 'tx_sbportfolio2_category_file_mm',
				'size' => 5,
				'autoSizeMax' => 10,
				'minitems' => 0,
				'maxitems' => 20,
				'module' => array(
					'name' => 'wizard_edit',
				),
			),
		),
		'relateditems' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'relateditems',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_sbportfolio2_domain_model_item',
				'foreign_table' => 'tx_sbportfolio2_domain_model_item',
				'foreign_table_where' => 'ORDER BY tx_sbportfolio2_domain_model_item.title',
				'MM' => 'tx_sbportfolio2_category_item_mm',
				'size' => 5,
				'autoSizeMax' => 10,
				'minitems' => 0,
				'maxitems' => 20,
				'module' => array(
					'name' => 'wizard_edit',
				),
			),
		),
		'parentcat' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'parentcat',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_sbportfolio2_domain_model_category',
				'renderMode' => 'tree',
				'subType' => 'db',
				'treeConfig' => array(
					'parentField' => 'parentcat',
					'appearance' => array(
						'expandAll' => true,
						'showHeader' => true,
					),
				),
				'size' => 10,
				'autoSizeMax' => 20,
				'minitems' => 0,
				'maxitems' => 1
			)
		),
		'tags' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'tags',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'select',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'parentField' => 'parenttag',
					'appearance' => array(
						'showHeader' => true,
						'allowRecursiveMode' => true,
					),
				),
				'MM' => 'tx_sbportfolio2_category_tag_mm',
				'foreign_table' => 'tx_sbportfolio2_domain_model_tag',
				'foreign_table_where' => 'ORDER BY tx_sbportfolio2_domain_model_tag.title ASC',
				'size' => 5,
				'autoSizeMax' => 20,
				'minitems' => 0,
				'maxitems' => 50
			),
		),
		'seo_title' => array (
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'seo_title',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max' => 255,
				'eval' => 'trim',
			)
		),
		'seo_type' => array (
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'seo_type',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', ''),
					array($sbp2LabelShared . 'seo_type.0', '--div--'),
					array($sbp2LabelShared . 'seo_type.0.0', 'activity'),
					array($sbp2LabelShared . 'seo_type.0.1', 'sport'),
					array($sbp2LabelShared . 'seo_type.1', '--div--'),
					array($sbp2LabelShared . 'seo_type.1.0', 'bar'),
					array($sbp2LabelShared . 'seo_type.1.1', 'company'),
					array($sbp2LabelShared . 'seo_type.1.2', 'cafe'),
					array($sbp2LabelShared . 'seo_type.1.3', 'hotel'),
					array($sbp2LabelShared . 'seo_type.1.4', 'restaurant'),
					array($sbp2LabelShared . 'seo_type.2', '--div--'),
					array($sbp2LabelShared . 'seo_type.2.0', 'cause'),
					array($sbp2LabelShared . 'seo_type.2.1', 'cports_league'),
					array($sbp2LabelShared . 'seo_type.2.2', 'cports_team'),
					array($sbp2LabelShared . 'seo_type.3', '--div--'),
					array($sbp2LabelShared . 'seo_type.3.0', 'band'),
					array($sbp2LabelShared . 'seo_type.3.1', 'government'),
					array($sbp2LabelShared . 'seo_type.3.2', 'non_profit'),
					array($sbp2LabelShared . 'seo_type.3.3', 'school'),
					array($sbp2LabelShared . 'seo_type.3.4', 'university'),
					array($sbp2LabelShared . 'seo_type.4', '--div--'),
					array($sbp2LabelShared . 'seo_type.4.0', 'actor'),
					array($sbp2LabelShared . 'seo_type.4.1', 'athlete'),
					array($sbp2LabelShared . 'seo_type.4.2', 'author'),
					array($sbp2LabelShared . 'seo_type.4.3', 'director'),
					array($sbp2LabelShared . 'seo_type.4.4', 'musician'),
					array($sbp2LabelShared . 'seo_type.4.5', 'politician'),
					array($sbp2LabelShared . 'seo_type.4.6', 'public_figure'),
					array($sbp2LabelShared . 'seo_type.5', '--div--'),
					array($sbp2LabelShared . 'seo_type.5.0', 'city'),
					array($sbp2LabelShared . 'seo_type.5.1', 'country'),
					array($sbp2LabelShared . 'seo_type.5.2', 'landmark'),
					array($sbp2LabelShared . 'seo_type.5.3', 'state_province'),
					array($sbp2LabelShared . 'seo_type.6', '--div--'),
					array($sbp2LabelShared . 'seo_type.6.0', 'album'),
					array($sbp2LabelShared . 'seo_type.6.1', 'book'),
					array($sbp2LabelShared . 'seo_type.6.2', 'drink'),
					array($sbp2LabelShared . 'seo_type.6.3', 'food'),
					array($sbp2LabelShared . 'seo_type.6.4', 'game'),
					array($sbp2LabelShared . 'seo_type.6.5', 'product'),
					array($sbp2LabelShared . 'seo_type.6.6', 'song'),
					array($sbp2LabelShared . 'seo_type.6.7', 'movie'),
					array($sbp2LabelShared . 'seo_type.6.8', 'tv_show'),
					array($sbp2LabelShared . 'seo_type.7', '--div--'),
					array($sbp2LabelShared . 'seo_type.7.0', 'blog'),
					array($sbp2LabelShared . 'seo_type.7.1', 'website'),
					array($sbp2LabelShared . 'seo_type.7.2', 'article'),
				),
				'size' => 1,
				'maxitems' => 1,
				'default' => 'article',
			)
		),
		'seo_image' => array (
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'seo_image',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'seo_description' => array (
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'seo_description',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
			)
		),
		'seo_fbappid' => array (
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'seo_fbappid',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max' => '100',
				'eval' => 'trim',
			)
		),
		'seo_fbadmins' => array (
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'seo_fbadmins',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'starttime',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'endtime',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'sbpuid' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
?>
