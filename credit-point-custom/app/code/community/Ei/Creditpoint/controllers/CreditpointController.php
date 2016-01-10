<?php

class Ei_Creditpoint_CreditpointController extends Mage_Core_Controller_Front_Action {

    public function _construct(){
        $moduleStatus = Mage::helper('creditpoint')->getModuleStatus();
        if($moduleStatus != 1){
            die();
        }

    }

    protected function _getSession() {
        return Mage::getSingleton('customer/session');
    }

    public function preDispatch() {

        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();
        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }

    public function indexAction() {

        $this->loadLayout();
        $this->renderLayout();
    }


    public function calcCreditAllowed(){
        $subTotal           = Mage::helper('checkout/cart')->getQuote()->getSubtotal();
        $grandTotal         = Mage::helper('checkout/cart')->getQuote()->getGrandTotal();
        $subTotalConfigMin  = Mage::helper('creditpoint')->getOrderMinimum();
        $creditPointCode    = Mage::helper('creditpoint')->getCode();
        $EstimateCredit     = Mage::getSingleton('core/session')->getEstimateCredit();
        $pointsRedeem       = Mage::getSingleton('core/session')->getPointsRedeem();
        $formAction         = Mage::getBaseUrl() . 'creditpoint/creditpoint/estimateCreditPoint/';
        $creditPoints       = Mage::helper('creditpoint')->getCustomerCreditPointsAssigned();
        $finalRatio         = Mage::helper('creditpoint')->getPointCurrencyRatio();
        $maxCreditConfig    = Mage::helper('creditpoint')->getMaximumCredit();
        $minCreditConfig    = Mage::helper('creditpoint')->getMinimumCredit();

        $currentPointAmount = number_format(Mage::helper('creditpoint')->getPointCurrencyAmount($creditPoints), 2, '.', '');
        $ratio              = Mage::getStoreConfig('creditpoint/general/points_currency');
        $formatRatio        = explode('/', $ratio);

        $pointsRatio        = $formatRatio[0] / $formatRatio[1];
        $subtotalCredit     = floor($pointsRatio * (int) $subTotal);

        //
        if (($maxCreditConfig == 0 || $maxCreditConfig == NULL) && ($currentPointAmount >= $subTotal)) {

            $maxCredit = (int) $subtotalCredit;

        } elseif (($maxCreditConfig == 0 || $maxCreditConfig == NULL) && ($currentPointAmount <= $subTotal)) {

            $maxCredit = $creditPoints;

            // } elseif (($maxCreditConfig >= $currentPointAmount)) {
        } elseif (($maxCreditConfig >= $creditPoints)) {

            $maxCredit = $creditPoints;

            // } elseif (($maxCreditConfig <= $currentPointAmount)) {
        } elseif (($maxCreditConfig <= $creditPoints)) {

            $maxCredit = $maxCreditConfig;
        } else {
            $maxCredit = $maxCreditConfig;
        }

        // Caso a quantidade máxima de pontos seja maior que o subtotal em pontos
        if ($maxCredit > $subtotalCredit) {
            $maxCredit = (int) $subtotalCredit;
        }

        // Subtrai o subtotal com a quantidade de ponto em preço
        $preSub = $subTotal - ($maxCredit / $pointsRatio);

        // Verifica se o subtotal resultante e menor que o subtotal minimo determinado no admin
        // Se sim transforma o subtotal minimo configurado para pontos aplica o mesmo como máximo de pontos que o usuário podera aplicar
        if ($preSub < $subTotalConfigMin) {
            $maxCredit = floor($pointsRatio * ($subTotal - $subTotalConfigMin));
        }

        return $maxCredit;
    }


    public function valid($pointsRedeem){

        //Pega as config de pontos máximas
            $maxCreditConfig = Mage::helper('creditpoint')->getMaximumCredit();

        //Pega as config de pontos minimas
            $minCreditConfig = Mage::helper('creditpoint')->getMinimumCredit();

        //Verifica se o use esta logao
        if($this->_getSession()->isLoggedIn()){


            //Verifica se a quantidade de créditos que o user tem é maior do que a qual esta sendo aplicada
            //Válida o desconto aplicado via back-end
            if(
                    $this->_getSession()->getCustomer()->getData('credit_point') >= $pointsRedeem
                &&
                    $pointsRedeem <= $this->calcCreditAllowed()
              )
            {
                return true;
            }
            else
            {
                Mage::log($this->error = $this->__('Points invalid'));
            }

        }else{
            Mage::log($this->error = $this->__('Client not loged in'));
        }

        return false;

    }

    public function estimateCreditPointAction() {

        $quote = Mage::getSingleton('checkout/session')->getQuote();

        $code = (string)filter_var($this->getRequest()->getPost('estimate_credit'),FILTER_SANITIZE_STRING);

        $pointsRedeem = (int)filter_var(Mage::app()->getRequest()->getPost('pointsredeem'), FILTER_SANITIZE_NUMBER_INT);

        $pointsAmount = Mage::helper('creditpoint')->getPrice($pointsRedeem);

        if($this->valid($pointsRedeem)){
                //if estimate_credit code set and redeemed points greater than 0
                if ( (!empty($pointsRedeem)) && $code == 'creditpoint') {

                    Mage::getSingleton('core/session')->setEstimateCredit($code);
                    Mage::getSingleton('core/session')->setPointsRedeem($pointsRedeem);
                    Mage::getSingleton('core/session')->setPointsPrice($pointsAmount);

                    //call collectTotals on quote with the totals collected flag set to false.
                    //$quote->collectTotals() one the first line checks for the totals_collected_flag,
                    //if it is set to true it returns without doing anything but we want to update it after applying discount so its set to false.
                    //Look at the definition : Mage_Sales_Model_Quote::collectTotals()
                    $quote->setTotalsCollectedFlag(false);
                    $quote->collectTotals();

                }else{
                    Mage::getSingleton('core/session')->unsEstimateCredit();
                    Mage::getSingleton('core/session')->unsPointsRedeem();
                    Mage::getSingleton('core/session')->unsPointsPrice();
                    $quote->setTotalsCollectedFlag(false);
                    $quote->collectTotals();
                }

                if(Mage::helper('checkout/cart')->getQuote()->getGrandTotal() < 0){
                    Mage::getSingleton('core/session')->unsEstimateCredit();
                    Mage::getSingleton('core/session')->unsPointsRedeem();
                    Mage::getSingleton('core/session')->unsPointsPrice();
                    $quote->setTotalsCollectedFlag(false);
                    $quote->collectTotals();
                }

                $response = array();

                //here 'creditpointblock' will be key and cart block html as value for that key
                $response['creditpointblock'] = $this->creditpointAjax();
                $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
                return $this->getResponse()->setBody(json_encode($response));

        }else{

            $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
            return $this->getResponse()->setBody(json_encode(array('error'=>'fail')));

        }

    }

    protected function creditpointAjax()
    {
        $layout = $this->getLayout();
        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
        $totalsBlock = $layout->createBlock('checkout/cart_totals')->setTemplate('checkout/cart/totals.phtml');
        return $totalsBlock->toHtml();
    }

    public function testeAction(){}












}