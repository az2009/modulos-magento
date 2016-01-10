<?php
    class Jefferson_Cartabandoned_Block_Adminhtml_Abandonedreport extends Mage_Adminhtml_Block_Widget_Grid_Container
    {
        
      public function __construct(){
        
        //Nome do controller
            $this->_controller = 'adminhtml_abandonedreport';
            
        //Nome do módulo    
            $this->_blockGroup = 'cartabandoned';
        
        //Label do cabeçalho da página    
            $this->_headerText = Mage::helper('cartabandoned')->__('Submissions made');
        
        //Herdando o construtor     
            parent::__construct();
            
            $this->addButton('disparo', array(
                'label'     => Mage::helper('cartabandoned')->__('Shoot'),
                'onclick'   => "setLocation('".$this->getUrl("*/adminhtml_abandoned/")."')",
                'class'     => 'rebuild',
            ));
        
            
        //Adicionando um button para zerar a fila
            $this->addButton('stopFila', array(
                'label'     => Mage::helper('cartabandoned')->__('Stop line'),
                'onclick'   => "setLocation('".$this->getUrl("*/adminhtml_abandonedreport/stopfila")."')",
                'class'     => 'rebuild',
            ));
            
            
            $this->_removeButton('save');
            $this->_removeButton('add');
            $this->_removeButton('reset');
            $this->_removeButton('delete');
      }
      
      public function listItemsEnvio(){
          
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('id_fila_envio_item_envio', $idFila);
            
          if(count($collection->getData()) > 0){
              
              foreach($collection as $data){                  
                  $html .= "<tr>";
                        $html .= "<td>".$data->getData('id_item_envio')."</td>";
                        $html .= "<td>".$data->getData('email_customer')."</td>";
                        $html .= "<td>".$data->getData('data_envio_item_envio')."</td>";
                        $html .= "<td>".$data->getData('click')."</td>";
                        $html .= "<td>".$data->getData('open')."</td>";
                  $html .= "</tr>";
              }   
              
              
          }else{
              $html = "<tr>".Mage::helper('cartabandoned')->__('No information found')."</tr>";
          }
          
          return $html;
          
      }

      public function getCountClick(){
          
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('id_fila_envio_item_envio', $idFila)
                            ->addFieldToFilter('click','Sim');
                            
            
          if(count($collection->getData()) > 0){
               echo count($collection->getData());
          }else{
              echo 0;
          }
          
          
      }
      
      public function getCountNotClick(){
          
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('id_fila_envio_item_envio', $idFila)
                            ->addFieldToFilter('click','Não');
                            
            
          if(count($collection->getData()) > 0){
               echo count($collection->getData());
          }else{
              echo 0;
          }
          
          
      }
      
      public function getCountOpen(){
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('id_fila_envio_item_envio', $idFila)
                            ->addFieldToFilter('open','Sim');
                            
            
          if(count($collection->getData()) > 0){
               echo count($collection->getData());
          }else{
              echo 0;
          }
      }
      
      public function getCountNotOpen(){
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('id_fila_envio_item_envio', $idFila)
                            ->addFieldToFilter('open','Não');
                            
            
          if(count($collection->getData()) > 0){
               echo count($collection->getData());
          }else{
              echo 0;
          }
      }
      
      public function getQtyCartAfter(){
          $collection = Mage::getResourceModel('reports/quote_collection');            
          $collection->prepareForAbandonedReport(Mage::app()->getStore()->getStoreId());
          echo count($collection->getData());    
      }
      
      public function getQtyCartBefore(){
          
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('main_table.id_fila_envio_item_envio', $idFila)
                            ->setPageSize(1);
            
            $collection->getSelect()->join(
                                       'cart_abandonedj_fila_envio', 
                                       'main_table.id_fila_envio_item_envio = cart_abandonedj_fila_envio.id_fila_envio',
                                       array('*'));
                      
            if(count($collection->getData('data_envio_fila_envio'))){
                
                foreach($collection->getData() as $data);
                echo $data['qty_cart'];
                
            }else{
                echo 0;
            }
          
      }
      
      public function getCountEnvio(){
          $idFila     = (int)$this->getData('id');
          
          $collection = Mage::getModel('cartabandoned/itemenvio')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('id_fila_envio_item_envio', $idFila);
                            
                            
            
          if(count($collection->getData()) > 0){
               echo count($collection->getData());
          }else{
              echo 0;
          }
      }
      
    
      
    }

    
    
    
    
    
    
    
    
    
    
    
    