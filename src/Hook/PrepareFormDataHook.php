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

namespace Cgoit\LeadsOptinBundle\Hook;

use Cgoit\LeadsOptinBundle\Util\Constants;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Form;
use Contao\Widget;

/**
 * Provides several function to access leads hooks and send notifications.
 */
#[AsHook('prepareFormData')]
class PrepareFormDataHook
{
    /**
     * @param array<mixed>  $submittedData
     * @param array<mixed>  $labels
     * @param array<Widget> $fields
     */
    public function __invoke(array &$submittedData, array $labels, array $fields, Form $form): void
    {
        if (!isset($form->leadEnabled) || !$form->leadEnabled || !isset($form->leadOptIn) || !$form->leadOptIn) {
            return;
        }

        $uniqueId = md5(uniqid((string) mt_rand(), true));
        $submittedData[Constants::$OPTIN_FORMFIELD_NAME] = $uniqueId;
    }
}
