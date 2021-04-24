<?php

namespace Magenest\SpecialChapter1\Model;

use Magenest\SpecialChapter1\Helper\Config;
use Magento\Checkout\Model\ConfigProviderInterface;

/**
 * Class ConfigProvider
 * @package Magenest\SpecialChapter1\Model
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var Config
     */
    protected $helperConfig;

    /**
     * ConfigProvider constructor.
     * @param Config $helperConfig
     */
    public function __construct(
        Config $helperConfig
    ) {
        $this->helperConfig = $helperConfig;
    }

    /**
     * Add data to checkout config
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        $config['not_delivery'] = $this->helperConfig->getDaysCanNotDelivery();
        $config['date_format'] = $this->helperConfig->getDateFormat();
        $config['lead_time'] = $this->helperConfig->getLeadTime();
        $config['max_time'] = $this->helperConfig->getMaxTime();
        return $config;
    }
}
