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

namespace Cgoit\LeadsOptinBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class UpdateModuleType extends AbstractMigration
{
    /**
     * @var array<string>
     */
    private static array $arrTables = ['tl_module'];

    private static string $column = 'type';

    private static string $oldValue = 'leadsoptin';

    private static string $newValue = 'leads_optin';

    public function __construct(private readonly Connection $db)
    {
    }

    public function getName(): string
    {
        return 'Set correct type for leads optin frontend module';
    }

    /**
     * @throws Exception
     */
    public function shouldRun(): bool
    {
        foreach (self::$arrTables as $table) {
            $oldTypeValue = (int) $this->db
                ->executeQuery('SELECT COUNT('.self::$column.') FROM '.$table." WHERE type = '".self::$oldValue."'")
                ->fetchOne() > 0
            ;

            if ($oldTypeValue) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function run(): MigrationResult
    {
        foreach (self::$arrTables as $table) {
            $this->db->update($table, [self::$column => self::$newValue], [self::$column => self::$oldValue]);
        }

        return $this->createResult(true);
    }
}
