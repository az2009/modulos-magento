<?php
    class Ei_Creditpoint_Adminhtml_ManageController extends Mage_Adminhtml_Controller_Action {


        protected function _initAction()
        {
            // load layout, set active menu and breadcrumbs
            $this->_title($this->__('Reward Points'));

            $this->loadLayout()
                 ->_setActiveMenu('creditpoint/creditpoint')
                 ->_addBreadcrumb(Mage::helper('adminhtml')->__('Reward Points')
                , Mage::helper('adminhtml')->__('Reward Points'));
                return $this;
        }


        public function indexAction()
        {
            $this->_initAction();
            $this->renderLayout();
        }



        public function exportCsvAction()
        {
            $fileName   = 'creditpoint.csv';
            $content    = $this->getLayout()->createBlock('creditpoint/adminhtml_manage_grid')
            ->getCsv();

            $this->_sendUploadResponse($fileName, $content);
        }

        public function exportXmlAction()
        {
            $fileName   = 'creditpoint.csv';
            $content    = $this->getLayout()->createBlock('creditpoint/adminhtml_manage_grid')
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

        public function cancelledCreditAction(){

            $earned_credit_point = floor(filter_var($this->getRequest()->getPost('earned_credit_point'), FILTER_SANITIZE_NUMBER_INT));
            $customer_id         = filter_var($this->getRequest()->getPost('customer_id'), FILTER_SANITIZE_NUMBER_INT);
            $info_comments       = strip_tags($this->getRequest()->getPost('info_comments'));
            $action              = strip_tags($this->getRequest()->getPost('actionOperator'));

            if(!empty($earned_credit_point) && !empty($customer_id) && !empty($info_comments)){

                $args= array(
                    'earned_credit_point' => $earned_credit_point,
                    'customer_id'         => $customer_id,
                    'info_comments'       => $info_comments
                );

                if($action == 'remove'){
                    $customerCreditPoints = Mage::getSingleton('customer/customer')->load($customer_id)->getCreditPoint();

                    if($earned_credit_point > $customerCreditPoints){

                        Mage::getSingleton('adminhtml/session')->addError('Informe um valor igual ou  abaixo de '.(int)$customerCreditPoints);
                        return false;
                    }
                }

                if($action == 'remove'){
                    $model = Mage::getModel('creditpoint/creditpoint')->cancelledItem($args);

                }elseif($action == 'add'){
                    $model = Mage::getModel('creditpoint/creditpoint')->addCreditItem($args);

                }

                if($model){
                    Mage::getSingleton('adminhtml/session')->addSuccess('Evento aplicado com sucesso');

                }else{

                    Mage::getSingleton('adminhtml/session')->addError('Falha ao aplicar o evento');
                }

            }else{
                Mage::getSingleton('adminhtml/session')->addError('Informe um valor valido > 0 e o motivo pelo evento');
            }

        }


        public function testeAction(){}

    }

?>