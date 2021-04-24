<?php

namespace Magenest\SpecialChapter1\Ui\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class DeliveryTime
 * @package Magenest\SpecialChapter1\Ui\Form
 */
class DeliveryTime extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var Json
     */
    protected $json;

    /**
     * DeliveryTime constructor.
     * @param Json $json
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        Json $json,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->json = $json;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item['store_id'])) {
                    $item['delivery_time'] = $this->getOptionGrid($item['delivery_time']);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param $deliveryTimes
     * @return string
     */
    public function getOptionGrid($deliveryTimes) {
        $result = '';
        if (!empty($deliveryTimes)) {
            foreach ($this->json->unserialize($deliveryTimes) as $time) {
                $result .= "<p>" . $time['from'] . " - " . $time['to'] . "</p>";
            }
        }
        return $result;
    }
}
