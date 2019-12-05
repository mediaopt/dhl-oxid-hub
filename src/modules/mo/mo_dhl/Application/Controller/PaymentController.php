<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Application\Controller;


use OxidEsales\Eshop\Application\Model\DeliverySet;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class PaymentController extends PaymentController_parent
{

    public function moDHLShowCheckboxForNotificationAllowance()
    {
        if ('ASK' !== Registry::getConfig()->getShopConfVar('mo_dhl__paketankuendigung_mode')) {
            return false;
        }
        $shippingId = $this->getSession()->getBasket()->getShippingId();
        $shipping = oxNew(DeliverySet::class);
        $shipping->load($shippingId);
        return !$shipping->getFieldData('MO_DHL_EXCLUDED');
    }

    public function moDHLIsNotificationAllowanceActive()
    {
        $dynamicValues = $this->getSession()->getVariable('dynvalue');
        return $dynamicValues['mo_dhl_allow_notification'] || false;
    }
}
