<?php

    set_time_limit(0);
    ini_set('max_execution_time', 0);
    ini_set ('mysql.connect_timeout ',  0);
    ini_set ('default_socket_timeout',  0);

    class Jefferson_Cartabandoned_DisparoController extends Mage_Core_Controller_Front_Action {

        public function indexAction(){
            $post = array();
            $block = $this->getLayout()
                             ->createBlock('cartabandoned/frontend_disparo')
                             ->setData($post)
                             ->execDisparo();
        }
    }