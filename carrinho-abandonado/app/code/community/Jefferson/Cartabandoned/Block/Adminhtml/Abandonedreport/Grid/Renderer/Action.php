<?php 
    class Jefferson_Cartabandoned_Block_Adminhtml_Abandonedreport_Grid_Renderer_Action 
        extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action {
        
        
        
        public function render(Varien_Object $row){
            $url = $this->getUrl('*/adminhtml_abandonedreport/preview',array('id'=>$row->getData('id_fila_envio')));
            $actions[] = array(
                // 'url'       =>  $this->getUrl('*/adminhtml_abandonedreport/preview',array('id'=>$row->getData('id_fila_envio'))),
                'caption'   =>  Mage::helper('cartabandoned')->__('Preview'),
                'onclick'   => 
"window.open('".$url."','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=800,menubar=no,directories=no');  return false;",   
                // 'popup'     =>  true
            );
            
            $this->getColumn()->setActions($actions);
            return parent::render($row);
            
            
        }
        
        
        
        
        
        
    }
