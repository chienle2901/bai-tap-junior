<?php

namespace Magenest\SpecialChapter1\Plugin\Block\Order\Create\Shipping;

/**
 * Class Address
 * @package Magenest\SpecialChapter1\Plugin\Block\Order\Create\Shipping
 */
class Address
{
    public function aroundGetChildHtml(\Magento\Sales\Block\Adminhtml\Order\Create\Data $subject, callable $proceed, $id = '', $useCache = true)
    {
        $html = $proceed($id, $useCache);
        if ($id == 'form_account') {
            $block = $subject->getLayout()
                ->createBlock('Magenest\SpecialChapter1\Block\Adminhtml\DefaultBlock')
                ->setTemplate('Magenest_SpecialChapter1::order/additional.phtml')
                ->toHtml();
            $html = $html . $block;
        }
        return $html;
    }
}
