<?php
class FTrade_Customer_Model_Observer
{
    public function saveCompanyDetails(Varien_Event_Observer $observer)
    {
        $address = $observer->getEvent()->getCustomerAddress();
        $request = Mage::app()->getRequest();
        
        $attrCode = 'company_details_file';        
        
        if (isset($_FILES[$attrCode . '_file'])) {
            $companyDetails = $_FILES[$attrCode . '_file'];
        } else {
            $companyDetails = array();
        }
        
        $delete = $request->getParam($attrCode . '_delete');
        if (!empty($delete)) {
            $companyDetails['delete'] = true;
        }

        $value = $request->getParam($attrCode);
        if (!empty($value)) {
            $companyDetails['original'] = $value;
        }
        
        if (!empty($companyDetails['tmp_name']) && !is_uploaded_file($companyDetails['tmp_name'])) {
            return $this;
        }
        
        $toDelete  = false;
        if (!empty($companyDetails['original'])) {
            if (!empty($companyDetails['delete'])) {
                $toDelete  = true;
            }
            if (!empty($companyDetails['tmp_name'])) {
                $toDelete  = true;
            }
        }

        $path   = Mage::getBaseDir('media') . DS . 'customer_address';

        // unlink entity file
        if ($toDelete) {
            $address->setCompanyDetailsFile('');
            $file = $path . $companyDetails['original'];
            $ioFile = new Varien_Io_File();
            if ($ioFile->fileExists($file)) {
                $ioFile->rm($file);
            }
        }

        if (!empty($companyDetails['tmp_name'])) {
            try {
                $uploader = new Varien_File_Uploader($companyDetails);
                $uploader->setFilesDispersion(true);
                $uploader->setFilenamesCaseSensitivity(false);
                $uploader->setAllowRenameFiles(true);
                $uploader->save($path, $companyDetails['name']);
                $fileName = $uploader->getUploadedFileName();
                $address->setCompanyDetailsFile($fileName);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }

        return $this;
    }
}
