<?php

    class Jefferson_Cartabandoned_Adminhtml_AbandonedreportController  extends Mage_Adminhtml_Controller_action {

        /**
         *  Carrega o layout
         */

        public function indexAction(){
            $this->_initAction()
                 ->renderLayout();
        }

        /**
         *  Inicia a criação do layout
         */

        protected function _initAction() {
            $this->loadLayout()
            ->_setActiveMenu('report/cartabandoned_reports')
            ->_addBreadcrumb(Mage::helper('cartabandoned')->__('Report abandoned shopping cart shipping'));
            return $this;
        }

        public function previewAction(){

            $data = $this->getRequest()->getParams();

            $data['preview_store_id'] = Mage::app()->getAnyStoreView()->getId();

            echo $this->getLayout()
                  ->createBlock('cartabandoned/adminhtml_abandonedreport')
                  ->setTemplate('jefferson/cartabandoned/cartabandoned_report.phtml')
                  ->setData($data)
                  ->toHtml();


        }

       /*
        *  Para a fila que esta sendo executada
        */

       public  function stopFilaAction(){
           $model = Mage::getSingleton('cartabandoned/filaenvio');

           if($model->stopFila()){

               Mage::helper('cartabandoned')
               ->setMsgRedirect('All the lines were successfully stops','*/*/index','success');

           }else{
               Mage::helper('cartabandoned')
                ->setMsgRedirect('There is no running queues','*/*/index');
           }
       }

    }
















