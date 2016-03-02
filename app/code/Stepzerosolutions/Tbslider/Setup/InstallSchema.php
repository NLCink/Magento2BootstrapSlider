<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'slider'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('slider')
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'auto_increment' => true ],
            'Slider id'
        )->addColumn(
            'slider_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Slider Title'
        )->addColumn(
            'slider_description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            [],
            'Slider description'
        )->addColumn(
            'slider_width',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            4,
            []
        )->addColumn(
            'slider_height',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_widthxs',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_heighthxs',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_widthsm',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_heightsm',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_widthmd',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_heightmd',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            'slider_class',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            50,
            []
        )->addColumn(
            'slider_bgcolor',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            7,
            []
        )->addColumn(
            'slider_autoresponsive',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            []
        )->addColumn(
            'slider_type',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            2,
            []
        )->addColumn(
            'pauseonhover',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            10,
            []
        )->addColumn(
            'wrap',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            []
        )->addColumn(
            'keyboard',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            []
        )->addColumn(
            'slidermeta',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'slider_hidexs',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            []
        )->addColumn(
            'slider_duration',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            6,
            []
        )->addColumn(
            'date',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            null,
            []
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            []
        )->addColumn(
            'timestamp',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            []
        )->setComment(
            'Slider Table'
        );
        $installer->getConnection()->createTable($table);
		
		
        /**
         * Create table 'slider_items'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('slider_items')
        )->addColumn(
            'slideritem_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'auto_increment' => true ],
            'Slider item id'
        )->addColumn(
            'slideritem_slider',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            ['nullable' => false]
        )->addColumn(
            'slideritem_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            200,
            ['nullable' => false]
        )->addColumn(
            'slideritem_description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            []
        )->addColumn(
            'slider_image_path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false]
        )->addColumn(
            'slider_image_md_path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'slider_image_sm_path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'slider_image_xs_path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'slider_url',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            []
        )->addColumn(
            'date',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            null,
            []
        )->addColumn(
            'timestamp',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            []
        )->addColumn(
            'slider_sort',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            5,
            []
        )->addColumn(
            'captionmeta',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            []
        )->setComment(
            'Slider Items Table'
        );
        $installer->getConnection()->createTable($table);
		

		
        $installer->endSetup();

    }
}
