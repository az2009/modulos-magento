<?php
class Jbp_Ouibounce_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getEmailDestinatario(){
        return Mage::getStoreConfig('ouibounce_config/ouibounce_general/ouibounce_email');
    }

    public function getCupom(){
        return Mage::getStoreConfig('ouibounce_config/ouibounce_general/ouibounce_cupom');
    }

    public function getStatus(){
        return Mage::getStoreConfig('ouibounce_config/ouibounce_general/ouibounce_enabled');
    }

    public function getSubject(){
        return Mage::getStoreConfig('ouibounce_config/ouibounce_general/ouibounce_subject');
    }

    public function getQtyDiscount(){
        return Mage::getStoreConfig('ouibounce_config/ouibounce_general/ouibounce_qty_discount');
    }


    #Envio temporario
//     public function sendTemp($data){
//         $headers = "MIME-Version: 1.0\r\n";
//         $headers .= "Content-type: text/html; charset=utf-8 \r\n";
//         $headers .= "Reply-To: {$data['email_customer']} \r\n";
//         $headers .= "From: {$this->getEmailDestinatario()} \r\n";

//         $body = "E-mail: {$data['email_customer']} <br/>"
//                 ."Mensagem: ".$data['problema'];

//         #temporario
//         mail($this->getEmailDestinatario(), $this->getSubject(), $body, $headers);
//     }

    /**
     * Executa o envio
     * @param unknown $data
     */
    public function sendTemp($data){

        $mail = Mage::getModel('core/email_template')->loadDefault('ouibounce_email_template');

        $data = array(
            'customer_email' => $data['email_customer'],
            'customer_msg' => $data['problema'],
        );

        $processedTemplate = $mail->getProcessedTemplate($data);

        $mail->setSenderName($this->getSubject());

        $mail->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email'));

        $mail->setTemplateSubject($this->getSubject());

        try{
            $mail->send($this->getEmailDestinatario(), $this->getSubject(), $data);
        }catch(Exception $e){
            Mage::log('Não foi possível receber a avaliação do e-mail: '.$this->getEmailDestinatario(). 'Error: '.$e->getMessage());
        }

    }



}