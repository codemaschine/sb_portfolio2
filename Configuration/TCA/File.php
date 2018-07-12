<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2Label			= $sbp2LabelPath . 'sbp2_file.';
$sbp2LabelShared	= $sbp2LabelPath . 'sbp2_shared.';
$sbp2Tab			= '--div--;' . $sbp2LabelPath . 'sbp2_tab';
$sbp2Pal			= '--palette--;' . $sbp2LabelPath . 'sbp2_palette';

$TCA['tx_sbportfolio2_domain_model_file'] = array(
	'ctrl' => $TCA['tx_sbportfolio2_domain_model_file']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, titlefull, titleshort, description, file, filename, filetype, filesize, filepath',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, ' . $sbp2Pal . '.title;titlePalette, description, file, ' . $sbp2Pal . '.file;filePalette, ' . $sbp2Tab . '.access, hidden;;1, ' . $sbp2Pal . '.publishDates;publishDatesPalette'),
	),
	'palettes' => array(
		'titlePalette' => array(
			'showitem'			=> 'title, --linebreak--, titlefull, titleshort',
			'canNotCollapse'	=> 1
		),
		'filePalette' => array(
			'showitem'			=> 'filename, --linebreak--, filetype, filesize, --linebreak--, filepath',
			'canNotCollapse'	=> 0
		),
		'publishDatesPalette' => array(
			'showitem'			=> 'starttime, endtime',
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
				'foreign_table' => 'tx_sbportfolio2_domain_model_file',
				'foreign_table_where' => 'AND tx_sbportfolio2_domain_model_file.pid=###CURRENT_PID### AND tx_sbportfolio2_domain_model_file.sys_language_uid IN (-1,0)',
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
				'autoSizeMax' => 10,
				'maxitems' => 1,
				'minitems' => 0,
				'disable_controls' => 'upload',
				'show_thumbs' => true
			),
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