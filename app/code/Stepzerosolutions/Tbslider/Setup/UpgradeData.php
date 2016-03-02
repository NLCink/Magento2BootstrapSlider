<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Stepzerosolutions\Tbslider\Model\Slider;
/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * Customer setup factory
     *
     * @var SliderFactory
     */
    protected $sliderFactory;


    public function __construct(
        SliderFactory $sliderFactory,
        IndexerRegistry $indexerRegistry,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->sliderFactory = $sliderFactory;
    }
	
	
    public function upgrade(
	        ModuleDataSetupInterface $setup,
	        ModuleContextInterface $context
	    ) {
	        $setup->startSetup();
			if (version_compare($context->getVersion(), '1.0.1') < 0) {
			/**
			 * Create New field called stores in 'slider'
			 */
			 $tableName = $setup->getTable('slider');
			 if ($setup->getConnection()->isTableExists($tableName) == true) {
				$columns = [
                    'stores' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'stores data',
                    ],
                ];
				
               	$connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
			 }
			}
			
			if (version_compare($context->getVersion(), '1.0.2') < 0) {
			/**
			 * Create New field called is_active in 'slider'
			 */
			 $tableName = $setup->getTable('slider_items');
			 if ($setup->getConnection()->isTableExists($tableName) == true) {
				$columns = [
                    'is_active' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'nullable' => false,
                        'comment' => 'Slider item Is active',
                    ],
                ];
				$remove = ['status'];
				
               	$connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
                foreach ($remove as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
			 }
			}
			
			if (version_compare($context->getVersion(), '1.0.3') < 0) {
			/**
			 * Create New field called is_active in 'slider'
			 */
			 $tableName = $setup->getTable('slider');
			 if ($setup->getConnection()->isTableExists($tableName) == true) {
				$columns = [
                    'is_active' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'nullable' => false,
                        'comment' => 'Slider item Is active',
                    ],
                ];
				$remove = ['status'];
				
               	$connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
                foreach ($remove as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }
			 }
			}
			

		  $setup->endSetup();
    }
}
