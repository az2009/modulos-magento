<?php 

class Ei_Creditpoint_Block_Adminhtml_Customer_Edit_Tab_Creditpoint extends Mage_Adminhtml_Block_Template implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function __construct()
    {
       
        $this->setTemplate('ei/creditpoint/creditpoint.phtml');
    }

    public function getCreditPoint()
    {
        $customer = Mage::registry('current_customer');
        $creditPoint = Mage::helper('creditpoint')->getFormatCreditPoint($customer->getCreditPoint());
        return $creditPoint;
     }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Customer Credit Points');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Credit Points');
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