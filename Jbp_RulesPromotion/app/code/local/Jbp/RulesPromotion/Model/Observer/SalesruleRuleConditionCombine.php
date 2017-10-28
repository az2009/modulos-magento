<?php
class Jbp_RulesPromotion_Model_Observer_SalesruleRuleConditionCombine
{
    public function addConditionToSalesRule($observer)
    {
        $additional = $observer->getAdditional();
        $conditions = (array) $additional->getConditions();

        $conditions = array_merge_recursive($conditions, array(
            array(
                'label' => Mage::helper('core')->__('Contém no Carrinho'),
                'value' => 'jbp_rulespromotion/condition_incart'
            ),
        ));

        $additional->setConditions($conditions);

        $observer->setAdditional($additional);

        return $observer;
    }
}