<?php

namespace Magenest\SpecialChapter1\Helper;

use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package Magenest\SpecialChapter1\Helper
 */
class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const DAYS_CAN_NOT_DELIVER = 'delivery_config/configuration/days_not_receive';
    const DELIVERY_LEAD_TIME = 'delivery_config/configuration/lead_time';
    const DELIVERY_MAXIMAL_TIME = 'delivery_config/configuration/maximal_delivery';
    const DELIVERY_NOTICE_BY_ADMIN = 'delivery_config/configuration/notice_by_admin';
    const DELIVERY_DATE_FORMAT = 'delivery_config/configuration/date_format';
    const DELIVERY_SAME_DAY = 'delivery_config/configuration/same_day_delivery_config';
    const DELIVERY_SAME_DAY_HOUR = 'delivery_config/configuration/disable_same_day_delivery_hour';
    const DELIVERY_SAME_DAY_MINUTE = 'delivery_config/configuration/disable_same_day_delivery_minute';
    const DELIVERY_DISPLAY_ON = 'delivery_config/configuration/delivery_display_on';
    const DELIVERY_ENABLE_COMMENT_FIELD = 'delivery_config/configuration/enable_comment_field';

    const DISPLAY_ON_SALES_ORDER_VIEW = 'order_view_page';
    const DISPLAY_ON_REORDER_PAGE = 'reorder_page';
    const DISPLAY_ON_INVOICE_PAGE = 'invoice';
    const DISPLAY_ON_SHIPMENT_PAGE = 'payment';
    const DISPLAY_ON_FRONTEND = 'frontend';

    /**
     * Get value disable same day after (hour)
     * @return mixed
     */
    public function getDisableSamDayHour() {
        return $this->scopeConfig->getValue(self::DELIVERY_SAME_DAY_HOUR, ScopeInterface::SCOPE_STORES);
    }

    /**
     * Get value disable same day after (minute)
     * @return mixed
     */
    public function getDisableSamDayMinute() {
        return $this->scopeConfig->getValue(self::DELIVERY_SAME_DAY_MINUTE, ScopeInterface::SCOPE_STORES);
    }

    /**
     * Check whether is comment field enable
     * @return mixed
     */
    public function isCommentEnable() {
        return $this->scopeConfig->getValue(self::DELIVERY_ENABLE_COMMENT_FIELD, ScopeInterface::SCOPE_STORES);
    }

    /**
     * Check display delivery
     * @param $page
     * @return bool
     */
    public function isDisplayOnSalesOrder($page)
    {
        $config = $this->scopeConfig->getValue(self::DELIVERY_DISPLAY_ON, ScopeInterface::SCOPE_STORES);
        $config = explode(',', $config);
        return in_array($page, $config, true);
    }

    /**
     * Get days can not delivery
     * @return mixed
     */
    public function getDaysCanNotDelivery()
    {
        return $this->scopeConfig->getValue(self::DAYS_CAN_NOT_DELIVER, ScopeInterface::SCOPE_STORES);
    }

    /**
     * Get date format
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->scopeConfig->getValue(self::DELIVERY_DATE_FORMAT, ScopeInterface::SCOPE_STORES);
    }

    /**
     * Get lead time
     * @return mixed
     */
    public function getLeadTime()
    {
        return $this->scopeConfig->getValue(self::DELIVERY_LEAD_TIME, ScopeInterface::SCOPE_STORES);
    }

    /**
     * Get maximal time
     * @return mixed
     */
    public function getMaxTime()
    {
        return $this->scopeConfig->getValue(self::DELIVERY_MAXIMAL_TIME, ScopeInterface::SCOPE_STORES);
    }
}
