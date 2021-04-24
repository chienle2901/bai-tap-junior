<?php

namespace Magenest\SpecialChapter1\Observer\Order\Model;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;

/**
 * Class BeforePlaceOrder
 * @package Magenest\SpecialChapter1\Observer\Order\Model
 */
class BeforePlaceOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * BeforePlaceOrder constructor.
     * @param RequestInterface $request
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->request = $request;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getData('order');
        $address = $this->checkoutSession->getQuote()->getShippingAddress();
        $orderAddress = $order->getShippingAddress();
        $deliveryDate = $address->getData('delivery_date');
        $deliveryTime = $address->getData('delivery_time');
        $comment = $address->getData('comment');
        if (empty($deliveryDate)) {
            $deliveryDate = $this->request->getParam("order")['delivery_date'];
        }
        if (empty($deliveryTime)) {
            $deliveryTime = $this->request->getParam("order")['delivery_time'];
        }
        if (empty($comment)) {
            $comment = $this->request->getParam("order")['delivery-comment'];
        }
        $orderAddress->setData('delivery_date', $deliveryDate);
        $orderAddress->setData('delivery_time', $deliveryTime);
        $orderAddress->setData('comment', $comment);
    }
}
