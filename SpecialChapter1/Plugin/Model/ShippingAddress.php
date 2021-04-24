<?php

namespace Magenest\SpecialChapter1\Plugin\Model;

use Magento\Quote\Model\ShippingAddressManagement;

/**
 * Class ShippingAddress
 * @package Magenest\SpecialChapter1\Plugin\Model
 */
class ShippingAddress
{
    /**
     * Set delivery value
     */
    public function beforeAssign(ShippingAddressManagement $subject, $cartId, \Magento\Quote\Api\Data\AddressInterface $address) {
        $extAttributes = $address->getExtensionAttributes();
        $address->setDeliveryDate($extAttributes->getDeliveryDate());
        $address->setDeliveryTime($extAttributes->getDeliveryTime());
        $address->setComment($extAttributes->getComment());
        return [$cartId, $address];
    }
}
