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

namespace Cgoit\LeadsOptinBundle\NotificationType;

use Terminal42\NotificationCenterBundle\NotificationType\NotificationTypeInterface;
use Terminal42\NotificationCenterBundle\Token\Definition\AnythingTokenDefinition;
use Terminal42\NotificationCenterBundle\Token\Definition\EmailTokenDefinition;
use Terminal42\NotificationCenterBundle\Token\Definition\Factory\TokenDefinitionFactoryInterface;
use Terminal42\NotificationCenterBundle\Token\Definition\TextTokenDefinition;

class LeadsOptinNotification implements NotificationTypeInterface
{
    public const NAME = 'leads_optin_notification';

    public function __construct(private readonly TokenDefinitionFactoryInterface $tokenDefinitionFactory)
    {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getTokenDefinitions(): array
    {
        return [
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'form_*', 'form.form_*'),
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'formconfig_*', 'form.formconfig_*'),
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'formlabel_*', 'form.formlabel_*'),
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'optin_url', 'optin.optin_url'),
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'optin_token', 'optin.optin_token'),
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'lead_*', 'leads.lead_*'),
            $this->tokenDefinitionFactory->create(TextTokenDefinition::class, 'raw_data', 'form.raw_data'),
            $this->tokenDefinitionFactory->create(TextTokenDefinition::class, 'raw_data_filled', 'form.raw_data_filled'),
            $this->tokenDefinitionFactory->create(EmailTokenDefinition::class, 'admin_email', 'page.admin_email'),
            $this->tokenDefinitionFactory->create(AnythingTokenDefinition::class, 'filenames', 'file.filenames'),
        ];
    }
}
