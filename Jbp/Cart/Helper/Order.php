<?php
class Jbp_Cart_Helper_Order extends Mage_Core_Helper_Abstract
{
    
    public function setBillingAddress(){
        $billingAddress = $this->_getQuoteOrig()->getBillingAddress();
        $billingAddressData = array(
            'firstname' => $billingAddress->getData('firstname'),
            'lastname' => $billingAddress->getData('lastname'),
            'street' => $billingAddress->getData('street'),
            'city' => $billingAddress->getData('city'),
            'postcode' => $billingAddress->getData('postcode'),
            'telephone' => $billingAddress->getData('telephone'),
            'country_id' => $billingAddress->getData('country_id'),
            'region_id' => $billingAddress->getData('region_id'),
        );
        return $billingAddressData;
    }
    
    public function setShippingAddress(){
        $shippingAddress = $this->_getQuoteOrig()->getShippingAddress();
        $shippingAddressData = array(
            'firstname' => $shippingAddress->getData('firstname'),
            'lastname' => $shippingAddress->getData('lastname'),
            'street' => $shippingAddress->getData('street'),
            'city' => $shippingAddress->getData('city'),
            'postcode' => $shippingAddress->getData('postcode'),
            'telephone' => $shippingAddress->getData('telephone'),
            'country_id' => $shippingAddress->getData('country_id'),
            'region_id' => $shippingAddress->getData('region_id'),
        );        
        return $shippingAddressData;
    }
    
    /**
     * retorna o quote checkout/session
     * @return Mage_Checkout_Model_Session
     */
    protected function _getQuoteOrig(){
        return Mage::getSingleton('checkout/session')->getQuote();
    }
    
}
