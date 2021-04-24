<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml\Config;

/**
 * Class Hidden
 * @package Magenest\SpecialChapter1\Block\Adminhtml\Config
 */
class Hidden extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
        return '<style>#row_delivery_config_configuration_disable_same_day_delivery_hour, #row_delivery_config_configuration_disable_same_day_delivery_minute {display: none}</style>';
    }
}
