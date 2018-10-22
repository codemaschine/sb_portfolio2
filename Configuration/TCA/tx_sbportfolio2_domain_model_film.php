<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$sbp2ExtRelPath		= 'EXT:sb_portfolio2/';
$sbp2IconPath		= 'Resources/Public/Icons/';
$sbp2LabelPath		= 'LLL:EXT:sb_portfolio2/Resources/Private/Language/locallang_db.xml:';
$sbp2Label			= $sbp2LabelPath . 'sbp2_film.';
$sbp2LabelShared	= $sbp2LabelPath . 'sbp2_shared.';
$sbp2Tab			= '--div--;' . $sbp2LabelPath . 'sbp2_tab';
$sbp2Pal			= '--palette--;' . $sbp2LabelPath . 'sbp2_palette';

$sbp2Fields	= 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, ' . $sbp2Pal . '.title;titlePalette, ' . $sbp2Pal . '.type;typePalette, ' . $sbp2Pal . '.file;filePalette, description, ' . $sbp2Tab . '.media, preview, ' . $sbp2Tab . '.access, hidden;;1, ' . $sbp2Pal . '.publishDates;publishDatesPalette';

return array(
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
        'iconfile' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film.gif',
        'searchFields' => 'title,titlefull,titleshort,description',
        'typeicon_column' => 'type',
        'typeicons' => array(
            '0' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film.gif',
            '1' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film_file.gif',
            '2' => $sbp2ExtRelPath	 . $sbp2IconPath . 'Film/sbp2_film_url.gif',
        ),
    ),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, type, title, titlefull, titleshort, hostid, film, filename, filetype, filesize, filepath, url, description, preview',
	),
	'types' => array(
		'0' => array('showitem' => $sbp2Fields),
		'1' => array('showitem' => $sbp2Fields),
		'2' => array('showitem' => $sbp2Fields),
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
		'typePalette' => array(
			'showitem'			=> 'type, host, hostid, film, url',
			'canNotCollapse'	=> 1
		),
		'filePalette' => array(
			'showitem'			=> 'filename, --linebreak--, filetype, filesize, --linebreak--, filepath',
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
				'foreign_table' => 'tx_sbportfolio2_domain_model_film',
				'foreign_table_where' => 'AND tx_sbportfolio2_domain_model_film.pid=###CURRENT_PID### AND tx_sbportfolio2_domain_model_film.sys_language_uid IN (-1,0)',
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
					array($sbp2Label . 'type.0', 0, $sbp2ExtRelPath . $sbp2IconPath . 'Film/sbp2_film.gif'),
					array($sbp2Label . 'type.1', 1, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_file.gif'),
					array($sbp2Label . 'type.2', 2, $sbp2ExtRelPath . $sbp2IconPath . 'Shared/sbp2_shared_link.gif'),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required',
                'default' => 0
			),
		),
		'host' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'host',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', -1,),
					array($sbp2Label . 'host.1', 0, $sbp2ExtRelPath . $sbp2IconPath . 'Film/sbp2_host_youtube.gif'),
					array($sbp2Label . 'host.2', 1, $sbp2ExtRelPath . $sbp2IconPath . 'Film/sbp2_host_vimeo.gif'),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required',
                'default' => '-1'
			),
			'displayCond' => 'FIELD:type:IN:0,2'
		),
		'hostid' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'hostid',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
			'displayCond' => 'FIELD:type:=:0'
		),
		'film' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'film',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'allowed' => 'avi,mpg,vob,mp4,mov,3gp,flv',
				'disallowed' => 'php',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 0,
				'disable_controls' => 'upload',
			),
			'displayCond' => 'FIELD:type:=:1'
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
			'displayCond' => 'FIELD:film:REQ:true',
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
			'displayCond' => 'FIELD:film:REQ:true',
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
			'displayCond' => 'FIELD:film:REQ:true',
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
			'displayCond' => 'FIELD:film:REQ:true',
		),
		'url' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'url',
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
			'displayCond' => 'FIELD:type:=:2'
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
		'preview' => array(
			'exclude' => 1,
			'label' => $sbp2Label . 'preview',
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
