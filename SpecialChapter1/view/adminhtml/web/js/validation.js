define([
    'jquery',
    'moment'
], function ($, moment) {
    'use strict';
    return function (validator) {
        validator.addRule(
            'delivery-time-validate',
            function (value, element, object) {
                return value != 0;
            },
            $.mage.__("Please enter a number other than 0.")
        );
        return validator;
    };
});
