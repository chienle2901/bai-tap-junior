define(function () {
    'use strict';
    var mixin = {

        isDeliveryDate: function (elem) {
            var result = false;
            if (elem.attribute_code == 'delivery_date' && elem.value) {
                result = true;
            }
            return result;
        },

        isDeliveryTime: function (elem) {
            var result = false;
            if (elem.attribute_code == 'delivery_time' && elem.value) {
                result = true;
            }
            return result;
        },

        isComment: function (elem) {
            var result = false;
            if (elem.attribute_code == 'comment' && elem.value) {
                result = true;
            }
            return result;
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
