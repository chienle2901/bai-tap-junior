var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Magenest_SpecialChapter1/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/view/shipping-information/address-renderer/default': {
                'Magenest_SpecialChapter1/js/view/shipping-information/address-renderer/default-mixin': true
            },
        }
    },
    map: {
        '*': {
            'Magento_Checkout/template/shipping-information/address-renderer/default.html':
                'Magenest_SpecialChapter1/template/shipping-information/address-renderer/default.html',
        }
    }
};
