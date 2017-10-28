<?php
class Jbp_RulesPromotion_Model_Observer_SalesruleValidatorProcess
{
    public function addActionToProcess($observer)
    {
        $validate = Mage::registry('products_condition_in_cart');
        $rule = $observer->getEvent()->getRule();
        $result = $observer->getEvent()->getResult();
        /** @var Mage_Sales_Model_Quote $quote*/
        $quote = $observer->getEvent()->getQuote();
        $qty = $observer->getEvent()->getQty();
        /**@var Mage_Sales_Model_Quote_Item $item*/
        $item = $observer->getEvent()->getItem();
        $itemPrice = $this->_getItemPrice($item);
        $baseItemPrice = $this->_getItemBasePrice($item);
        $op = $validate->getOperator();

        if ($validate->getValidate() === true
            && in_array($item->getSku(), $validate->getSkus())) {
                switch ($rule->getSimpleAction()) {
                    case Jbp_RulesPromotion_Helper_Data::BUY_X_PAY_Y_ACTION:
                        $quoteAmount = $quote->getStore()->convertPrice($rule->getDiscountAmount());
                        $discountAmount = ($itemPrice - ($quoteAmount / $validate->getQuoteQty())) * $qty;
                        $discountAmountByItem = ($itemPrice - ($quoteAmount / $validate->getQuoteQty()));
                        $baseDiscountAmount = ($baseItemPrice - ($quoteAmount / $validate->getQuoteQty())) * $qty;
                        $newPrice = $itemPrice - $discountAmountByItem;
                        if ($itemPrice <= $newPrice) {
                            continue;
                        }
                        $item->setCustomPrice($newPrice);
                        $item->setCustomOriginalPrice($newPrice);
                        //                    $item->calcRowTotal();
                        //                    $item->calcTaxAmount();
                        $result->setDiscountAmount($discountAmount);
                        $result->setBaseDiscountAmount($baseDiscountAmount);
                    break;
                }
        }

        return $this;
    }


    /**
     * Return item price
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    protected function _getItemPrice($item)
    {
        $price = $item->getDiscountCalculationPrice();
        $calcPrice = $item->getCalculationPrice();
        return ($price !== null) ? $price : $calcPrice;
    }

    /**
     * Return item base price
     * @param Mage_Sales_Model_Quote_Item_Abstract $item
     * @return float
     */
    protected function _getItemBasePrice($item)
    {
        $price = $item->getDiscountCalculationPrice();
        return ($price !== null) ? $item->getBaseDiscountCalculationPrice() : $item->getBaseCalculationPrice();
    }
}