<?php

namespace Magenest\SpecialChapter1\Model\Source;

use Magenest\SpecialChapter1\Model\ResourceModel\Delivery;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class DataProvider
 * @package Magenest\SpecialChapter1\Model\Source
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magenest\SpecialChapter1\Model\ResourceModel\Delivery\CollectionFactory
     */
    protected $collection;

    /**
     * @var Json
     */
    protected $json;

    /**
     * @var array
     */
    protected $_loadedData;

    /**
     * @var Delivery
     */
    protected $delivery;

    /**
     * DataProvider constructor.
     * @param Delivery $delivery
     * @param Json $json
     * @param \Magenest\SpecialChapter1\Model\ResourceModel\Delivery\CollectionFactory $collection
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        Delivery $delivery,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magenest\SpecialChapter1\Model\ResourceModel\Delivery\CollectionFactory $collection,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->delivery = $delivery;
        $this->json = $json;
        $this->collection = $collection->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $this->unserializer($item->getData());
        }
        return $this->_loadedData;
    }

    /**
     * Json decode data
     * @param $data
     * @return mixed|null|array
     */
    public function unserializer($data) {
        if (!empty($data['delivery_time'])) {
            $data['delivery_time'] = $this->json->unserialize($data['delivery_time']);
        }
        $data['store_id'] = $this->delivery->getStoreByDeliveryId($data['id']);
        $data['customer_group'] = $this->delivery->getCustomerGroupByDeliveryId($data['id']);
        return $data;
    }
}
