<?php

class Ei_Creditpoint_Block_Adminhtml_Customer_Edit_Tab_Creditpointhistory extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected $customer_id;

    public function __construct()
    {

        $this->setTemplate('ei/creditpoint/creditpointhistory.phtml');
    }

    public function getCreditPoint()
    {
        $customer = Mage::registry('current_customer');
        $this->customer_id = $customer->getId();

        $collection = Mage::getModel('creditpoint/creditpoint')
                            ->getCollection()
                            ->addFieldToSelect('*')
                            ->addFieldToFilter('customer_id',$this->customer_id)
                            ->setOrder('id','DESC');

        return $collection;

     }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Customer Credit Points History');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Credit Points History');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        $customer = Mage::registry('current_customer');
        return (bool)$customer->getId();
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

     /**
     * Defines after which tab, this tab should be rendered
     *
     * @return string
     */
    public function getAfter()
    {
        return 'account';
    }


}
?>