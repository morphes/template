<?php
require_once 'Mage/ImportExport/controllers/Adminhtml/ImportController.php';

class FTrade_Import_Adminhtml_ImportController extends Mage_ImportExport_Adminhtml_ImportController
{
    public function from1cAction()
    {
        if ($this->getRequest()->isPost()) {
            $file = $_FILES['import_file'];
            $importFile = $file['tmp_name'];

            if ($file['error'] > UPLOAD_ERR_OK && !is_uploaded_file($importFile)) {
                echo 'Error on file uploading. Trying to use var/import/import.csv for import<br>';
                $importFile = Mage::getBaseDir() . '/var/import/import.csv';
            }

            $importModel = Mage::getModel('import/magmi');
            $output = $importModel->importFrom1C($importFile);

            echo '<pre>';
            echo implode("\n", $output);
            echo '</pre>';
        } else {
            echo '<form method="post" action="" enctype="multipart/form-data">';
            echo '<input type="file" name="import_file" />';
            echo '<input name="form_key" type="hidden" value="' . Mage::getSingleton('core/session')->getFormKey() . '" />';
            echo '<input type="submit" name="submit" value="Import" />';
            echo '</form>';
        }
    }
}
