<?php

namespace Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime;

use Magenest\SpecialChapter1\Model\ResourceModel\Delivery;
use Magenest\SpecialChapter1\Model\DeliveryFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Backend\App\Action;
use Magento\Setup\Module\I18n\Parser\Adapter\Js;

/**
 * Class Save
 * @package Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime
 */
class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Magenest_SpecialChapter1::save';

    /**
     * @var DeliveryFactory
     */
    protected $deliveryFactory;

    /**
     * @var Delivery
     */
    protected $deliveryResource;

    /**
     * @var Json
     */
    protected $json;

    /**
     * Save constructor.
     * @param DeliveryFactory $deliveryFactory
     * @param Delivery $deliveryResource
     * @param Json $json
     * @param Action\Context $context
     */
    public function __construct(
        DeliveryFactory $deliveryFactory,
        Delivery $deliveryResource,
        Json $json,
        Action\Context $context
    ) {
        $this->deliveryFactory = $deliveryFactory;
        $this->deliveryResource = $deliveryResource;
        $this->json = $json;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        if (empty($data)) {
            $this->messageManager->addErrorMessage(__('Sorry, there has been an error processing your request. Please try again later.'));
            return $resultRedirect->setRefererUrl();
        }
        try {
            $delivery = $this->deliveryFactory->create();
            if (!empty($data['id'])) {
                $this->deliveryResource->load($delivery, $data['id']);
            }
            $delivery->setData($this->serialize($data));
            $this->deliveryResource->save($delivery);
            $this->deliveryResource->insertStores($delivery->getId(), $data['store_id']);
            $this->deliveryResource->insertCustomerGroup($delivery->getId(), $data['customer_group']);
            $this->messageManager->addSuccessMessage(__('Delivery time saved successfully.'));
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Could not be save delivery time. Please try again later.'));
        }

        return $resultRedirect->setPath('*/*');
    }

    /**
     * Json encode data
     * @param $data
     * @return array|null|mixed
     */
    public function serialize($data) {
        $data['delivery_time'] = $this->json->serialize($data['delivery_time']);
        return $data;
    }
}
