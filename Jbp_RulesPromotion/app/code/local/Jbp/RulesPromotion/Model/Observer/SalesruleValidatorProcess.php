<?php
class Jbp_RulesPromotion_Model_Observer_SalesruleValidatorProcess
{
    public function addActionToProcess($observer)
    {
        $rule = $observer->getEvent()->getRule();
        $result = $observer->getEvent()->getResult();
        $quote = $observer->getEvent()->getQuote();
        $qty = $observer->getEvent()->getQty();
        $item = $observer->getEvent()->getItem();
        $itemPrice = $this->_getItemPrice($item);
        $baseItemPrice = $this->_getItemBasePrice($item);

        switch ($rule->getSimpleAction()) {
            case Jbp_RulesPromotion_Helper_Data::BUY_X_PAY_Y_ACTION:

                $quoteAmount = $quote->getStore()->convertPrice($rule->getDiscountAmount());
                $discountAmount = ($itemPrice - ($quoteAmount / $quote->getItemsQty())) * $qty;
                $discountAmountByItem = ($itemPrice - ($quoteAmount / $quote->getItemsQty()));
                $baseDiscountAmount = ($baseItemPrice - ($quoteAmount / $quote->getItemsQty())) * $qty;
                $item->setCustomPrice($itemPrice - $discountAmountByItem);
                $item->setCustomOriginalPrice($itemPrice - $discountAmountByItem);
                $result->setDiscountAmount($discountAmount);
                $result->setBaseDiscountAmount($baseDiscountAmount);

            break;
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