define([
    'mage/utils/wrapper'
], function (wrapper) {
    'use strict';

    return function (disableShippingAddress) {
        return wrapper.wrap(disableShippingAddress, function (originalDisableShippingAddress, flag) {
            if (flag) {
                $("input#delivery_date").addClass('disabled');
                $("select#delivery_time").addClass('disabled');
                $("textarea#comment").addClass('disabled');
            }
            return originalDisableShippingAddress(flag);
        });
    };
});
