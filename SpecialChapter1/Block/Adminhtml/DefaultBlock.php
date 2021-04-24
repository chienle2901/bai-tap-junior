<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml;

use Magenest\SpecialChapter1\Helper\Config;
use Magenest\SpecialChapter1\Model\ResourceModel\Delivery;
use Magento\Backend\Block\Template;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class DefaultBlock
 * @package Magenest\SpecialChapter1\Block\Adminhtml
 */
class DefaultBlock extends Template
{
    /**
     * @var Config
     */
    protected $helperConfig;

    /**
     * @var Delivery
     */
    protected $delivery;

    /**
     * @var Json
     */
    protected $json;

    /**
     * DefaultBlock constructor.
     * @param Json $json
     * @param Delivery $delivery
     * @param Config $helperConfig
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Json $json,
        Delivery $delivery,
        Config $helperConfig,
        Template\Context $context,
        array $data = []
    ) {
        $this->json = $json;
        $this->delivery = $delivery;
        $this->helperConfig = $helperConfig;
        parent::__construct($context, $data);
    }

    /**
     * Check is display comment field
     * @return mixed
     */
    public function isDisplayComment()
    {
        return $this->helperConfig->isCommentEnable();
    }

    /**
     * get days can not delivery
     * @return false|string
     */
    public function getDayCanNotDelivery()
    {
        return (string) $this->helperConfig->getDaysCanNotDelivery();
    }

    /**
     * Get delivery time
     * @return array
     */
    public function getDeliveryTime()
    {
        $times = $this->delivery->getDeliveryTime(0, 1);
        $result = [];
        foreach ($times as $item) {
            $item = $this->json->unserialize($item);
            foreach ($item as $obj) {
                $result[] = $obj['from'] . " - " . $obj['to'];
            }
        }
        return $result;
    }

    /**
     * Get date format
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->helperConfig->getDateFormat();
    }
}
