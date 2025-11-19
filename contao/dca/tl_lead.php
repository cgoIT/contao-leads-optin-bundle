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

// Keys
$GLOBALS['TL_DCA']['tl_lead']['config']['sql']['keys']['optin_token'] = 'index';
$GLOBALS['TL_DCA']['tl_lead']['config']['sql']['keys']['post_data'] = 'index';

// Operations
$GLOBALS['TL_DCA']['tl_lead']['list']['operations']['leadsoptin'] = [
    'icon' => 'member.svg',
];

// Fields
$GLOBALS['TL_DCA']['tl_lead']['fields']['optin_token'] = [
    'sql' => ['type' => 'string', 'length' => 32, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_lead']['fields']['optin_tstamp'] = [
    'sql' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'default' => 0],
];

$GLOBALS['TL_DCA']['tl_lead']['fields']['optin_files'] = [
    'sql' => ['type' => 'text', 'length' => 65535, 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_lead']['fields']['optin_labels'] = [
    'sql' => ['type' => 'text', 'length' => 65535, 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_lead']['fields']['optin_ip'] = [
    'sql' => ['type' => 'string', 'length' => 64, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_lead']['fields']['optin_notification_tstamp'] = [
    'sql' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'default' => 0],
];
