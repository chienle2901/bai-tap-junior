/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/date'
], function (date) {
    'use strict';
    return date.extend({
        defaults: {
            options: {
                dateFormat: window.checkoutConfig.date_format,
                showsDate: false,
                showsTime: false,
                beforeShowDay: function(date) {
                    var days = window.checkoutConfig.not_delivery || [];
                    var leadTime = window.checkoutConfig.lead_time || 0;
                    var maxTime = window.checkoutConfig.max_time || 0;
                    var now = new Date();
                    days = days || days.split(',');
                    var show = true;
                    for (var i = 0; i <= days.length; i++) {
                        if (date.getDay() == days[i]) show = false
                    }
                    if (leadTime) {
                        if (date.getDate() < (now.getDate() + Number(leadTime))) show = false;
                    }
                    if (maxTime) {
                        if (date.getDate() > (now.getDate() + Number(maxTime))) show = false;
                        if (date.getMonth() !== now.getMonth()) show = false;
                    }
                    return [show];
                }
            }
        },
    });
},);


