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
 * @category   Mage
 * @package    Mage_Customer
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Customer resource setup model
 *
 * @category   Mage
 * @package    Mage_Customer
 */
class FTrade_Customer_Model_Entity_Setup extends Mage_Customer_Model_Entity_Setup
{
    public function getDefaultEntities()
    {
        $entities = array(
            'customer_address'               => array(
                'entity_model'                   => 'customer/address',
                'attribute_model'                => 'customer/attribute',
                'table'                          => 'customer/address_entity',
                'additional_attribute_table'     => 'customer/eav_attribute',
                'entity_attribute_collection'    => 'customer/address_attribute_collection',
                'attributes'                     => array(
                    'inn' => array(
                        'type'          => 'varchar',
                        'label'         => 'INN',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 150,
                        'sort_order'    => 150,
                    ),
                    'kpp' => array(
                        'type'          => 'varchar',
                        'label'         => 'KPP',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 160,
                        'sort_order'    => 160,
                    ),
                    'bank_account' => array(
                        'type'          => 'varchar',
                        'label'         => 'Bank Account',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 170,
                        'sort_order'    => 170,
                    ),
                    'bank' => array(
                        'type'          => 'varchar',
                        'label'         => 'Bank',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 180,
                        'sort_order'    => 180,
                    ),
                    'c_account' => array(
                        'type'          => 'varchar',
                        'label'         => 'Correspondent Account',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 190,
                        'sort_order'    => 190,
                    ),
                    'bik' => array(
                        'type'          => 'varchar',
                        'label'         => 'BIK',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 200,
                        'sort_order'    => 200,
                    ),
                    'allocate_nds' => array(
                        'type'          => 'int',
                        'label'         => 'Allocate NDS in the invoice',
                        'input'         => 'select',
                        'source'        => 'eav/entity_attribute_source_boolean',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 210,
                        'sort_order'    => 210,
                    ),
                    'company_details_file' => array(
                        'type'          => 'text',
                        'label'         => 'Company details',
                        'input'         => 'text',
                        'required'      => false,
                        'system'        => false,
                        'position'      => 220,
                        'sort_order'    => 220,
                    ),
                )
            )
        );
        return $entities;
    }

}
