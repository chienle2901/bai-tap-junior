<?php

namespace Magenest\SpecialChapter1\Cron;

use Magenest\SpecialChapter1\Helper\Config;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Psr\Log\LoggerInterface;
use Magento\Framework\View\Asset\Repository;

/**
 * Class SendMail
 * @package Magenest\SpecialChapter1\Cron
 */
class SendMail
{
    /**
     * @var Config
     */
    protected $helperConfig;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var StateInterface
     */
    protected $_inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Repository
     */
    protected $moduleAssetDir;

    /**
     * SendMail constructor.
     * @param CollectionFactory $collectionFactory
     * @param TransportBuilder $_transportBuilder
     * @param StateInterface $_inlineTranslation
     * @param LoggerInterface $logger
     * @param Repository $moduleAssetDir
     * @param Config $helperConfig
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        TransportBuilder $_transportBuilder,
        StateInterface $_inlineTranslation,
        LoggerInterface $logger,
        Repository $moduleAssetDir,
        Config $helperConfig
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_inlineTranslation = $_inlineTranslation;
        $this->_transportBuilder = $_transportBuilder;
        $this->logger = $logger;
        $this->moduleAssetDir = $moduleAssetDir;
        $this->helperConfig = $helperConfig;
    }

    public function execute()
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('state', ['in' => [Order::STATE_NEW, Order::STATE_PROCESSING, Order::STATE_PENDING_PAYMENT]]);
        foreach ($collection as $order) {
            $shippingAddress = $order->getShippingAddress();
            $this->handle($shippingAddress, $order->getCreatedAt(), $order->getCustomerEmail());
        }
    }

    /**
     * Handle sendmail
     * @param $address
     * @param $createdAt
     * @param $email
     */
    public function handle($address, $createdAt, $email)
    {
        if ($deliveryDate = $address->getDeliveryDate()) {
            $deliveryDate = date('Y-m-d H:i:s', strtotime($deliveryDate));
            $deliveryTime = $address->getDeliveryTime();
            $deliveryTime = str_replace(":00", "", explode(' - ', $deliveryTime)[0]);
            $now = date('Y-m-d H:i:s');
            if (date('d', strtotime($deliveryDate)) == date('d')) {
                if ((date('H') + 1) == $deliveryTime) {
                    $this->sendMail($email);
                }
            }
        }
    }

    /**
     * Send mail
     * @param $email
     */
    public function sendMail($email)
    {
        try {
            $this->_inlineTranslation->suspend();
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier('delivery_email')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([])
                ->setFromByScope('general')
                ->addTo($email)
                ->getTransport();
            $transport->sendMessage();
            $this->_inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->critical('Send mail error ' . $e->getMessage());
        }
    }
}
