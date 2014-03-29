<?php

/**
 * Created by ORBA|we-commerce your business -> http://orba.pl
 * 
 */
class Orba_Sheepla_AdminController extends Mage_Adminhtml_Controller_Action
{
	
	protected $sheeplaProxyModel;
	protected $sheeplaDataModel;
	protected $sp;
	
	
	public function indexAction(){
		// "Fetch" display
    	$this->loadLayout();
 		
		$block = $this->getLayout()->createBlock(
		'Mage_Core_Block_Template',
		'my_block_name_here',
		array('template' => 'sheepla/shipments.phtml')
	);
 
		$this->getLayout()->getBlock('content')->append($block);
	
		   	// "Output" display
		$this->renderLayout();
		
	}
	
	
}