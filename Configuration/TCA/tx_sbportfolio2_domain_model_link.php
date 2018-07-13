<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2ExtRelPath		= \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('sb_portfolio2');
$sbp2IconPath		= 'Resources/Public/Icons/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2Label			= $sbp2LabelPath . 'sbp2_link.';
$sbp2LabelShared	= $sbp2LabelPath . 'sbp2_shared.';
$sbp2Tab			= '--div--;' . $sbp2LabelPath . 'sbp2_tab';
$sbp2Pal			= '--palette--;' . $sbp2LabelPath . 'sbp2_palette';

$sbp2FieldsStart	= 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, ' . $sbp2Pal . '.title;titlePalette, ' . $sbp2Pal . '.type;typePalette, ';
$sbp2FieldsEnd		= $sbp2Tab . '.access, hidden;;1, ' . $sbp2Pal . '.publishDates;publishDatesPalette';

return array(
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
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, titlefull, titleshort, type, url, page, file, filename, filetype, filesize, filepath, item, client, category, tag, nofollow',
	),
	'types' => array(
		'0' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'1' => array('showitem' => $sbp2FieldsStart . $sbp2Pal . '.file;filePalette, ' . $sbp2FieldsEnd),
		'2' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'10' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'11' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'12' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'20' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'21' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'22' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'23' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
		'24' => array('showitem' => $sbp2FieldsStart . $sbp2FieldsEnd),
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
		'filePalette' => array(
			'showitem'			=> 'filename, --linebreak--, filetype, filesize, --linebreak--, filepath',
			'canNotCollapse'	=> 0
		),
		'typePalette' => array(
			'showitem'			=> 'type, --linebreak--, url, nofollow, file, page, item, client, category, tag',
			'canNotCollapse'	=> 1
		),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
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
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
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
					array($sbp2Label . 'type.1', 1, $sbp2ExtRelPath . $sbp2IconPath . 'File/sbp2_file.gif'),
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
				'default' => 0
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
			'displayCond' => 'FIELD:type:=:0'
		),
		'nofollow' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'nofollow',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
			'displayCond' => 'FIELD:type:=:0'
		),
		'file' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'file',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'allowed' => '*',
				'disallowed' => 'php',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
				'disable_controls' => 'upload',
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
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'suggest' => array(
						'type' => 'suggest',
			            'tx_sbportfolio2_domain_model_item' => array(
			                'maxItemsInResultList' => 5,
			            ),
					),
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
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'suggest' => array(
						'type' => 'suggest',
			            'tx_sbportfolio2_domain_model_client' => array(
			                'maxItemsInResultList' => 5,
			            ),
					),
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
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'suggest' => array(
						'type' => 'suggest',
			            'tx_sbportfolio2_domain_model_tag' => array(
			                'maxItemsInResultList' => 5,
			            ),
					),
				),
			),
			'displayCond' => 'FIELD:type:IN:22,24'
		),
		'filename' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'filename',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 30,
				'eval'     => 'trim',
				'default'  => '',
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:file:REQ:true',
		),
		'filepath' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'filepath',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 30,
				'eval'     => 'trim',
				'default'  => '',
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:file:REQ:true',
		),
		'filesize' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'filesize',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 15,
				'max'      => 30,
				'eval'     => 'num',
				'default'  => 0,
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:file:REQ:true',
		),
		'filetype' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'filetype',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 4,
				'max'      => 4,
				'eval'     => 'alphanum',
				'default'  => '',
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:file:REQ:true',
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
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