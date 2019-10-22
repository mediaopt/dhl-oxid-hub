<?php
namespace Mediaopt\DHL\Core;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 * 
 * @copyright 2017 derksen mediaopt GmbH
 */

/** @noinspection LongInheritanceChainInspection */

/**
 * Adds validation for a Postnummer.
 * 
 * @author derksen mediaopt GmbH
 */
class InputValidator extends InputValidator_parent
{
    /**
     * @param array $deliveryAddress
     */
    public function moCheckPostnummer(array $deliveryAddress)
    {
        $serviceProviderTypeOrStreet = $deliveryAddress['oxaddress__oxstreet'];
        $postnummer = $deliveryAddress['oxaddress__oxaddinfo'];

        if (!in_array(strtolower($serviceProviderTypeOrStreet), ['packstation', 'postfiliale', 'paketshop'], true)) {
            return;
        }
        if (empty($postnummer) && strtolower($serviceProviderTypeOrStreet) !== 'packstation') {
            return;
        }
        if (is_numeric($postnummer) && strlen($postnummer) >= 6) {
            return;
        }

        $message = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MO_EMPFAENGERSERVICES__ERROR_POSTNUMMER_MALFORMED');
        $exception = \oxNew(\OxidEsales\Eshop\Core\Exception\InputException::class, $message);
        $this->_addValidationError('oxaddress__oxaddinfo', $exception);
    }
}
