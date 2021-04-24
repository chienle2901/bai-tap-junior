<?php

namespace Magenest\SpecialChapter1\Block\Adminhtml\Config;

/**
 * Class DeliverySameDay
 * @package Magenest\SpecialChapter1\Block\Adminhtml\Config
 */
class DeliverySameDay extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var \Magenest\SpecialChapter1\Helper\Config
     */
    protected $helperConfig;

    /**
     * DeliverySameDay constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magenest\SpecialChapter1\Helper\Config $helperConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magenest\SpecialChapter1\Helper\Config $helperConfig,
        array $data = []
    ) {
        $this->helperConfig = $helperConfig;
        parent::__construct($context, $data);
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
        $hour = $this->helperConfig->getDisableSamDayHour();
        $minute = $this->helperConfig->getDisableSamDayMinute();
        $html = '<div style="display: flex; align-items: center;">';
        $html .= '<select name="groups[configuration][fields][disable_same_day_delivery_hour][value]" style="width: 20%">';
        $startHour = 0;
        do {
            if (strlen($startHour) == 1) {
                $startHour = 0 .$startHour;
            }
            if ($startHour == $hour) {
                $html .= '<option value="'.$startHour.'" selected>'.$startHour.'</option>';
            } else {
                $html .= '<option value="'.$startHour.'">'.$startHour.'</option>';
            }
            $startHour++;
        } while ($startHour <= 23);
        $html .= '</select>';
        $html .= "<span style='margin: 0 10px;'> : </span>";
        $html .= '<select name="groups[configuration][fields][disable_same_day_delivery_minute][value]" style="width: 20%">';
        $startMinute = 0;
        do {
            if (strlen($startMinute) == 1) {
                $startMinute = 0 .$startMinute;
            }
            if ($startMinute == $minute) {
                $html .= '<option value="'.$startMinute.'" selected>'.$startMinute.'</option>';
            } else {
                $html .= '<option value="'.$startMinute.'">'.$startMinute.'</option>';
            }
            $startMinute++;
        } while ($startMinute <= 59);
        $html .= '</select>';
        $html .= "<span style='margin-left: 20px;'> Hour : Minute </span>";
        $html .= '</div>';
        return $html;
    }
}
