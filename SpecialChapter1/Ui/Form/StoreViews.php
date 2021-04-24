<?php

namespace Magenest\SpecialChapter1\Ui\Form;

use Magenest\SpecialChapter1\Model\ResourceModel\Delivery;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class StoreViews
 * @package Magenest\SpecialChapter1\Ui\Form
 */
class StoreViews extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Delivery
     */
    protected $delivery;

    /**
     * StoreViews constructor.
     * @param Delivery $delivery
     * @param StoreManagerInterface $storeManager
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        Delivery $delivery,
        StoreManagerInterface $storeManager,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->delivery = $delivery;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item['id'])) {
                    $item['store_id'] = $this->getOptionGrid($item['id']);
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get store html
     * @param $id
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOptionGrid($id) {
        $result = '';
        $data = $this->delivery->getStoreByDeliveryId($id);
        foreach ($data as $storeId) {
            $storeLabel = $this->storeManager->getStore($storeId)->getName();
            $result .= "<p>" . $storeLabel . "</p>";
        }
        return $result;
    }
}
