<?php

namespace Magenest\SpecialChapter1\Plugin\Block\Checkout;

/**
 * Class LayoutProcessor
 * @package Magenest\SpecialChapter1\Plugin\Block\Checkout
 */
class LayoutProcessor
{
    /**
     * @var \Magenest\SpecialChapter1\Helper\Data
     */
    protected $helper;

    /**
     * LayoutProcessor constructor.
     * @param \Magenest\SpecialChapter1\Helper\Data $helper
     */
    public function __construct(
        \Magenest\SpecialChapter1\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param $jsLayout
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $jsLayout)
    {
        $children = $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['before-shipping-method-form']['children']['shippingAdditional']['children'];
        $isComment = ($this->helper->isEnableCommentField()) ? true : false;
        $notice = $this->helper->getNoticeByAdmin();
        $children['delivery_date'] = array_merge($children, [
            'component' => 'Magenest_SpecialChapter1/js/form/element/date',
            'dataScope' => 'shippingAddress.custom_attributes.delivery_date',
            'provider' => 'checkoutProvider',
            'label' => 'Delivery Date',
            'notice' => $notice,
            'validation' => ['required-entry' => true],
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'Magenest_SpecialChapter1/form/element/date.html'
            ]
        ]);

        $children['delivery_time'] = array_merge($children, [
            'component' => 'Magento_Ui/js/form/element/select',
            'dataScope' => 'shippingAddress.custom_attributes.delivery_time',
            'provider' => 'checkoutProvider',
            'label' => 'Delivery Time Interval',
            'visible' => true,
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'options' => $this->helper->getDeliveryTimeOptions(),
            ],
            'validation' => [
                'required-entry' => true
            ]
        ]);

        $children['comment'] = array_merge($children, [
            'component' => 'Magento_Ui/js/form/element/textarea',
            'dataScope' => 'shippingAddress.custom_attributes.comment',
            'provider' => 'checkoutProvider',
            'label' => 'Comment',
            'visible' => $isComment,
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/textarea'
            ],
            'validation' => [
                'required-entry' => true,
                'max_text_length' => 500
            ]
        ]);

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['before-shipping-method-form']['children']['shippingAdditional']['children'] = $children;
        return $jsLayout;
    }
}
