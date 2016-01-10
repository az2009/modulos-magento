<?php
class HM_EasyBanner_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/easybanner?id=15 
    	 *  or
    	 * http://site.com/easybanner/id/15 	
    	 */
    	/* 
		$easybanner_id = $this->getRequest()->getParam('id');

  		if($easybanner_id != null && $easybanner_id != '')	{
			$easybanner = Mage::getModel('easybanner/easybanner')->load($easybanner_id)->getData();
		} else {
			$easybanner = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($easybanner == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$easybannerTable = $resource->getTableName('easybanner');
			
			$select = $read->select()
			   ->from($easybannerTable,array('easybanner_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$easybanner = $read->fetchRow($select);
		}
		Mage::register('easybanner', $easybanner);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}