<?php

class Ei_Creditpoint_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getModuleStatus() {

        $status = Mage::getStoreConfig('creditpoint/general/active');
        return $status;
    }

    public function getCode() {

        return 'creditpoint';
    }

    public function getCurrentCustomerId() {

        $currentCustomerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        return $currentCustomerId;
    }

    public function getCustomerCreditPointsAssigned() {

        $customerCreditPoints = round(Mage::getSingleton('customer/session')->getCustomer()->getCreditPoint());
        return $customerCreditPoints;
    }

    public function getCreditPointLabel($points) {

        return Mage::helper('creditpoint')->__('Credit Points Discount ('.$points.' Points)');
    }

    public function getTotalItemsInCart() {

        return Mage::helper('checkout/cart')->getItemsCount();
    }

    //get current currency symbol
    public function getCurrentCurrencySymbol() {

        $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
        return $currencySymbol;
    }

    //this will give points/currency ratio defined in admin
    public function getPointCurrencyRatio() {

        $ratio = Mage::getStoreConfig('creditpoint/general/points_currency');
        $currency = Mage::helper('creditpoint')->getCurrentCurrencySymbol();
        $formatRatio = explode('/', $ratio);
        $finalRatio = $formatRatio[0] . ' points = ' . $currency . number_format($formatRatio[1], 2, '.', '');
        return $finalRatio;
    }

    //this will give currency as per the customer's available credit points
    public function getPointCurrencyAmount($creditpoints) {

        $ratio = Mage::getStoreConfig('creditpoint/general/points_currency');
        $formatRatio = explode('/', $ratio);
        $finalExchangeValue = $formatRatio[1] / $formatRatio[0];
        $finalAmount = round($finalExchangeValue * $creditpoints);
        return $finalAmount;
    }

    //this will give points earned on currency spent by customer
    public function getEarnedPointsRatio() {

        $ratio = Mage::getStoreConfig('creditpoint/general/points_earn');
        $currency = Mage::helper('creditpoint')->getCurrentCurrencySymbol();
        $formatRatio = explode('/', $ratio);
        $finalEarnedPointsRatio = 'You Earn ' . $formatRatio[1] . ' points for every ' . $currency . $formatRatio[0] . ' spent';
        return $finalEarnedPointsRatio;
    }

    //this will give points as per the amount spent by customer per order
    public function getCreditPointsAwarded($grandtotal) {

        $ratio = Mage::getStoreConfig('creditpoint/general/points_earn');
        $formatRatio = explode('/', $ratio);
        $finalExchangeValue = $formatRatio[1] / $formatRatio[0];
        $creditPointsAwarded = round($finalExchangeValue * $grandtotal);
        return $creditPointsAwarded;
    }

    public function getMinimumCredit() {

        $minCredit = Mage::getStoreConfig('creditpoint/general/minimum_credit_required');
        return $minCredit;
    }

    public function getMaximumCredit() {

        $maxCredit = Mage::getStoreConfig('creditpoint/general/maximum_credit_allowed');
        return $maxCredit;
    }

    //This will convert the points into available currency
    public function getPrice($creditPoints) {

        $currentPointAmount = number_format(Mage::helper('creditpoint')->getPointCurrencyAmount($creditPoints), 2, '.', '');
        return $currentPointAmount;
    }


    public function getRestoreConfig(){

        $restoreCredit = Mage::getStoreConfig('creditpoint/general/restore_redeemed_credits');
        return $restoreCredit;
    }

    public function getOrderStatus() {

        $orderStatus = Mage::getStoreConfig('creditpoint/general/order_status');
        return $orderStatus;
    }

    public function getFormatCreditPoint($point) {

        $creditPoint = round($point, 2);
        return $creditPoint;
    }

    public function getCurrencyMinimumVal($val){
        $val = Mage::helper('creditpoint')->getCurrentCurrencySymbol().number_format($val, 2, '.', '');
        return $val;
    }

    public function getOrderUrl($orderId) {

        return Mage::getUrl('sales/order/view', array('order_id' => $orderId));
    }

    public function getOrderUrlAdmin($orderId){
        return Mage::getUrl('adminhtml/sales_order/view/', array('order_id' => $orderId));
    }

    public function getControllerCredit($orderId){
        return Mage::getUrl('creditpoint/adminhtml_manage/cancelledcredit');
    }

    public function getOrderMinimum(){
        $restoreCredit = Mage::getStoreConfig('creditpoint/general/minimum_subtotal');
        if(!empty($restoreCredit)){
            $restoreCredit += 1;
        }
        return (int)$restoreCredit;
    }

    public function getIdOrderFront($id){
        $order = Mage::getModel('sales/order')->load($id);
        return $order->getIncrementId();
    }

}
