<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-leads-optin-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @author     Christopher Bölter
 * @license    LGPL-3.0-or-later
 */

use Cgoit\LeadsOptinBundle\Controller\Module\LeadsOptInModule;

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes'][LeadsOptInModule::TYPE] =
    '{title_legend},name,headline,type;{leadsoptin_legend},leadOptInSuccessType,leadOptInErrorMessage,leadOptInSuccessNotification,leadOptIndNeedsUserInteraction;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'leadOptInSuccessType';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'leadOptIndNeedsUserInteraction';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['leadOptIndNeedsUserInteraction'] =
    'leadOptInUserInteractionMessage,leadOptInUserInteractionSubmit';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['leadOptInSuccessType_message'] = 'leadOptInSuccessMessage';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['leadOptInSuccessType_redirect'] = 'leadOptInSuccessJumpTo';

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInSuccessType'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['message', 'redirect'],
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => ['tl_class' => 'w50', 'submitOnChange' => true],
    'sql' => "varchar(8) NOT NULL default 'message'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInSuccessMessage'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInSuccessJumpTo'] = [
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => ['fieldType' => 'radio', 'tl_class' => 'clr'],
    'sql' => 'int(10) unsigned NOT NULL default 0',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInErrorMessage'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'clr long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInSuccessNotification'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => ['tl_class' => 'w50 m12', 'includeBlankOption' => true, 'mandatory' => false],
    'sql' => "int(10) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptIndNeedsUserInteraction'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInUserInteractionMessage'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['leadOptInUserInteractionSubmit'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(256) NOT NULL default ''",
];
