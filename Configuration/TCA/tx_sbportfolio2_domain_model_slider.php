<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2ExtRelPath		= 'EXT:sb_portfolio2/';
$sbp2IconPath		= 'Resources/Public/Icons/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2Label			= $sbp2LabelPath . 'sbp2_slider.';
$sbp2LabelShared	= $sbp2LabelPath . 'sbp2_shared.';
$sbp2Tab			= '--div--;' . $sbp2LabelPath . 'sbp2_tab';
$sbp2Pal			= '--palette--;' . $sbp2LabelPath . 'sbp2_palette';

$sbp2Fields	= 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, ' . $sbp2Pal . '.title;titlePalette, ' . $sbp2Pal . '.type;typePalette, summary, fulldescription;;;richtext::rte_transform[flag=rte_enabled|mode=ts_css], ' . $sbp2Tab . '.media, ' . $sbp2Pal . '.images;imagesPalette, ' . $sbp2Tab . '.access, hidden;;1, ' . $sbp2Pal . '.publishDates;publishDatesPalette';

return array(
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
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, titlefull, titleshort, type, url, page, item, client, category, tag, summary, fulldescription, image, imagero, icon, logo',
	),
	'types' => array(
		'1' => array('showitem' => $sbp2Fields),
		'2' => array('showitem' => $sbp2Fields),
		'10' => array('showitem' => $sbp2Fields),
		'11' => array('showitem' => $sbp2Fields),
		'12' => array('showitem' => $sbp2Fields),
		'20' => array('showitem' => $sbp2Fields),
		'21' => array('showitem' => $sbp2Fields),
		'22' => array('showitem' => $sbp2Fields),
		'23' => array('showitem' => $sbp2Fields),
		'24' => array('showitem' => $sbp2Fields),
	),#$sbp2Pal . '.file;filePalette
	'palettes' => array(
		'titlePalette' => array(
			'showitem'			=> 'title, --linebreak--, titlefull, titleshort',
			'canNotCollapse'	=> 1
		),
		'publishDatesPalette' => array(
			'showitem'			=> 'starttime, endtime',
			'canNotCollapse'	=> 1
		),
		'typePalette' => array(
			'showitem'			=> 'type, --linebreak--, url, page, item, client, category, tag',
			'canNotCollapse'	=> 1
		),
		'imagesPalette' => array(
			'showitem'			=> 'image, imagero, --linebreak--, icon, logo',
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
				'foreign_table' => 'tx_sbportfolio2_domain_model_link',
				'foreign_table_where' => 'AND tx_sbportfolio2_domain_model_link.pid=###CURRENT_PID### AND tx_sbportfolio2_domain_model_link.sys_language_uid IN (-1,0)',
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
		'type' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'type',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'select',
				'items' => array(
                    array($sbp2Label . 'type.label.0', '--div--'),
                    array($sbp2Label . 'type.0', 0, $sbp2ExtRelPath . $sbp2IconPath . 'Link/sbp2_link.gif'),
                    array($sbp2Label . 'type.2', 2, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_page.gif'),
                    array($sbp2Label . 'type.label.1', '--div--'),
                    array($sbp2Label . 'type.10', 10, $sbp2ExtRelPath . $sbp2IconPath . 'Item/sbp2_item.gif'),
                    array($sbp2Label . 'type.11', 11, $sbp2ExtRelPath . $sbp2IconPath . 'Client/sbp2_client.gif'),
                    array($sbp2Label . 'type.12', 12, $sbp2ExtRelPath . $sbp2IconPath . 'Category/sbp2_category.gif'),
                    array($sbp2Label . 'type.label.2', '--div--'),
                    array($sbp2Label . 'type.20', 20, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_item_category.gif'),
                    array($sbp2Label . 'type.21', 21, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_item_client.gif'),
                    array($sbp2Label . 'type.22', 22, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_item_tag.gif'),
                    array($sbp2Label . 'type.label.3', '--div--'),
                    array($sbp2Label . 'type.23', 23, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_client_category.gif'),
                    array($sbp2Label . 'type.24', 24, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_client_tag.gif'),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required',
				'default' => '10'
			),
		),
		'url' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'url',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
			'displayCond' => 'FIELD:type:=:1'
		),
		'page' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'page',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
			),
			'displayCond' => 'FIELD:type:=:2'
		),
		'item' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'item',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_sbportfolio2_domain_model_item',
				'size' => 1,
				'minitems' => 0,
				'maxitems' =>1,
				'module' => array(
					'name' => 'wizard_edit',
				),
			),
			'displayCond' => 'FIELD:type:=:10'
		),
		'client' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'client',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_sbportfolio2_domain_model_client',
				'size' => 1,
				'minitems' => 0,
				'maxitems' =>1,
				'module' => array(
					'name' => 'wizard_edit',
				),
			),
			'displayCond' => 'FIELD:type:IN:11,21'
		),
		'category' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'category',
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
			),
			'displayCond' => 'FIELD:type:IN:12,20,23'
		),
		'tag' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'tag',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_sbportfolio2_domain_model_tag',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'module' => array(
					'name' => 'wizard_edit',
				),
			),
			'displayCond' => 'FIELD:type:IN:22,24'
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
			'label' => $sbp2Label . 'image',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'disable_controls' => 'upload',
				'show_thumbs' => true
			),
		),
		'imagero' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagero',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'disable_controls' => 'upload',
				'show_thumbs' => true
			),
		),
		'icon' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'icon',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'disable_controls' => 'upload',
				'show_thumbs' => true
			),
		),
		'logo' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'logo',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'disable_controls' => 'upload',
				'show_thumbs' => true
			),
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
	),
);
?>
