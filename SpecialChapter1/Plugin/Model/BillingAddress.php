<?php

namespace Magenest\SpecialChapter1\Plugin\Model;

/**
 * Class BillingAddress
 * @package Magenest\SpecialChapter1\Plugin\Model
 */
class BillingAddress
{
    /**
     * @param $cartId
     * @param \Magento\Quote\Api\Data\AddressInterface $address
     * @param bool $useForShipping
     * @return array
     */
    public function beforeAssign($cartId, \Magento\Quote\Api\Data\AddressInterface $address, $useForShipping = false)
    {
        $extAttributes = $address->getExtensionAttributes();
        $address->setDeliveryDate($extAttributes->getDeliveryDate());
        $address->setDeliveryTime($extAttributes->getDeliveryTime());
        $address->setComment($extAttributes->getComment());
        return [$cartId, $address, $useForShipping];
    }
}
