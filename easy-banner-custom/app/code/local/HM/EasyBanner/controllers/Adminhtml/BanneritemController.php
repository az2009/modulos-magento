<?php

class HM_EasyBanner_Adminhtml_BanneritemController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('easybanner/banneritems')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Banner Item Manager'), Mage::helper('adminhtml')->__('Banner Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('easybanner/banneritem')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('easybanneritem_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('easybanner/banneritems');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Banner Item Manager'), Mage::helper('adminhtml')->__('Banner Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Banner Item News'), Mage::helper('adminhtml')->__('Banner Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('easybanner/adminhtml_banneritem_edit'))
				->_addLeft($this->getLayout()->createBlock('easybanner/adminhtml_banneritem_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('easybanner')->__('Banner Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$data= $this->_filterPostData($data);
			if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('image');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'easybanner' . DS;
					$result = $uploader->save($path, $_FILES['image']['name'] );
					
					//this way the name is saved in DB
					$data['image'] = 'easybanner/'. $result['file'];
				} catch (Exception $e) {
		      
		        }	        
			} else {
				if(isset($data['image']['delete']) && $data['image']['delete'] == 1) {
					 $data['image'] = '';
				} else {
					unset($data['image']);
				}
			}
			
			if(isset($data['banner_order'])){ $data['banner_order']= intval($data['banner_order']); }

			if(isset($_FILES['thumb_image']['name']) && $_FILES['thumb_image']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('thumb_image');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'easybanner' . DS;
					$result = $uploader->save($path, $_FILES['thumb_image']['name'] );
					
					//this way the name is saved in DB
					$data['thumb_image'] = 'easybanner/'. $result['file'];
				} catch (Exception $e) {
		      
		        }
	        
			} else {
				if(isset($data['thumb_image']['delete']) && $data['thumb_image']['delete'] == 1) {
					 $data['thumb_image'] = '';
				} else {
					unset($data['thumb_image']);
				}
			}
	  			
	  			
			//$model = Mage::getModel('easybanner/banneritem');		
			//$model->setData($data)
			//	->setId($this->getRequest()->getParam('id'));
			$model = Mage::getModel('easybanner/banneritem');
			$model->setData($data);
			if($this->getRequest()->getParam('id')){
				$model->setId($this->getRequest()->getParam('id'));
			}
			//exit;
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('easybanner')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('easybanner')->__('Unable to find banner item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('easybanner/banneritem');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $easybannerIds = $this->getRequest()->getParam('easybanneritem');
        if(!is_array($easybannerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select banner item(s)'));
        } else {
            try {
                foreach ($easybannerIds as $easybannerId) {
                    $easybanner = Mage::getModel('easybanner/banneritem')->load($easybannerId);
                    $easybanner->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($easybannerIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $easybannerIds = $this->getRequest()->getParam('easybanneritem');
        if(!is_array($easybannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select banner item(s)'));
        } else {
            try {
                foreach ($easybannerIds as $easybannerId) {
                    $easybanner = Mage::getSingleton('easybanner/banneritem')
                        ->load($easybannerId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($easybannerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function setOrderAction() {
        $params = $this->getRequest()->getParam('items');
        //var_dump($params);exit;
        if(!$params) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
            	$params = explode('|',$params);
                foreach ($params as $param) {
					$param = explode('-',$param);
					if(sizeof($param)>1){
						$model = Mage::getModel('easybanner/banneritem');
						$model->setData(array('banner_order'=>$param[1]))->setId($param[0]);
						$model->save();
					}
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($params)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }   
    
    public function exportCsvAction()
    {
        $fileName   = 'easybanner.csv';
        $content    = $this->getLayout()->createBlock('easybanner/adminhtml_banneritem_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'easybanner.xml';
        $content    = $this->getLayout()->createBlock('easybanner/adminhtml_banneritem_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
		protected function _filterPostData($data)
    {
		//var_dump($data);die;
		$data = $this->_filterDateTime($data, array('item_active_from'));
		$data =	$this->_filterDateTime($data, array('item_active_to'));	
        return $data;
    } 

}