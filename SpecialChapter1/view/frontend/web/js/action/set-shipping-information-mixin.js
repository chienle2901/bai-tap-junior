define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';
    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }
            var attribute = shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'delivery_date';
                }
            );
            var attribute1 = shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'delivery_time';
                }
            );
            var attribute2 = shippingAddress.customAttributes.find(
                function (element) {
                    return element.attribute_code === 'comment';
                }
            );
            shippingAddress['extension_attributes']['delivery_date'] = attribute.value;
            shippingAddress['extension_attributes']['delivery_time'] = attribute1.value;
            shippingAddress['extension_attributes']['comment'] = attribute2.value;
            return originalAction();
        });
    };
});
