<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Sales_Model_Entity_Setup */

$conn = $installer->getConnection();
/* @var $conn Varien_Db_Adapter_Pdo_Mysql */

$conn->addColumn($installer->getTable('sales_flat_quote'), 'favorite_carrier', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order'), 'favorite_carrier', 'varchar(40)');

$installer->addAttribute('quote', 'favorite_carrier', array('type'=>'static'));
$installer->addAttribute('order', 'favorite_carrier', array('type'=>'varchar'));

$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'inn', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'kpp', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'bank_account', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'bank', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'c_account', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'bik', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_quote_address'), 'allocate_nds', 'tinyint(1) unsigned default 0');

$conn->addColumn($installer->getTable('sales_flat_order_address'), 'inn', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order_address'), 'kpp', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order_address'), 'bank_account', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order_address'), 'bank', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order_address'), 'c_account', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order_address'), 'bik', 'varchar(40)');
$conn->addColumn($installer->getTable('sales_flat_order_address'), 'allocate_nds', 'tinyint(1) unsigned default 0');

$installer->addAttribute('quote_address', 'inn', array('type'=>'static'));
$installer->addAttribute('quote_address', 'kpp', array('type'=>'static'));
$installer->addAttribute('quote_address', 'bank_account', array('type'=>'static'));
$installer->addAttribute('quote_address', 'bank', array('type'=>'static'));
$installer->addAttribute('quote_address', 'c_account', array('type'=>'static'));
$installer->addAttribute('quote_address', 'bik', array('type'=>'static'));
$installer->addAttribute('quote_address', 'allocate_nds', array('type'=>'static'));

$installer->addAttribute('order_address', 'inn', array());
$installer->addAttribute('order_address', 'kpp', array());
$installer->addAttribute('order_address', 'bank_account', array());
$installer->addAttribute('order_address', 'bank', array());
$installer->addAttribute('order_address', 'c_account', array());
$installer->addAttribute('order_address', 'bik', array());
$installer->addAttribute('order_address', 'allocate_nds', array('type'=>'int'));

$installer->endSetup();
