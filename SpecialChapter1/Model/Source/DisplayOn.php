<?php

namespace Magenest\SpecialChapter1\Model\Source;

/**
 * Class DisplayOn
 * @package Magenest\SpecialChapter1\Model\Source
 */
class DisplayOn implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'order_view_page', 'label' => __('Order View Page (Backend)')],
            ['value' => 'reorder_page', 'label' => __('New/Edit/Reorder Order Page (Backend)')],
            ['value' => 'invoice', 'label' => __('Invoice View Page (Backend)')],
            ['value' => 'payment', 'label' => __('Shipment View Page (Backend)')],
            ['value' => 'frontend', 'label' => __('Order Info Page (Frontend)')]
        ];
    }
}
