<?php
/***
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
*/

namespace MagePal\LimitGuestCheckoutCoupon\Plugin;

class PluginUtility
{
    /**
     * @var \Magento\SalesRule\Model\CouponFactory
     */
    protected $couponFactory;

    /**
     * @var \MagePal\LimitGuestCheckoutCoupon\Helper\Data
     */
    protected $helperData;

    /**
     * PluginUtility constructor.
     * @param \Magento\SalesRule\Model\CouponFactory $couponFactory
     * @param \MagePal\LimitGuestCheckoutCoupon\Helper\Data $helperData
     */
    public function __construct(
        \Magento\SalesRule\Model\CouponFactory $couponFactory,
        \MagePal\LimitGuestCheckoutCoupon\Helper\Data $helperData
    ) {
        $this->couponFactory = $couponFactory;
        $this->helperData = $helperData;
    }
    /**
     * @param $subject
     * @param \Closure $proceed
     * @param $rule
     * @param $address
     * @return bool
     * @throws \Exception
     */
    public function aroundCanProcessRule($subject, \Closure $proceed, $rule, $address)
    {
        $result = $proceed($rule, $address);

        $couponCode = $address->getQuote()->getCouponCode();

        if ($this->helperData->isEnabled() && $couponCode) {
            $coupon = $this->couponFactory->create();
            $coupon->load($couponCode, 'code');

            if ($coupon->getId() && $rule->getUsesPerCoupon() && $coupon->getTimesUsed() >= $rule->getUsesPerCoupon()) {
                $result = false;
            }
        }

        return $result;
    }
}
