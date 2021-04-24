<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml\CustomerInfo;

use Magenest\SpecialChapter1\Helper\Config;
use Magento\Backend\Block\Template;
use Magento\Sales\Model\OrderRepository;

/**
 * Class DeliveryInfo
 * @package Magenest\SpecialChapter1\Block\Adminhtml\CustomerInfo
 */
class DeliveryInfo extends \Magenest\SpecialChapter1\Block\Adminhtml\AbstractDelivery
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
     * DeliveryInfo constructor.
     * @param Config $helperConfig
     * @param \Psr\Log\LoggerInterface $logger
     * @param OrderRepository $orderRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Config $helperConfig,
        \Psr\Log\LoggerInterface $logger,
        OrderRepository $orderRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->helperConfig = $helperConfig;
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get delivery information
     */
    public function getDeliveryInfo()
    {
        $id = $this->getRequest()->getParam('order_id', 19);
        try {
            return $this->orderRepository->get($id)->getShippingAddress();
        } catch (\Exception $exception) {
            $this->logger->critical(__($exception->getMessage()));
        }
    }

    /**
     * Check display delivery information section
     * @return bool
     */
    public function isDisplayDelivery()
    {
        return $this->helperConfig->isDisplayOnSalesOrder(\Magenest\SpecialChapter1\Helper\Config::DISPLAY_ON_SALES_ORDER_VIEW);
    }
}
