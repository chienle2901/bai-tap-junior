<?php

namespace Magenest\SpecialChapter1\Model\ResourceModel\Delivery;

use Magenest\SpecialChapter1\Model\Delivery;
use Magenest\SpecialChapter1\Model\ResourceModel\Delivery as DeliveryResource;

/**
 * Class Collection
 * @package Magenest\SpecialChapter1\Model\ResourceModel\Delivery
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Delivery::class, DeliveryResource::class);
    }
}
