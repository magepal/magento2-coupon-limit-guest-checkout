<a href="http://www.magepal.com" title="Magento 2 Marketplace" ><img src="https://image.ibb.co/dHBkYH/Magepal_logo.png" width="100" align="right" alt="Magento 2 Extension and Plugins" /></a>

## Limit Guest Checkout Coupon Code


Restricting coupon with maximum uses for guest checkout. This feature maybe added to core Magento 2.3.

See

 - https://github.com/magento/magento2/issues/776
 - https://github.com/magento/magento2/issues/12783



## Installation

#### Step 1
##### Using Composer (recommended)
```
composer require magepal/magento2-coupon-limit-guest-checkout
```
##### Manually
 * Download the extension
 * Unzip the file
 * Create a folder {Magento 2 root}/app/code/MagePal/LimitGuestCheckoutCoupon
 * Copy the content from the unzip folder

#### Step 2 - Enable Module (from {Magento root} folder)
 * php -f bin/magento module:enable --clear-static-content MagePal_LimitGuestCheckoutCoupon
 * php -f bin/magento setup:upgrade
 
#### Step 3 - Configuration
 
 Log into your Magento 2 Admin, then goto Stores -> Configuration -> MagePal -> Checkout ->

Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


Support
---
If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magepal/magento2-reindex/issues).

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.

Other Extensions
---
[Custom SMTP](https://www.magepal.com/magento2/extensions/custom-smtp.html) | [Google Tag Manager](https://www.magepal.com/magento2/extensions/google-tag-manager.html) | [Enhanced E-commerce](https://www.magepal.com/magento2/extensions/enhanced-ecommerce-for-google-tag-manager.html) | [Reindex](https://www.magepal.com/magento2/extensions/reindex.html) | [Custom Shipping Method](https://www.magepal.com/magento2/extensions/custom-shipping-rates-for-magento-2.html) | [Preview Order Confirmation](https://www.magepal.com/magento2/extensions/preview-order-confirmation-page-for-magento-2.html) | [Guest to Customer](https://www.magepal.com/magento2/extensions/guest-to-customer.html) | [Admin Form Fields Manager](https://www.magepal.com/magento2/extensions/admin-form-fields-manager-for-magento-2.html) | [Customer Dashboard Links Manager](https://www.magepal.com/magento2/extensions/customer-dashboard-links-manager-for-magento-2.html) | [Lazy Loader](https://www.magepal.com/magento2/extensions/lazy-load.html) | [Order Confirmation Page Miscellaneous Scripts](https://www.magepal.com/magento2/extensions/order-confirmation-miscellaneous-scripts-for-magento-2.html)

© MagePal LLC. | [www.magepal.com](http:/www.magepal.com)
