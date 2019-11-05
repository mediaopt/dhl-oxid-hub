<?php

namespace Mediaopt\DHL;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\Empfaengerservices\Api\Wunschpaket as ApiWunschpaket;
use Mediaopt\Empfaengerservices\ServiceProvider\Branch;

/**
 * This class integrates the Wunschpaket class of the SDK into OXID.
 *
 * @author derksen mediaopt GmbH
 */
class Wunschpaket
{
    /**
     * @var string
     */
    const LOCATION_OPENING_TAG = '{DHL-location}';

    /**
     * @var string
     */
    const LOCATION_CLOSING_TAG = '{/DHL-location}';

    /**
     * @var string
     */
    const TIME_OPENING_TAG = '{DHL-time}';

    /**
     * @var string
     */
    const TIME_CLOSING_TAG = '{/DHL-time}';

    /**
     * @var string
     */
    const WUNSCHTAG_OPENING_TAG = '{DHL-wunschtag}';

    /**
     * @var string
     */
    const WUNSCHTAG_CLOSING_TAG = '{/DHL-wunschtag}';

    /**
     * @var string
     */
    const WUNSCHTAG_ACTIVE_FLAG = 'mo_dhl__wunschtag_active';

    /**
     * @var string
     */
    const WUNSCHZEIT_ACTIVE_FLAG = 'mo_dhl__wunschzeit_active';

    /**
     * @var string
     */
    const WUNSCHORT_ACTIVE_FLAG = 'mo_dhl__wunschort_active';

    /**
     * @var string
     */
    const WUNSCHNACHBAR_ACTIVE_FLAG = 'mo_dhl__wunschnachbar_active';

    /**
     * @var ApiWunschpaket|null
     */
    protected $wunschpaket;

    /**
     */
    public function __construct()
    {
        try {
            $adapter = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class);
            $this->wunschpaket = $adapter->buildWunschpaket()->setCutOffTime(\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__wunschtag_cutoff'))->setExcludedDaysForHandingOver($adapter->getDaysExcludedForHandingOver())->setPreparationDays($adapter->getPreparationDays());
        } catch (\RuntimeException $exception) {
        }
    }

    /**
     * @param string $zip
     * @return string[]
     */
    public function getWunschzeitOptions($zip)
    {
        $wunschpaket = $this->getWunschpaket();
        return $wunschpaket !== null ? $wunschpaket->getPreferredTimes($zip, $wunschpaket->getTransferDay()) : [];
    }

    /**
     * @return ApiWunschpaket|null
     */
    public function getWunschpaket()
    {
        return $this->wunschpaket;
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Basket $basket
     * @param string|null $zip
     * @return mixed[][]
     */
    public function getWunschtagOptions(\Mediaopt\DHL\Application\Model\Basket $basket, $zip = null)
    {
        try {
            $zip = $zip ?: $basket->moEmpfaengeservicesGetAddressedZipCode();
            $wunschpaket = $this->getWunschpaket();
            $options = $zip !== null && $wunschpaket !== null ? $wunschpaket->getPreferredDays($zip, $wunschpaket->getTransferDay()) : [];
            return $this->isWunschtagCompatibleWithEstimatedDeliveryTime($basket, $options) ? $options : [];
        } catch (\DomainException $exception) {
            \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->getLogger()->error($exception->getMessage());
            return [];
        }
    }

    /**
     * Returns the content of the supplied string without any tags injected by the Wunschpaket feature.
     *
     * @param string $remark
     * @return string
     */
    public function removeWunschpaketTags($remark)
    {
        $tags = [[self::TIME_OPENING_TAG, self::TIME_CLOSING_TAG], [self::LOCATION_OPENING_TAG, self::LOCATION_CLOSING_TAG], [self::WUNSCHTAG_OPENING_TAG, self::WUNSCHTAG_CLOSING_TAG]];
        foreach ($tags as $tag) {
            list($openingTag, $closingTag) = $tag;
            $remark = $this->removeTag($remark, $openingTag, $closingTag);
        }
        return $remark;
    }

    /**
     * @param string $remark
     * @param string $openingTag
     * @param string $closingTag
     * @return string
     */
    protected function removeTag($remark, $openingTag, $closingTag)
    {
        $boundaries = $this->findTag($remark, $openingTag, $closingTag);
        if (null === $boundaries) {
            return $remark;
        }

        list($leftBoundary, $rightBoundary) = $boundaries;
        $leftRemark = substr($remark, 0, $leftBoundary);
        $rightRemark = substr($remark, $rightBoundary + strlen($closingTag));
        return $leftRemark . $rightRemark;
    }

    /**
     * Returns the boundaries of the supplied tag, if any.
     *
     * @param string $remark
     * @param string $openingTag
     * @param string $closingTag
     * @return array|null
     */
    protected function findTag($remark, $openingTag, $closingTag)
    {
        $leftBoundary = strpos($remark, $openingTag);
        $rightBoundary = strrpos($remark, $closingTag);
        return $leftBoundary < $rightBoundary ? [$leftBoundary, $rightBoundary] : null;
    }

    /**
     * @param string $remark
     * @return bool
     */
    public function hasWunschnachbar($remark)
    {
        return $this->extractLocation($remark)[0] === ApiWunschpaket::WUNSCHNACHBAR;
    }

    /**
     * Returns the content of the location tag (as array) in the supplied string.
     *
     * The array contains always three values that represent the following information:
     * (1) the type of the location
     * (2a) in case of a preferred location: the location
     * (2b) in case of a preferred neighbour (< 2.3.0): the neighbour
     * (2c) in case of a preferred neighbour (>= 2.3.0): the address of the neighbour
     * (3a) in case of a preferred location: empty string
     * (3b) in case of a preferred neighbour (< 2.3.0): empty string
     * (3c) in case of a preferred neighbour (>= 2.3.0): the name of the neighbour
     * If the remark did not contain location information, the each element equals the empty string.
     *
     * @param string $remark
     * @return string[]
     */
    public function extractLocation($remark)
    {
        $content = $this->extractTagsContent($remark, self::LOCATION_OPENING_TAG, self::LOCATION_CLOSING_TAG);
        if (strpos($content, ':') === false) {
            return ['', '', ''];
        }
        list($type, $location) = explode(':', $content, 2);
        $information = $type === ApiWunschpaket::WUNSCHNACHBAR ? explode(';', $location, 2) : [$location];
        return $information[0] !== $location ? [$type, $information[0], $information[1]] : [$type, $location, ''];
    }

    /**
     * Returns the content of the supplied tag in the supplied string.
     *
     * @param string $remark
     * @param string $openingTag
     * @param string $closingTag
     * @return string
     */
    protected function extractTagsContent($remark, $openingTag, $closingTag)
    {
        $boundaries = $this->findTag($remark, $openingTag, $closingTag);
        if ($boundaries === null) {
            return '';
        }

        list($leftBoundary, $rightBoundary) = $boundaries;
        $locationStart = $leftBoundary + strlen($openingTag);
        $locationLength = $rightBoundary - $leftBoundary - strlen($closingTag) + 1;
        return substr($remark, $locationStart, $locationLength);
    }

    /**
     * @param string $remark
     * @return bool
     */
    public function hasWunschort($remark)
    {
        return $this->extractLocation($remark)[0] === ApiWunschpaket::WUNSCHORT;
    }

    /**
     * @param string $remark
     * @return bool
     */
    public function hasWunschzeit($remark)
    {
        return (bool) $this->extractTime($remark);
    }

    /**
     * Returns the content of the time tag in the supplied string.
     *
     * @param string $remark
     * @return string
     */
    public function extractTime($remark)
    {
        return $this->extractTagsContent($remark, self::TIME_OPENING_TAG, self::TIME_CLOSING_TAG);
    }

    /**
     * @param string $remark
     * @return bool
     */
    public function hasWunschtag($remark)
    {
        return (bool) $this->extractWunschtag($remark);
    }

    /**
     * Returns the content of the wunschtag tag in the supplied string.
     *
     * @param string $remark
     * @return string
     */
    public function extractWunschtag($remark)
    {
        return $this->extractTagsContent($remark, self::WUNSCHTAG_OPENING_TAG, self::WUNSCHTAG_CLOSING_TAG);
    }

    /**
     * @param string $wunschtag
     * @return string
     */
    public function encloseWunschtag($wunschtag)
    {
        return self::WUNSCHTAG_OPENING_TAG . $wunschtag . self::WUNSCHTAG_CLOSING_TAG;
    }

    /**
     * Returns a location enclosed in a tag.
     *
     * @param string $location
     * @return string
     */
    public function encloseLocation($location)
    {
        return self::LOCATION_OPENING_TAG . $location . self::LOCATION_CLOSING_TAG;
    }

    /**
     * Returns a time enclosed in a tag.
     *
     * @param string $time
     * @return string
     */
    public function encloseTime($time)
    {
        return self::TIME_OPENING_TAG . $time . self::TIME_CLOSING_TAG;
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isValidAccordingToBlacklist($string)
    {
        $blacklist = ['Paketbox', 'Packstation', 'Postfach', 'Postfiliale', 'Filiale', 'Postfiliale Direkt', 'Filiale Direkt', 'Paketkasten', 'DHL', 'P-A-C-K-S-T-A-T-I-O-N', 'Paketstation', 'Pack Station', 'P.A.C.K.S.T.A.T.I.O.N.', 'Pakcstation', 'Paackstation', 'Pakstation', 'Backstation', 'Bakstation', 'P A C K S T A T I O N', 'Wunschfiliale', 'Deutsche Post', '<', '>', "\n", "\r", '\\', "'", '"', '\\\\"', ';', '+'];
        foreach ($blacklist as $forbiddenString) {
            if (strpos($string, $forbiddenString) !== false) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $remark
     * @return string
     */
    public function removeWunschtagTag($remark)
    {
        return $this->removeTag($remark, self::WUNSCHTAG_OPENING_TAG, self::WUNSCHTAG_CLOSING_TAG);
    }

    /**
     * @param string $remark
     * @return string
     */
    public function removeTimeTag($remark)
    {
        return $this->removeTag($remark, self::TIME_OPENING_TAG, self::TIME_CLOSING_TAG);
    }

    /**
     * @param string $remark
     * @return string
     */
    public function removeWunschortTag($remark)
    {
        $extendedOpeningTag = self::LOCATION_OPENING_TAG . ApiWunschpaket::WUNSCHORT;
        return $this->removeTag($remark, $extendedOpeningTag, self::LOCATION_CLOSING_TAG);
    }

    /**
     * @param string $remark
     * @return string
     */
    public function removeWunschnachbarTag($remark)
    {
        $extendedOpeningTag = self::LOCATION_OPENING_TAG . ApiWunschpaket::WUNSCHNACHBAR;
        return $this->removeTag($remark, $extendedOpeningTag, self::LOCATION_CLOSING_TAG);
    }

    /**
     * @param string $remark
     * @return bool
     */
    public function hasAnyWunschpaketService($remark)
    {
        return $this->hasWunschzeit($remark) || $this->hasWunschtag($remark) || $this->hasWunschort($remark) || $this->hasWunschnachbar($remark);
    }

    /**
     * Returns true iff preferred day, time, location or neighbor is activated and can be selected.
     *
     * @param \Mediaopt\DHL\Application\Model\Basket $basket
     * @param \OxidEsales\Eshop\Application\Model\User|null $user
     * @param \OxidEsales\Eshop\Application\Model\Address|null $deliveryAddress
     * @param \OxidEsales\Eshop\Application\Model\Payment|null $payment
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function canAWunschpaketServiceBeSelected($basket = null, $user = null, $deliveryAddress = null, $payment = null)
    {
        if ($this->isAWunschpaketServiceExcluded($basket, $user, $deliveryAddress, $payment)) {
            return false;
        }
        $zip = $basket !== null ? $basket->moEmpfaengeservicesGetAddressedZipCode() : null;
        return $this->canAWunschtagBeSelected($basket) || $this->canAWunschzeitBeSelected($zip) || $this->isWunschortActive() || $this->isWunschnachbarActive();
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Basket $basket
     * @return bool
     */
    public function canAWunschtagBeSelected(\Mediaopt\DHL\Application\Model\Basket $basket)
    {
        return $this->isWunschtagActive() && $this->getWunschtagOptions($basket) !== [];
    }


    /**
     * @return bool
     */
    public function isWunschtagActive()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar(self::WUNSCHTAG_ACTIVE_FLAG);
    }

    /**
     * @param string $zip
     * @return bool
     */
    public function canAWunschzeitBeSelected($zip)
    {
        return $this->isWunschzeitActive() && $this->getWunschzeitOptions($zip) !== [];
    }

    /**
     * @return bool
     */
    public function isWunschzeitActive()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar(self::WUNSCHZEIT_ACTIVE_FLAG);
    }

    /**
     * @return bool
     */
    public function isWunschortActive()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar(self::WUNSCHORT_ACTIVE_FLAG);
    }

    /**
     * @return bool
     */
    public function isWunschnachbarActive()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar(self::WUNSCHNACHBAR_ACTIVE_FLAG);
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Basket $basket
     * @param \OxidEsales\Eshop\Application\Model\User|null $user
     * @param \OxidEsales\Eshop\Application\Model\Address|null $deliveryAddress
     * @param \OxidEsales\Eshop\Application\Model\Payment|null $payment
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function isAWunschpaketServiceExcluded($basket, $user, $deliveryAddress, $payment)
    {
        $adapter = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class);
        return $this->isExcludedDueToSendingToADhlBranch($deliveryAddress) || $this->isExcludedDueToThePaymentOption($payment) || $adapter->isExcludedDueToSendingOutsideOfGermany($user, $deliveryAddress) || !$basket->moAllowsDhlDelivery();
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Address|null $deliveryAddress
     * @return bool
     */
    protected function isExcludedDueToSendingToADhlBranch($deliveryAddress)
    {
        return is_object($deliveryAddress) && Branch::isBranch($deliveryAddress->oxaddress__oxstreet->rawValue);
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Payment|null $payment
     * @return bool
     */
    protected function isExcludedDueToThePaymentOption($payment)
    {
        return is_object($payment) && (int) $payment->oxpayments__mo_dhl_excluded->rawValue > 0;
    }

    /**
     * @param string $location
     * @return string
     * @throws \InvalidArgumentException
     */
    public function generateWunschortTag($location)
    {
        if ($location === '' || strlen($location) > 80 || !$this->isValidAccordingToBlacklist($location)) {
            throw new \InvalidArgumentException('The location is invalid.');
        }
        return $this->encloseLocation(ApiWunschpaket::WUNSCHORT . ':' . $location);
    }

    /**
     * @param string $name
     * @param string $address
     * @return string
     * @throws \InvalidArgumentException
     */
    public function generateWunschnachbarTag($name, $address)
    {
        if ($name === '' || strlen($name) > 25 || !$this->isValidAccordingToBlacklist($name)) {
            throw new \InvalidArgumentException('The name is invalid.');
        }
        if ($address === '' || strlen($address) > 55 || !$this->isValidAccordingToBlacklist($address)) {
            throw new \InvalidArgumentException('The address is invalid.');
        }
        return $this->encloseLocation(ApiWunschpaket::WUNSCHNACHBAR . ':' . $address . ';' . $name);
    }

    /**
     * @param string $submittedTime
     * @param string $zip
     * @return string
     */
    public function generateWunschzeitTag($submittedTime, $zip)
    {
        if ($submittedTime === '' || !array_key_exists($submittedTime, $this->getWunschzeitOptions($zip))) {
            throw new \InvalidArgumentException('Invalid preferred time.');
        }
        return $this->encloseTime($submittedTime);
    }

    /**
     * @param string $wunschtag
     * @param \Mediaopt\DHL\Application\Model\Basket $basket
     * @return string
     * @throws \InvalidArgumentException
     */
    public function generateWunschtagTag($wunschtag, \Mediaopt\DHL\Application\Model\Basket $basket)
    {
        if ($wunschtag === '' || !array_key_exists($wunschtag, $this->getWunschtagOptions($basket))) {
            throw new \InvalidArgumentException('Invalid preferred day.');
        }
        return $this->encloseWunschtag($wunschtag);
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Basket $basket
     * @param mixed[][] $options
     * @return bool
     */
    protected function isWunschtagCompatibleWithEstimatedDeliveryTime(\Mediaopt\DHL\Application\Model\Basket $basket, $options)
    {
        if ($options === []) {
            return false;
        }
        $firstWunschtag = clone reset($options)['datetime'];

        $estimation = $basket->moDHLEstimateDeliveryTime();
        if ($estimation === null) {
            return true;
        }
        $smallestGuaranteedDeliveryTime = $estimation[0];
        $earliestGuaranteedDelivery = (new \DateTime('now'))->modify("+{$smallestGuaranteedDeliveryTime} days");

        return $earliestGuaranteedDelivery->setTime(0, 0) <= $firstWunschtag->setTime(0, 0);
    }

    /**
     * @return mixed
     */
    public function getWunschtagSurcharge()
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__wunschtag_surcharge');
    }

    /**
     * @return mixed
     */
    public function getCombinedWunschtagAndWunschzeitSurcharge()
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__wunschtag_wunschzeit_surcharge');
    }

    /**
     * @return mixed
     */
    public function getWunschzeitSurcharge()
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__wunschzeit_surcharge');
    }
}
