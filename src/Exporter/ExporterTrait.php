<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-leads-optin-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @author     Christopher Bölter
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\LeadsOptinBundle\Exporter;

use Contao\StringUtil;
use Symfony\Contracts\Translation\TranslatorInterface;
use Terminal42\LeadsBundle\Export\AbstractExporter;

trait ExporterTrait
{
    /**
     * @param array<mixed> $arrColumns
     *
     * @return array<mixed>
     */
    protected function addColumns(TranslatorInterface $translator, array $arrColumns): array
    {
        $config = $this->getConfig();
        $fields = StringUtil::deserialize($config['fields'], true);
        $arrExportFields = array_column($fields, 'field');

        $arrOptinKeys = [
            [
                'id' => '_optin_token',
                'name' => $translator->trans('tl_lead_export.optin_token', [], 'contao_tl_lead_export'),
                'output' => AbstractExporter::OUTPUT_VALUE,
                'value' => static fn ($lead) => $lead['optin_token'],
                'label' => static fn ($lead) => '',
            ],
            [
                'id' => '_optin_tstamp',
                'name' => $translator->trans('tl_lead_export.optin_tstamp', [], 'contao_tl_lead_export'),
                'output' => AbstractExporter::OUTPUT_VALUE,
                'format' => 'datim',
                'value' => static fn ($lead) => $lead['optin_tstamp'],
                'label' => static fn () => '',
            ],
            [
                'id' => '_optin_ip',
                'name' => $translator->trans('tl_lead_export.optin_ip', [], 'contao_tl_lead_export'),
                'output' => AbstractExporter::OUTPUT_VALUE,
                'value' => static fn ($lead) => $lead['optin_ip'],
                'label' => static fn () => '',
            ],
        ];

        $arrOptinKeys = array_filter($arrOptinKeys, static fn ($arrOptinKey) => \in_array($arrOptinKey['id'], $arrExportFields, true));

        return array_merge($arrColumns, $arrOptinKeys);
    }

    /**
     * @param array<mixed> $lead
     *
     * @return array<mixed>
     */
    protected function getTokens(array $lead): array
    {
        return array_merge(parent::getTokens($lead), [
            '_optin_token' => $lead['optin_token'],
            '_optin_tstamp' => $lead['optin_tstamp'],
            '_optin_ip' => $lead['optin_ip'],
        ]);
    }
}
