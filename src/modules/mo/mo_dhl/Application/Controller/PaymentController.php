<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Application\Controller;


use Mediaopt\DHL\Model\MoDHLNotificationMode;
use OxidEsales\Eshop\Application\Model\DeliverySet;
use OxidEsales\Eshop\Core\Exception\InputException;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class PaymentController extends PaymentController_parent
{

    public function validatePayment()
    {
        $status = parent::validatePayment();
        $session = $this->getSession();
        if ($session->getVariable('payerror') || !$this->moDHLShowIdentCheckFields()) {
            return $status;
        }
        if (!($dynvalue = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('dynvalue'))) {
            $dynvalue = $session->getVariable('dynvalue');
        }
        if (!isset($dynvalue['mo_dhl_ident_check_birthday']) || !preg_match('#[0-9]{1,2}\.[0-9]{1,2}\.[12][0-9]{3}#', $dynvalue['mo_dhl_ident_check_birthday'])) {
            $this->addTplParam('mo_dhl_birthday_errors', [new InputException(Registry::getLang()->translateString('MO_DHL__BIRTHDAY_ERROR_FORMAT'))]);
            return;
        }
        $date = new \DateTime($dynvalue['mo_dhl_ident_check_birthday']);
        if ($minAge = Registry::getConfig()->getShopConfVar('mo_dhl__ident_check_min_age')) {
            $minAge = substr($minAge, 1);
            $newestAllowedBirthday = new \DateTime("-$minAge years");
            if ($date > $newestAllowedBirthday) {
                $errorMessage = sprintf(Registry::getLang()->translateString('MO_DHL__BIRTHDAY_ERROR_AGE'), $minAge);
                $this->addTplParam('mo_dhl_birthday_errors', [new InputException($errorMessage)]);
                return;
            }
        }
        return $status;
    }

    /**
     * @return bool
     */
    public function moDHLShowCheckboxForNotificationAllowance(): bool
    {
        if (MoDHLNotificationMode::ASK !== Registry::getConfig()->getShopConfVar('mo_dhl__notification_mode')) {
            return false;
        }
        $shippingId = $this->getSession()->getBasket()->getShippingId();
        $shipping = oxNew(DeliverySet::class);
        $shipping->load($shippingId);
        return !$shipping->getFieldData('MO_DHL_EXCLUDED');
    }

    public function moDHLShowIdentCheckFields() : bool
    {
        $shippingId = $this->getSession()->getBasket()->getShippingId();
        $shipping = oxNew(DeliverySet::class);
        $shipping->load($shippingId);
        return (bool) $shipping->getFieldData('MO_DHL_IDENT_CHECK');
    }

    /**
     * @return bool
     */
    public function moDHLIsNotificationAllowanceActive(): bool
    {
        $dynamicValues = $this->getSession()->getVariable('dynvalue');
        return $dynamicValues['mo_dhl_allow_notification'] ?? false;
    }

    public function moDHLGetBirthday() : string
    {
        $dynamicValues = $this->getSession()->getVariable('dynvalue');
        return $dynamicValues['mo_dhl_ident_check_birthday'] ?? '';
    }
}
