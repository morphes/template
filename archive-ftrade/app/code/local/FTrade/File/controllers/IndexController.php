<?php

class FTrade_File_IndexController extends Mage_Core_Controller_Front_Action
{
    public function uploadAction()
    {
        $code = 'company_details_file';
        $value = array();
        $result = array();
        
        if (isset($_FILES[$code])) {
            $value = $_FILES[$code];
        }
        
        if (count($value) == 0) {
            $result['error'] = 'File was not uploaded';
        } else if (isset($value['tmp_name']) && !is_uploaded_file($value['tmp_name'])) {
            $result['error'] = 'Not valid file';
        } else {
            $path   = Mage::getBaseDir('media') . DS . $this->getRequest()->getParam('type');

            if (isset($value['tmp_name']) && !empty($value['tmp_name'])) {
                try {
                    $uploader = new Varien_File_Uploader($value);
                    $uploader->setFilesDispersion(true);
                    $uploader->setFilenamesCaseSensitivity(false);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->save($path, $value['name']);
                    $fileName = $uploader->getUploadedFileName();
                    
                    $result[$code] = $fileName;
                    $result['success'] = true;
                } catch (Exception $e) {
                    $result['error'] = 'Unable to save file';
                    Mage::logException($e);
                }
            }
        }
        
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}
