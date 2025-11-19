<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-leads-optin-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @author     Christopher Bölter
 * @author     Carsten Götzinger
 * @license    LGPL-3.0-or-later
 */

// Palettes
$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'leadOptIn';
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['leadOptIn'] = 'leadOptInNotification,leadOptInStoreIp,leadOptInTarget';

$GLOBALS['TL_DCA']['tl_form']['fields']['leadOptIn'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12', 'submitOnChange' => true],
    'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_form']['fields']['leadOptInStoreIp'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_form']['fields']['leadOptInNotification'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true, 'mandatory' => true],
    'sql' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'default' => 0],
];

$GLOBALS['TL_DCA']['tl_form']['fields']['leadOptInTarget'] = [
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => [
        'fieldType' => 'radio',
        'tl_class' => 'w50',
    ],
    'sql' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'default' => 0],
    'relation' => [
        'type' => 'hasOne',
        'load' => 'eager',
    ],
];
