<?php

namespace Magenest\SpecialChapter1\Helper;

use Magenest\SpecialChapter1\Model\ResourceModel\Delivery;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Data
 * @package Magenest\SpecialChapter1\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Delivery
     */
    protected $delivery;

    protected $json;

    /**
     * Data constructor.
     * @param Json $json
     * @param Delivery $delivery
     * @param StoreManagerInterface $storeManager
     * @param Session $session
     * @param Context $context
     */
    public function __construct(
        Json $json,
        Delivery $delivery,
        StoreManagerInterface $storeManager,
        Session $session,
        Context $context
    ) {
        $this->json = $json;
        $this->delivery = $delivery;
        $this->storeManager = $storeManager;
        $this->session = $session;
        parent::__construct($context);
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDeliveryTimeOptions() {
        $currentStore = $this->storeManager->getStore()->getId();
        $currentCusGroup = $this->session->getCustomerGroupId();
        $data = $this->delivery->getDeliveryTime($currentStore, $currentCusGroup);
        $result = [];
        foreach ($data as $item) {
            $items = $this->json->unserialize($item);
            foreach ($items as $obj) {
                $result[] = ['value' => $obj['from'] . " - " . $obj['to'], 'label' => $obj['from'] . " - " . $obj['to']];
            }
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function isEnableCommentField() {
        return $this->scopeConfig->getValue(
            \Magenest\SpecialChapter1\Helper\Config::DELIVERY_ENABLE_COMMENT_FIELD,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORES
        );
    }

    /**
     * Get notice by admin
     * @return mixed
     */
    public function getNoticeByAdmin() {
        return $this->scopeConfig->getValue(
            \Magenest\SpecialChapter1\Helper\Config::DELIVERY_NOTICE_BY_ADMIN,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORES
        );
    }
}
