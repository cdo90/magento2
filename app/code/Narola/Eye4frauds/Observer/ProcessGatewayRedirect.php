<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Narola\Eye4frauds\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;

class ProcessGatewayRedirect implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    private $storeManager;
    protected $_checkoutSession;
    protected $customerSession;
	
    public function __construct(
        StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Session $checkoutSession,
	    \Magento\Customer\Model\Session $customerSession
	) {
        $this->storeManager = $storeManager;
        $this->_checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
	}
	
    public function execute(\Magento\Framework\Event\Observer $observer)
    { 
        $orderId = $observer->getEvent()->getOrderIds();
		
		
        $base_url = $this->storeManager->getStore()->getBaseUrl();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderObj = $objectManager->create('\Magento\Sales\Model\Order')->load($orderId[0]);
		
		$orderIP = $orderObj->getRemoteIp();
		echo "<br>order IP : ".$orderIP; 
		
		$orderObj_data = $orderObj->getData();
	
		echo "<br>grand_total : ".$GrandTotal = $orderObj_data['grand_total'];
		echo "<br>shipping_amount : ".$ShippingCost = $orderObj_data['shipping_amount'];
		echo "<br>Created At : ".$OrderDate = $orderObj_data['created_at'];
		echo "<br>OrderNumber : ".$OrderNumber = $orderId[0];
		
		$orderItems = $orderObj->getAllItems();
		//$orderItem_data = $orderItems->getData();
		$LineItems = array();
		$cnt = 1;
		foreach ($orderItems as $item) {
			$itemdatas = $item->getData();
			$LineItems[$cnt] = array('ProductName'=>$itemdatas['name'],'ProductDescription'=>$itemdatas['description'],'ProductSellingPrice'=>$itemdatas['price'],'ProductQty'=>$itemdatas['qty_ordered']);
			$cnt++;
		}
		echo "<pre>";
		print_r($LineItems);
		
		
		$shippingAddressObj = $orderObj->getShippingAddress();
		$shippingAddressArray = $shippingAddressObj->getData();
		
		echo "<br>ShippingFirstName : ".$ShippingFirstName = $shippingAddressArray['firstname'];
		echo "<br>ShippingMiddleName : ".$ShippingMiddleName = $shippingAddressArray['middlename'];;
		echo "<br>ShippingLastName : ".$ShippingLastName = $shippingAddressArray['lastname'];
		echo "<br>ShippingCompany : ".$ShippingCompany = $shippingAddressArray['company'];
		echo "<br>ShippingAddress1 : ".$ShippingAddress1 = $shippingAddressArray['street'];
		echo "<br>ShippingAddress2 : ".$ShippingAddress2 = $shippingAddressArray['street'];
		echo "<br>ShippingCity : ".$ShippingCity = $shippingAddressArray['city'];
		echo "<br>ShippingState : ".$ShippingState = $shippingAddressArray['region'];
		echo "<br>ShippingZip : ".$ShippingZip = $shippingAddressArray['postcode'];
		echo "<br>ShippingCountry : ".$ShippingCountry = $shippingAddressArray['country_id'];
		echo "<br>ShippingEveningPhone : ".$ShippingEveningPhone = $shippingAddressArray['telephone'];
		echo "<br>ShippingEmail : ".$ShippingEmail = $shippingAddressArray['email'];
		
		
		$billingAddressObj = $orderObj->getBillingAddress();
		$billingAddressArray = $billingAddressObj->getData();
		
		echo "<br>billingFirstName : ".$billingFirstName = $billingAddressArray['firstname'];
		echo "<br>ShippingMiddleName : ".$billingMiddleName = $billingAddressArray['middlename'];;
		echo "<br>billingLastName : ".$billingLastName = $billingAddressArray['lastname'];
		echo "<br>billingCompany : ".$billingCompany = $billingAddressArray['company'];
		echo "<br>billingAddress1 : ".$billingAddress1 = $billingAddressArray['street'];
		echo "<br>billingAddress2 : ".$billingAddress2 = $billingAddressArray['street'];
		echo "<br>billingCity : ".$billingCity = $billingAddressArray['city'];
		echo "<br>billingState : ".$billingState = $billingAddressArray['region'];
		echo "<br>billingZip : ".$billingZip = $billingAddressArray['postcode'];
		echo "<br>billingCountry : ".$billingCountry = $billingAddressArray['country_id'];
		echo "<br>billingEveningPhone : ".$billingEveningPhone = $billingAddressArray['telephone'];
		echo "<br>billingEmail : ".$billingEmail = $billingAddressArray['email'];
		
		$payment = $orderObj->getPayment();
		$paymentdetails = $payment->getData();
		
		echo "<br>Transection ID :".$transection_id  = $paymentdetails['last_trans_id'];
		echo "<br>PaypalpayerID ID :".$PaypalpayerID = $paymentdetails['additional_information']['paypal_payer_id'];
		
        $method = $payment->getMethodInstance();
		
		$paymentMethodTitle = $method->getTitle();
		echo "<br>CCType : ". $CCType = $paymentMethodTitle;
		
		//$redirect = $objectManager->get('\Magento\Framework\App\Response\Http');
        //$redirect->setRedirect($base_url.'paym/redirect/index/id/'.$increment_id.'');
		
			die;	
		 
		// Create an order data array that will be posted to Eye4Fraud API
		 
		$post_array = array(
			//////// Required fields //////////////
			'ApiLogin'              => 'myapilogin',
			'ApiKey'                => '8ke384dku89oialsi44ijf9',
			'TransactionId'         => $transection_id,
			'OrderDate'             => $OrderDate,
			'OrderNumber'           => $OrderNumber,
			'BillingFirstName'      => $billingFirstName,
			'BillingMiddleName'     => $billingMiddleName,
			'BillingLastName'       => $billingLastName,
			'BillingCompany'        => $billingCompany,
			'BillingAddress1'       => $billingAddress1,
			'BillingAddress2'       => $billingAddress2,
			'BillingCity'           => $billingCity,
			'BillingState'          => $billingState,
			'BillingZip'            => $BillingZip,
			'BillingCountry'        => $BillingCountry,
			'BillingEveningPhone'   => $billingEveningPhone,
			'BillingEmail'          => $BillingEmail,
			'IPAddress'             => $orderIP,
			'ShippingFirstName'     => $ShippingFirstName,
			'ShippingMiddleName'    => $ShippingMiddleName,
			'ShippingLastName'      => $ShippingLastName,
			'ShippingCompany'       => $ShippingCompany,
			'ShippingAddress1'      => $ShippingAddress1,
			'ShippingAddress2'      => $ShippingAddress2,
			'ShippingCity'          => $ShippingCity,
			'ShippingState'         => $ShippingState,
			'ShippingZip'           => $ShippingZip,
			'ShippingCountry'       => $ShippingCountry,
			'ShippingEveningPhone'  => $ShippingEveningPhone,
			'ShippingEmail'         => $ShippingEmail,
			'ShippingCost'          => $ShippingCost,
			'GrandTotal'            => $GrandTotal,
			'CCType'                => 'PAYPAL',
			'PayPalPayerID'         => $PaypalpayerID,
			'LineItems'             => $LineItems,
			'SiteName'              => 'hhgregg',
		);
		 
		// Convert post array into a query string
		$post_query = http_build_query($post_array);
		 
		// Do the POST
		$ch = curl_init('/api/');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		 
		// Show response
		echo $response;
				
		
		
        return;
    }
}
