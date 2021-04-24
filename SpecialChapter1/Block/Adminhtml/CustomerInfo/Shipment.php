<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml\CustomerInfo;

use Magenest\SpecialChapter1\Helper\Config;
use Magento\Backend\Block\Template;
use Magento\Sales\Model\OrderRepository;
use Magento\Sales\Model\Order\ShipmentRepository;

/**
 * Class Shipment
 * @package Magenest\SpecialChapter1\Block\Adminhtml\CustomerInfo
 */
class Shipment extends \Magenest\SpecialChapter1\Block\Adminhtml\AbstractDelivery
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var Config
     */
    protected $helperConfig;

    /**
     * @var ShipmentRepository
     */
    protected $shipmentRepository;

    /**
     * DeliveryInfo constructor.
     * @param ShipmentRepository $invoiceRepository
     * @param Config $helperConfig
     * @param \Psr\Log\LoggerInterface $logger
     * @param OrderRepository $orderRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        ShipmentRepository $shipmentRepository,
        Config $helperConfig,
        \Psr\Log\LoggerInterface $logger,
        OrderRepository $orderRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->shipmentRepository = $shipmentRepository;
        $this->helperConfig = $helperConfig;
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * @inheritDoc
     */
    public function getDeliveryInfo()
    {
        $shipmentId = $this->getRequest()->getParam('shipment_id', null);
        try {
            $id = $this->shipmentRepository->get($shipmentId)->getOrderId();
            return $this->orderRepository->get($id)->getShippingAddress();
        } catch (\Exception $exception) {
            $this->logger->critical(__($exception->getMessage()));
        }
    }

    /**
     * @inheritDoc
     */
    public function isDisplayDelivery()
    {
        return $this->helperConfig->isDisplayOnSalesOrder(\Magenest\SpecialChapter1\Helper\Config::DISPLAY_ON_SHIPMENT_PAGE);
    }
}
