<?php

class Orba_Sheepla_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getCultureIdByLocaleCode($lc) {
        switch ($lc) {
            case 'pl_PL': return 1045;
                break;
            case 'en_EN': return 1033;
                break;
            case 'ru_RU': return 1049;
                break;
            case 'de_DE': return 1031;
                break;
            default: return 1033;
        }
    }

    public function getConfigData($path) {
        $store_id = Mage::app()->getStore()->getId();
        if ($store_id) {
            return Mage::getStoreConfig($path, $store_id);
        } else {
            $store = Mage::app()->getFrontController()->getRequest()->getParam('store');
            if ($store) {
                return Mage::getStoreConfig($path, $store);
            }
            $website = Mage::app()->getFrontController()->getRequest()->getParam('website');
            if ($website) {
                return Mage::app()->getWebsite($website)->getConfig($path);
            }
            return Mage::getStoreConfig($path);
        }
    }

    public function getPublicApiKey() {
        if ($this->getConfigData('sheepla/api_config/public_api_key')) {
            return $this->getConfigData('sheepla/api_config/public_api_key');
        } else {
            return hash('sha256', $this->getConfigData('sheepla/api_config/api_key'));
        }
    }

    public function getAdminApiKey($sha = true) {
        if ($this->getConfigData('sheepla/api_config/public_api_key')) {
            return $this->getConfigData('sheepla/api_config/api_key');
        } else {
            if ($sha) {
                return hash('sha256', $this->getConfigData('sheepla/api_config/api_key'));
            } else {
                return $this->getConfigData('sheepla/api_config/api_key');
            }
        }
    }

    public function getOldSheeplaData() {
        return Mage::getSingleton('adminhtml/session_quote')->getOldSheeplaData();
    }

    public function getExtensionVersion() {
        return (string) Mage::getConfig()->getNode()->modules->Orba_Sheepla->version;
    }

}
