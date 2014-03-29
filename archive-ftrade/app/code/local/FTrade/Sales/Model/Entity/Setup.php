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


class FTrade_Sales_Model_Entity_Setup extends Mage_Eav_Model_Entity_Setup
{
    public function getDefaultEntities()
    {
        return array(
            'quote' => array(
                'entity_model'  => 'sales/quote',
                'table'         => 'sales/quote',
                'attributes' => array(
                    'favorite_carrier' => array('type'=>'static'),
                ),
            ),

            'quote_address' => array(
                'entity_model'  => 'sales/quote_address',
                'table'         => 'sales/quote_address',
                'attributes' => array(
                    'inn' => array('type'=>'static'),
                    'kpp' => array('type'=>'static'),
                    'bank_account' => array('type'=>'static'),
                    'bank' => array('type'=>'static'),
                    'c_account' => array('type'=>'static'),
                    'bik' => array('type'=>'static'),
                    'allocate_nds' => array('type'=>'static'),
                    'company_details_file' => array('type'=>'static'),
                ),
            ),

            'order' => array(
                'entity_model'      => 'sales/order',
                'table'=>'sales/order',
                'increment_model'=>'eav/entity_increment_numeric',
                'increment_per_store'=>true,
                'backend_prefix'=>'sales_entity/order_attribute_backend',
                'attributes' => array(
                    'favorite_carrier' => array('type'=>'varchar'),
                ),
            ),
            'order_address' => array(
                'entity_model'      => 'sales/order_address',
                'table'=>'sales/order_entity',
                'attributes' => array(
                    'inn' => array(),
                    'kpp' => array(),
                    'bank_account' => array(),
                    'bank' => array(),
                    'c_account' => array(),
                    'bik' => array(),
                    'company_details_file' => array(),
                    'allocate_nds' => array('type'=>'int'),
                ),
            ),
        );
    }
}
