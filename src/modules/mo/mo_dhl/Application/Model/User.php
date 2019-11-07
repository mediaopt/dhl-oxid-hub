<?php

namespace Mediaopt\DHL\Application\Model;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 derksen mediaopt GmbH
 */

use Mediaopt\DHL\ServiceProvider\Branch;

/** @noinspection LongInheritanceChainInspection */

/**
 * Adds validation for the PostNummer and contains the logic for checking whether to use a DHL delivery set.
 *
 * @author derksen mediaopt GmbH
 */
class User extends User_parent
{
    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * @extend
     * @param string $login
     * @param string $password
     * @param string $password2
     * @param string[] $invoiceAddress
     * @param string[] $deliveryAddress
     * @throws \Exception
     */
    public function checkValues($login, $password, $password2, $invoiceAddress, $deliveryAddress)
    {
        parent::checkValues($login, $password, $password2, $invoiceAddress, $deliveryAddress);

        /** @var \Mediaopt\DHL\Core\InputValidator|\OxidEsales\Eshop\Core\InputValidator $inputValidator */
        $inputValidator = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\InputValidator::class);
        $inputValidator->moCheckPostnummer($deliveryAddress);

        $exception = $inputValidator->getFirstValidationError();
        if ($exception !== null) {
            throw $exception;
        }
    }

    /**
     */
    public function moResetWunschpaketSelection()
    {
        if ($this->moIsAddressedToABranch()) {
            $this->moResetSelectedAddress();
        }
        if ($this->moHasSelectedAnyWunschpaketService()) {
            $this->moRemoveWunschpaketOptions();
        }
    }

    /**
     */
    protected function moResetSelectedAddress()
    {
        $this->_oSelAddress = null;
        $this->_sSelAddressId = null;
        \OxidEsales\Eshop\Core\Registry::getSession()->deleteVariable('deladrid');
    }

    /**
     */
    protected function moRemoveWunschpaketOptions()
    {
        $remark = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        $taglessRemark = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->removeWunschpaketTags($remark);
        \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('ordrem', $taglessRemark);
    }

    /**
     * @return bool
     */
    public function moIsAddressedToABranch()
    {
        $selectedAddressId = $this->getSelectedAddressId();
        if ($selectedAddressId === null) {
            return false;
        }

        $selectedAddress = \oxNew(\OxidEsales\Eshop\Application\Model\Address::class);
        $selectedAddress->load($selectedAddressId);
        return Branch::isBranch($selectedAddress->oxaddress__oxstreet->rawValue);
    }

    /**
     * @return bool
     */
    public function moHasSelectedAnyWunschpaketService()
    {
        $remark = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->hasAnyWunschpaketService($remark);
    }

    /**
     * @return bool
     */
    public function moIsForcedToUseDhlDelivery()
    {
        return $this->moHasSelectedAnyWunschpaketService() || $this->moIsAddressedToABranch();
    }

    /**
     * @param string|null $userId
     * @return \OxidEsales\Eshop\Application\Model\UserAddressList|array
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function getUserAddresses($userId = null)
    {
        /** @var \OxidEsales\Eshop\Application\Model\UserAddressList $addresses */
        $addresses = parent::getUserAddresses($userId);
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = $this->getConfig()->getSession()->getBasket();
        if ($basket->moAllowsDhlDelivery()) {
            return $addresses;
        }
        foreach ($addresses as $key => $address) {
            if (Branch::isBranch($address->oxaddress__oxstreet->rawValue)) {
                unset($addresses[$key]);
            }
        }
        return $addresses;
    }
}
