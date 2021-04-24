<?php

namespace Magenest\SpecialChapter1\Model;

/**
 * Class Delivery
 * @package Magenest\SpecialChapter1\Model
 */
class Delivery extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(\Magenest\SpecialChapter1\Model\ResourceModel\Delivery::class);
    }
}
