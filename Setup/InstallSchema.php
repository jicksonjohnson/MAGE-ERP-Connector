<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{
    const HELLOMAGE_ERP_CONNECTOR_API_RECORDS_TABLE = 'hellomage_erp_api_connector_records';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws Zend_Db_Exception
     * @SuppressWarnings(Unused)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        if ($installer->tableExists(self::HELLOMAGE_ERP_CONNECTOR_API_RECORDS_TABLE)) {
            $connection->dropTable($installer->getTable(self::HELLOMAGE_ERP_CONNECTOR_API_RECORDS_TABLE));
        }
        $table = $connection
            ->newTable($installer->getTable(self::HELLOMAGE_ERP_CONNECTOR_API_RECORDS_TABLE))
            ->addColumn(
                'record_id',
                Table::TYPE_INTEGER,
                null,
                [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true
            ],
                'Record ID'
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                11,
                [
                    'nullable' => false,
                    'unsigned' => true
                ],
                'Entity Id'
            )
            ->addColumn(
                'event',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true,
                ],
                'Event'
            )
            ->addColumn(
                'note',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true,
                ],
                'Note'
            )
            ->addColumn(
                'type',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true,
                ],
                'Type'
            )
            ->addColumn(
                'status',
                Table::TYPE_INTEGER,
                11,
                [
                    'nullable' => false,
                    'unsigned' => true,
                    'default' => 0
                ],
                'Status'
            )
            ->addColumn(
                'creation_time',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'unsigned' => false,
                    'nullable' => false
                ],
                'Created Time'
            )
            ->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'unsigned' => false,
                    'nullable' => false
                ],
                'Updated At'
            )
            ->setComment('HelloMage ERP API Connector Table');

        $connection->createTable($table);

        $installer->endSetup();
    }
}
