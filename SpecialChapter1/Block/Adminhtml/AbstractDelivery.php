<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml;

/**
 * Class AbstractDelivery
 * @package Magenest\SpecialChapter1\Block\Adminhtml
 */
abstract class AbstractDelivery extends \Magento\Backend\Block\Template
{
    /**
     * Get delivery info
     * @return mixed|array
     */
    abstract function getDeliveryInfo();

    /**
     * Check is display delivery
     * @return mixed
     */
    abstract function isDisplayDelivery();
}
