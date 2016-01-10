<?php

class Ei_Creditpoint_Model_Observer {

    //this function is used to deduct credit points from customer's account after order is placed
    public function deductCreditAmount(Varien_Event_Observer $observer) {


        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        $customerId = $order->getCustomerId();
        $datetime = $order->getCreatedAt();

        $pointsRedeem = Mage::getSingleton('core/session')->getData('points_redeem');
        $pointsPrice = Mage::getSingleton('core/session')->getData('points_price');
        $customerCreditPoints = Mage::getSingleton('customer/session')->getCustomer()->getCreditPoint();

        if ($pointsRedeem && $pointsPrice != NULL) {

            //init our model, set data and save
            //deduct redeemed credit points from customer account and revise
            try {

                $revisedCreditPoints = $customerCreditPoints - $pointsRedeem;
                $creditModel = Mage::getSingleton('creditpoint/creditpoint')
                        ->setCustomerId($customerId)
                        ->setOrderId($orderId)
                        ->setAppliedCreditPoint($pointsRedeem)
                        ->setAppliedCreditPointPrice($pointsPrice)
                        ->setCreatedTime($datetime)
                        ->save();

                $customerData = Mage::getSingleton('customer/customer')->load($customerId)->setCreditPoint($revisedCreditPoints)->save();

                //unset credit points data
                Mage::getSingleton('core/session')->unsEstimateCredit();
                Mage::getSingleton('core/session')->unsPointsRedeem();
                Mage::getSingleton('core/session')->unsPointsPrice();
            } catch (Exception $e) {
                Mage::getModel('core/session')->addError($e->getMessage());
            }
        }
    }

    //this function is used to add credit points to customer's account balance.
    //grandtotal is used to calculate the amount of points to be deposited
    public function revertCreditPoints($observer) {

        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();
        $orderStatus = Mage::helper('creditpoint')->getOrderStatus();
        $moduleStatus = Mage::helper('creditpoint')->getModuleStatus();
        $restoreConfig = Mage::helper('creditpoint')->getRestoreConfig();

        $grandTotal = round($order->getGrandTotal());
        $customerEarnedPoints = Mage::helper('creditpoint')->getCreditPointsAwarded($grandTotal);
        $customerCurrentPoints = Mage::getSingleton('customer/customer')->load($order->getCustomerId())->getCreditPoint();
        $customerAppliedPoints = Mage::getSingleton('creditpoint/creditpoint')->load($order->getEntityId(), 'order_id')->getAppliedCreditPoint();


        //check if order status matches configuration order status, order is not closed, can restore points, order is closed and module is active
        if (($order->getState() == $orderStatus && $moduleStatus == 1 && $restoreConfig == 1 && $order->getState() == Mage_Sales_Model_Order::STATE_CLOSED) || ($restoreConfig == 1 && $order->getState() == Mage_Sales_Model_Order::STATE_CLOSED)) {

            try {

                $restoredPoints = ($customerCurrentPoints - $customerEarnedPoints) + $customerAppliedPoints;

                $creditModel = Mage::getSingleton('creditpoint/creditpoint')
                        ->load($order->getId(), 'order_id')
                        ->setOrderRefund($restoreConfig)
                        ->save();

                //set restored customer's points
                $customerData = Mage::getSingleton('customer/customer')->load($order->getCustomerId())
                        ->setCreditPoint($restoredPoints)
                        ->save();
            } catch (Exception $e) {
                Mage::getModel('core/session')->addError($e->getMessage());
            }


            //check if order status matches configuration order status, order is not closed and module is active
        } elseif ($order->getState() == $orderStatus && $moduleStatus == 1) {

            try {

                //check if the order is placed first time OR no credit points applied on this order
                if ($customerAppliedPoints == NULL) {

                    //add earned points to current balance only     
                    $revisedCreditPoints = $customerCurrentPoints + $customerEarnedPoints;

                    $creditModel = Mage::getSingleton('creditpoint/creditpoint')
                            ->load($order->getId(), 'order_id')
                            ->setCustomerId($order->getCustomerId())
                            ->setOrderId($order->getEntityId())
                            ->setEarnedCreditPoint($customerEarnedPoints)
                            ->setCreatedTime($order->getCreatedAt())
                            ->save();

                    //set customer's credit points
                    $customerData = Mage::getSingleton('customer/customer')->load($order->getCustomerId())
                            ->setCreditPoint($revisedCreditPoints)
                            ->save();


                    //check if creditpoints applied on order
                } else {

                    //add earned points to current balance only     
                    $revisedCreditPoints = $customerCurrentPoints + $customerEarnedPoints;

                    $creditModel = Mage::getSingleton('creditpoint/creditpoint')
                            ->load($order->getId(), 'order_id')
                            ->setEarnedCreditPoint($customerEarnedPoints)
                            ->save();

                    //set customer's credit points
                    $customerData = Mage::getSingleton('customer/customer')->load($order->getCustomerId())
                            ->setCreditPoint($revisedCreditPoints)
                            ->save();
                }
            } catch (Exception $e) {
                Mage::getModel('core/session')->addError($e->getMessage());
            }
        }
    }

    //this function will display creditpoint amount value when invoice is created
    public function invoiceSaveAfter(Varien_Event_Observer $observer) {

        $invoice = $observer->getEvent()->getInvoice();
        if ($invoice->getBaseCreditpointAmount()) {
            $order = $invoice->getOrder();
            $order->setCreditpointAmountInvoiced($order->getCreditpointAmountInvoiced() + $invoice->getCreditpointAmount());
            $order->setBaseCreditpointAmountInvoiced($order->getBaseCreditpointAmountInvoiced() + $invoice->getBaseCreditpointAmount());
        }
        return $this;
    }

    public function updatePaypalTotal($evt) {

        $cart = $evt->getPaypalCart();
        $cart->updateTotal(Mage_Paypal_Model_Cart::TOTAL_SUBTOTAL, $cart->getSalesEntity()->getCreditpointAmount());
    }

}
