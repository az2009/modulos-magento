<?php
class Ei_Creditpoint_Model_Sales_Order_Total_Invoice_Creditpoint extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
	public function collect(Mage_Sales_Model_Order_Invoice $invoice)
	{
		$order = $invoice->getOrder();
		$creditpointAmountLeft = $order->getCreditpointAmount() - $order->getCreditpointAmountInvoiced();
		$basecreditpointAmountLeft = $order->getBaseCreditpointAmount() - $order->getBaseCreditpointAmountInvoiced();
		if (abs($basecreditpointAmountLeft) < $invoice->getBaseGrandTotal()) {
                    
                        //customer redeemed discount so we are subtracting the value from total
			$invoice->setGrandTotal($invoice->getGrandTotal() - $creditpointAmountLeft);
			$invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $basecreditpointAmountLeft);
		} else {
			$creditpointAmountLeft = $invoice->getGrandTotal() * -1;
			$basecreditpointAmountLeft = $invoice->getBaseGrandTotal() * -1;

			$invoice->setGrandTotal(0);
			$invoice->setBaseGrandTotal(0);
		}
			
		$invoice->setCreditpointAmount($creditpointAmountLeft);
		$invoice->setBaseCreditpointAmount($basecreditpointAmountLeft);
		return $this;
	}
}
