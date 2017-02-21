<?php
class Jbp_Ouibounce_IndexController extends Mage_Core_Controller_Front_Action{

    public function registerAction(){

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $result = Mage::getModel('jbp_ouibounce/ouibounce')->registerData($data);
            
        }

        var_dump($result);
        
        $this->getResponse()
             ->clearHeaders()
             ->clearBody();

        $this->getResponse()
             ->setHeader("Content-Type", "text/html; charset=UTF-8");

        if($result){
            $this->getResponse()->setHttpResponseCode(200);

            echo json_encode(array('register'=>'ok'));

        }else{
            $this->getResponse()->setHttpResponseCode(400);
        }

    }

}