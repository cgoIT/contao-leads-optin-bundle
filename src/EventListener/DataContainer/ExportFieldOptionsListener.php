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

namespace Cgoit\LeadsOptinBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Doctrine\DBAL\Connection;
use MenAtWork\MultiColumnWizardBundle\Contao\Widgets\MultiColumnWizard;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsCallback(table: 'tl_lead_export', target: 'fields.fields.eval.columnFields.field.options', priority: 100)]
class ExportFieldOptionsListener
{
    public function __construct(
        private readonly Connection $connection,
        private readonly TranslatorInterface $translator,
    ) {
    }

    /**
     * @return array<mixed>
     */
    public function __invoke(MultiColumnWizard $mcw): array
    {
        $options = [
            '_id' => $this->translator->trans('tl_lead_export._id', [], 'contao_tl_lead_export'),
            '_form' => $this->translator->trans('tl_lead_export._form', [], 'contao_tl_lead_export'),
            '_created' => $this->translator->trans('tl_lead_export._created', [], 'contao_tl_lead_export'),
            '_member' => $this->translator->trans('tl_lead_export._member', [], 'contao_tl_lead_export'),
            '_optin_token' => $this->translator->trans('tl_lead_export.optin_token', [], 'contao_tl_lead_export'),
            '_optin_ip' => $this->translator->trans('tl_lead_export.optin_ip', [], 'contao_tl_lead_export'),
            '_optin_tstamp' => $this->translator->trans('tl_lead_export.optin_tstamp', [], 'contao_tl_lead_export'),
            '_skip' => $this->translator->trans('tl_lead_export._skip', [], 'contao_tl_lead_export'),
        ];

        $fields = $this->connection->iterateAssociative(
            "SELECT id, name, label FROM tl_form_field WHERE leadStore!='' AND pid=(SELECT pid FROM tl_lead_export WHERE id=?) ORDER BY sorting",
            [(int) $mcw->dataContainer->id],
        );

        foreach ($fields as $field) {
            $label = $field['name'];

            if (!empty($field['label'])) {
                $label = $field['label'].' ['.$field['name'].']';
            }

            $options[$field['id']] = $label;
        }

        return $options;
    }
}
