<?php

namespace Magenest\SpecialChapter1\Ui\Form;

use Magenest\SpecialChapter1\Model\ResourceModel\Delivery;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Customer\Api\GroupRepositoryInterface;

/**
 * Class CustomerGroup
 * @package Magenest\SpecialChapter1\Ui\Form
 */
class CustomerGroup extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @var Delivery
     */
    protected $delivery;

    /**
     * CustomerGroup constructor.
     * @param Delivery $delivery
     * @param GroupRepositoryInterface $groupRepository
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        Delivery $delivery,
        GroupRepositoryInterface $groupRepository,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->delivery = $delivery;
        $this->groupRepository = $groupRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item['id'])) {
                    $item['customer_group'] = $this->getOptionGrid($item['id']);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param $id
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOptionGrid($id)
    {
        $result = '';
        $data = $this->delivery->getCustomerGroupByDeliveryId($id);
        foreach ($data as $groupId) {
            $groupLabel = $this->groupRepository->getById($groupId)->getCode();
            $result .= "<p>" . $groupLabel . "</p>";
        }
        return $result;
    }
}
