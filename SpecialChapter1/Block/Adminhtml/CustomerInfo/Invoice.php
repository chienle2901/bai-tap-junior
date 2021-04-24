<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml\CustomerInfo;

use Magenest\SpecialChapter1\Helper\Config;
use Magento\Backend\Block\Template;
use Magento\Sales\Model\OrderRepository;
use Magento\Sales\Model\Order\InvoiceRepository;

/**
 * Class Invoice
 * @package Magenest\SpecialChapter1\Block\Adminhtml\CustomerInfo
 */
class Invoice extends \Magenest\SpecialChapter1\Block\Adminhtml\AbstractDelivery
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
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * DeliveryInfo constructor.
     * @param InvoiceRepository $invoiceRepository
     * @param Config $helperConfig
     * @param \Psr\Log\LoggerInterface $logger
     * @param OrderRepository $orderRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        InvoiceRepository $invoiceRepository,
        Config $helperConfig,
        \Psr\Log\LoggerInterface $logger,
        OrderRepository $orderRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->invoiceRepository = $invoiceRepository;
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
        $invoiceId = $this->getRequest()->getParam('invoice_id', null);
        try {
            $id = $this->invoiceRepository->get($invoiceId)->getOrderId();
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
        return $this->helperConfig->isDisplayOnSalesOrder(\Magenest\SpecialChapter1\Helper\Config::DISPLAY_ON_INVOICE_PAGE);
    }
}
