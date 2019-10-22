<?php

namespace Mediaopt\DHL\Application\Model;

/**
 * @author derksen mediaopt GmbH
 */
class PaymentList extends PaymentList_parent
{
    /**
     * @param string $shippingSetId
     * @param float $price
     * @param \Mediaopt\DHL\Application\Model\User|null $user
     * @return array
     */
    public function getPaymentList($shippingSetId, $price, $user = null)
    {
        /** @var \OxidEsales\Eshop\Application\Model\Payment[] $payments */
        $payments = (array) parent::getPaymentList($shippingSetId, $price, $user);
        if ($user && !$user->moIsForcedToUseDhlDelivery()) {
            return $payments;
        }

        foreach ($payments as $index => $payment) {
            if ((int) $payment->oxpayments__mo_empfaengerservices_excluded->rawValue > 0) {
                unset($payments[$index]);
            }
        }

        return $payments;
    }
}
