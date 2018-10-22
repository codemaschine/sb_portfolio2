<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2ExtRelPath		= 'EXT:sb_portfolio2/';
$sbp2IconPath		= 'Resources/Public/Icons/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2Label			= $sbp2LabelPath . 'sbp2_image.';
$sbp2LabelShared	= $sbp2LabelPath . 'sbp2_shared.';
$sbp2Tab			= '--div--;' . $sbp2LabelPath . 'sbp2_tab';
$sbp2Pal			= '--palette--;' . $sbp2LabelPath . 'sbp2_palette';

return array(
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
        'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Image/sbp2_image.gif',
        'searchFields' => 'title,titlefull,titleshort,description,caption'
    ),
  'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, titlefull, titleshort, description, imagefile, caption, imagename, imagepath, imagesize, imagetype, imagewidth, imageheight, imageorientation',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, ' . $sbp2Pal . '.title;titlePalette, imagefile, ' . $sbp2Pal . '.image;imagePalette, description, caption, ' . $sbp2Tab . '.access, hidden;;1, ' . $sbp2Pal . '.publishDates;publishDatesPalette'),
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
		'imagePalette' => array(
			'showitem'			=> 'imagename, --linebreak--, imagetype, imagesize, --linebreak--, imagepath, --linebreak--, imagewidth, imageheight, imageorientation',
			'canNotCollapse'	=> 0
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
				'foreign_table' => 'tx_sbportfolio2_domain_model_image',
				'foreign_table_where' => 'AND tx_sbportfolio2_domain_model_image.pid=###CURRENT_PID### AND tx_sbportfolio2_domain_model_image.sys_language_uid IN (-1,0)',
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
		'imagefile' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagefile',
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
		'imagename' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagename',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 30,
				'eval'     => 'trim',
				'default'  => '',
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'imagepath' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagepath',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 30,
				'eval'     => 'trim',
				'default'  => '',
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'imagesize' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagesize',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 15,
				'max'      => 30,
				'eval'     => 'num',
				'default'  => 0,
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'imagetype' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagetype',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 4,
				'max'      => 4,
				'eval'     => 'alphanum',
				'default'  => '',
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'imagewidth' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imagewidth',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 8,
				'max'      => 10,
				'eval'     => 'num',
				'default'  => 0,
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'imageheight' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imageheight',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 8,
				'max'      => 10,
				'eval'     => 'num',
				'default'  => 0,
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'imageorientation' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'imageorientation',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type'     => 'input',
				'size'     => 1,
				'max'      => 1,
				'eval'     => 'num',
				'default'  => 0,
				'readOnly' => 1
			),
			'displayCond' => 'FIELD:imagefile:REQ:true',
		),
		'description' => array(
			'exclude' => 1,
			'label' => $sbp2LabelShared . 'description',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 3,
				'eval' => 'trim'
			),
		),
		'caption' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'caption',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 3,
				'eval' => 'trim'
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
		'item' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'sorting' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
?>
