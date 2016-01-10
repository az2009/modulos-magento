<?php
class Ei_Creditpoint_Model_Sales_Order_Total_Creditmemo_Creditpoint extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
	public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
	{
		$order = $creditmemo->getOrder();
		$creditpointAmountLeft = $order->getCreditpointAmountInvoiced() - $order->getCreditpointAmountRefunded();
		$basecreditpointAmountLeft = $order->getBaseCreditpointAmountInvoiced() - $order->getBaseCreditpointAmountRefunded();
		if ($basecreditpointAmountLeft > 0) {

                        //customer redeemed discount so we are subtracting the value from total
			$creditmemo->setGrandTotal($creditmemo->getGrandTotal() - $creditpointAmountLeft);
			$creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() - $basecreditpointAmountLeft);
			$creditmemo->setCreditpointAmount($creditpointAmountLeft);
			$creditmemo->setBaseCreditpointAmount($basecreditpointAmountLeft);
		}
		return $this;
	}
}
