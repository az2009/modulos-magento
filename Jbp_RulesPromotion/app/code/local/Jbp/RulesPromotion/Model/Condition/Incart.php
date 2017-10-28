<?php
class Jbp_RulesPromotion_Model_Condition_Incart
    extends Mage_Rule_Model_Condition_Product_Abstract {

    /**
     * Add special attributes
     *
     * @param array $attributes
     */
    protected function _addSpecialAttributes(array &$attributes)
    {
        $attributes['attribute_set_id'] = Mage::helper('catalogrule')->__('Se Carrinho');
    }

    /**
     * Load attribute options
     *
     * @return Mage_CatalogRule_Model_Rule_Condition_Product
     */
    public function loadAttributeOptions()
    {
        $attributes = array('sku' => 'O Carrinho');
        $this->_addSpecialAttributes($attributes);
        asort($attributes);
        $this->setAttributeOption($attributes);

        return $this;
    }

    /**
     * Default operator input by type map getter
     * @return array
     */
    public function getDefaultOperatorInputByType()
    {
        if (null === $this->_defaultOperatorInputByType) {
            $this->_defaultOperatorInputByType = array(
                'string'      => array('{}', '!{}'),
                'numeric'     => array('==', '!=', '>=', '>', '<=', '<', '()', '!()'),
                'date'        => array('==', '>=', '<='),
                'datetime'    => array('==', '>=', '<='),
                'select'      => array('==', '!='),
                'boolean'     => array('==', '!='),
                'multiselect' => array('[]', '![]', '()', '!()'),
                'grid'        => array('()', '!()'),
            );
            $this->_arrayInputTypes = array('multiselect', 'grid');
        }
        return $this->_defaultOperatorInputByType;
    }

    /**
     * Validate Rule Condition
     *
     * @param Varien_Object $object
     *
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        $op = $this->getOperatorForValidate();
        $quote = $object->getQuote();
        $attrCode = $this->getAttribute();
        $value = $this->prepareValue();
        if (!isset($match)) {
            $match = array();
        }

        $qty = 0;

        foreach ($object->getAllVisibleItems() as $item) {
            $prod = $item->getSku();
            switch ($op) {
                case '{}':
                    if (in_array($item->getProduct()->getSku(), $value)) {
                        $match[] = $item->getProduct()->getSku();
                        $qty += $item->getQty();
                    }
                break;
                case '!{}':
                    if (in_array($item->getProduct()->getSku(), $value)) {
                        $match[] = $item->getProduct()->getSku();
                    }
                break;
            }
        }

        if ($op == '{}') {
            $validate = $match == $value;
            $result = new Varien_Object(array(
                'validate' => $validate,
                'skus' => $match,
                'quote_qty' => $qty,
                'operator' => $op
            ));

            Mage::unregister('products_condition_in_cart');
            Mage::register('products_condition_in_cart', $result);
        } elseif ($op == '!{}') {
            $validate = $match != $value;
        }

        return $validate;
    }

    /**
     * prepare array
     * @param $value
     * @return array|bool
     */
    public function prepareValue()
    {
        $value = array();

        if ($this->getValue()) {
            $value = $this->getValue();
        }

        if (!empty($value)) {
            $value = explode(',', $value);
            if (is_array($value)) {
                $value = array_map('trim', $value);
            }

            if (!Mage::registry('values_promotion_rules')) {
                Mage::register('values_promotion_rules', $value);
            } else {
                $oldValue = Mage::registry('values_promotion_rules');
                $value = array_merge_recursive($oldValue, $value);
                Mage::unregister('values_promotion_rules');
                Mage::register('values_promotion_rules', $value);
            }
        }

        return $value;
    }


}