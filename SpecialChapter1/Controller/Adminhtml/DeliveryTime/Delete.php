<?php

namespace Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime;

use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * @var \Magenest\SpecialChapter1\Model\ResourceModel\Delivery
     */
    protected $deliveryResource;

    /**
     * @var \Magenest\SpecialChapter1\Model\ResourceModel\Delivery\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Delete constructor.
     * @param \Magenest\SpecialChapter1\Model\ResourceModel\Delivery $deliveryResource
     * @param \Magenest\SpecialChapter1\Model\ResourceModel\Delivery\CollectionFactory $collectionFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param Action\Context $context
     */
    public function __construct(
        \Magenest\SpecialChapter1\Model\ResourceModel\Delivery $deliveryResource,
        \Magenest\SpecialChapter1\Model\ResourceModel\Delivery\CollectionFactory $collectionFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        Action\Context $context
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->deliveryResource = $deliveryResource;
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $items = $this->filter->getCollection($this->collectionFactory->create());
        $deliveryDeleted = 0;
        $deliveryNotDeleted = 0;
        foreach ($items as $item) {
            try {
                $this->deliveryResource->delete($item);
                $deliveryDeleted ++;
            } catch (\Exception $exception) {
                $deliveryNotDeleted ++;
            }
        }
        if ($deliveryDeleted) {
            $this->messageManager->addSuccessMessage(__("%s was deleted was deleted successfully."), $deliveryDeleted);
        }
        if ($deliveryNotDeleted) {
            $this->messageManager->addNoticeMessage(__("%s could not deleted."), $deliveryDeleted);
        }
        return $this->resultRedirectFactory->create()->setRefererUrl();
    }
}
