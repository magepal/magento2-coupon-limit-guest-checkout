<?php
/***
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 **/

namespace MagePal\LimitGuestCheckoutCoupon\Plugin;

use Closure;
use Exception;
use Magento\SalesRule\Model\CouponFactory;
use MagePal\LimitGuestCheckoutCoupon\Helper\Data;
use MagePal\LimitGuestCheckoutCoupon\Logger\Logger;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class PluginUtility
{
    /**
     * @var CouponFactory
     */
    protected $couponFactory;

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var \MagePal\LimitGuestCheckoutCoupon\Logger\Logger
     */
    protected $_logger;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_orderCollectionFactory;

    /**
     * @param \Magento\SalesRule\Model\CouponFactory $couponFactory
     * @param \MagePal\LimitGuestCheckoutCoupon\Helper\Data $helperData
     * @param \MagePal\LimitGuestCheckoutCoupon\Logger\Logger $logger
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        CouponFactory $couponFactory,
        Data $helperData,
        Logger $logger,
        CollectionFactory $orderCollectionFactory
    ) {
        $this->couponFactory = $couponFactory;
        $this->helperData = $helperData;
        $this->_logger = $logger;
        $this->_orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * @param $subject
     * @param Closure $proceed
     * @param $rule
     * @param $address
     * @return bool
     * @throws Exception
     */
    public function aroundCanProcessRule($subject, Closure $proceed, $rule, $address)
    {
        $result = $proceed($rule, $address);

        if (!$this->helperData->isEnabled()) {
            return $result;
        }

        $quote = $address->getQuote();
        $couponCode = $quote->getCouponCode();

        if ($couponCode) {

            $coupon = $this->couponFactory->create();
            $coupon->load($couponCode, 'code');

            if ($coupon->getId() &&
                $rule->getUsesPerCoupon() &&
                $coupon->getTimesUsed() >= $rule->getUsesPerCoupon()) {
                $result = false;
            }

            $customerId = $quote->getCustomerId();
            $email = $quote->getBillingAddress()->getEmail();

            if ($coupon->getId() && !$customerId && $email) {

                $collection = $this->_orderCollectionFactory->create()
                    ->addAttributeToSelect('*')
                    ->addFieldToFilter('customer_email', ['eq' => $email])
                    ->addFieldToFilter('coupon_code', ['eq' => $couponCode]);
    
                if ($collection->getSize() >= $rule->getUsesPerCustomer()) {
                    $result = false;
                }
            }
        }

        return $result;
    }
}
