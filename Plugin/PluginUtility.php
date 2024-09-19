<?php
/***
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 **/

namespace MagePal\LimitGuestCheckoutCoupon\Plugin;

use Closure;
use Exception;
use Magento\SalesRule\Model\CouponFactory;
use MagePal\LimitGuestCheckoutCoupon\Helper\Data;

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
     * PluginUtility constructor.
     * @param CouponFactory $couponFactory
     * @param Data $helperData
     */
    public function __construct(
        CouponFactory $couponFactory,
        Data $helperData
    ) {
        $this->couponFactory = $couponFactory;
        $this->helperData = $helperData;
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

        $couponCode = $address->getQuote()->getCouponCode();

        if ($this->helperData->isEnabled() && $couponCode) {
            $coupon = $this->couponFactory->create();
            $coupon->load($couponCode, 'code');

            if ($coupon->getId() && $rule->getUsesPerCoupon()
                && $coupon->getTimesUsed() >= $rule->getUsesPerCoupon()
            ) {
                $result = false;
            }
        }

        return $result;
    }
}
