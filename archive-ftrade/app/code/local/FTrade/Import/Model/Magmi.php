<?php

require_once 'magmi/inc/magmi_defs.php';
require_once 'magmi/integration/inc/magmi_datapump.php';

class FTrade_Import_Model_Magmi_Logger
{
    protected $_data = array();

    public function log( $data, $type )
    {
        if ( $type == 'dbtime' || $type == 'itime' )
        {
            return;
        }

        $this->_data[] = $data;
    }

    public function getData()
    {
        return $this->_data;
    }
}

class FTrade_Import_Model_Magmi
{
    public function importFrom1C( $importFile )
    {
        $output = array();

        try {
            // check if file exists
            if ( !file_exists( $importFile ) ) {
                throw new Exception( 'Import file does not exist' );
            }

            // read the file
            $products = file( $importFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
            if ( $products === false ) {
                throw new Exception( 'Unable to read the import file. Check permissions' );
            }

            // change encoding to utf8 and parse csv string
            $products = array_map( function( $str ) {
                return str_getcsv( iconv( 'WINDOWS-1251', 'UTF-8', $str ) );
            }, $products );

            foreach ( $products as $line => $product ) {
                if ( count( $product ) != 6 ) {
                    $output[] = 'Import file error, unable to process row in line #' . ( $line + 1 );
                }
            }

            $products = array_filter( $products, function( $product ) {
                return count( $product ) == 6;
            });

            // init data pump
            $logger = new FTrade_Import_Model_Magmi_Logger();
            $dp = Magmi_DataPumpFactory::getDataPumpInstance( 'productimport' );
            $dp->beginImportSession( 'default', 'update', $logger );

            // save skus
            $skus = array();
            foreach ( $products as $product ) {
                $skus[] = $product[ 1 ];
            }

            // process rows
            array_walk( $products, function( $product, $key, $dp ) {
                $special_price = (int) $product[ 5 ];
                $item = array(
                    'store' => 'admin',
                    'sku' => $product[ 1 ],
                    'qty' => $product[ 3 ],
                    'price' => $product[ 2 ],
                    'visibility' => '4',
                    'special_price' => $special_price > 0 ? $product[ 5 ] : '',
                    'special_from_date' => $special_price > 0 ? date('Y-m-d 00:00:00') : '',
                    'special_to_date' => '',
                    'is_in_stock' => '1',
                    'status' => '1',
                    'manage_stock' => (int) $product[ 3 ] > 0 ? '1' : '0',
                    'use_config_manage_stock' => (int) $product[ 3 ] > 0 ? '1' : '0'
                );

                $dp->ingest( $item );
            }, $dp);

            // disable all products which were not imported
            $resource = Mage::getSingleton( 'core/resource' );
            $readConnection = $resource->getConnection( 'core_read' );
            $results = $readConnection->fetchAll( 'SELECT sku FROM catalog_product_entity' );

            foreach ( $results as $row ) {
                $sku = $row[ 'sku' ];
                if ( !in_array( $sku, $skus ) && is_numeric( $sku ) ) {
                    $item = array(
                        'store' => 'admin',
                        'sku' => $sku,
                        'qty' => '0',
                        'visibility' => '3',
                        'is_in_stock' => '0',
                        'use_config_manage_stock' => '0',
                        'manage_stock' => '1',
                        'yml' => '0'
                    );

                    $dp->ingest( $item );
                }
            }

            $dp->endImportSession();

            $output += $logger->getData();

            // remove file
            unlink( $importFile );
        } catch ( Exception $e ) {
            $output[] = $e->getMessage();
        }
        
        return $output;
    }
}
