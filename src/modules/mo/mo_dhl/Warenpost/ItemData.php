<?php

namespace Mediaopt\DHL\Warenpost;

use Mediaopt\DHL\Exception\WarenpostException;

/**
 * This class represents a Content DHL Model.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class ItemData
{
    use Validator;

    /**
     * Frist line of address information of the recipient.
     * Length 1 - 30
     *
     * @var string
     */
    protected string $addressLine1;

    /**
     * Second line of address information of the recipient."
     * Length 0 - 30
     *
     * @var string|null
     */
    protected ?string $addressLine2 = null;

    /**
     * Third line of address information of the recipient."
     * Length 0 - 30
     *
     * @var string|null
     */
    protected ?string $addressLine3 = null;

    /**
     * City of the recipient address.
     * Length 1 - 30
     *
     * @var string
     */
    protected string $city;

    /**
     * The descriptions of the content pieces.
     *
     * @var array|null
     */
    protected ?array $contents = null;

    /**
     * Reference to the customer.
     * Length 0 - 28
     *
     * @var string|null
     */
    protected ?string $custRef = null;

    /**
     * Generic field to deliver input depending on the given business context.
     * E.g when using 'Internetstamp - OneClickForShop' mapped to 'UserID'.
     * Length 0 - 28
     *
     * @var string|null
     */
    protected ?string $custRef2 = null;

    /**
     * Generic field to deliver input depending on the given business context.
     * E.g when using 'Internetstamp - OneClickForShop' mapped to 'ShopOrderId'.
     * Length 0 - 28
     *
     * @var string|null
     */
    protected ?string $custRef3 = null;

    /**
     * Destination country of the item, based on ISO-3166-1.
     * Please check https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 for further details.
     * Length = 2
     *
     * @var string
     */
    protected string $destinationCountry;

    /**
     * The id of item //todo check is necessary
     *
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * Postal code of the recipient address.
     * Length = 2
     *
     * @var string|null
     */
    protected ?string $postalCode = null;

    /**
     * See Product class
     *
     * @var string
     */
    protected string $product;

    /**
     * Name of the recipient.
     * Length 1 - 30
     *
     * @var string
     */
    protected string $recipient;

    /**
     * Email address of the recipient. Used for notification.
     * Length 0 - 50
     *
     * @var string|null
     */
    protected ?string $recipientEmail = null;

    /**
     * Fax number of the recipient.
     * Length 0 - 15
     *
     * @var string|null
     */
    protected ?string $recipientFax = null;

    /**
     * Phone number of the recipient.
     * Length 0 - 15
     *
     * @var string|null
     */
    protected ?string $recipientPhone = null;

    /**
     * Is Packet Return.
     *
     * @var bool
     */
    protected bool $returnItemWanted = false;

    /**
     * Frist line of address information of the sender.
     * Length 0 - 35
     *
     * @var string|null
     */
    protected ?string $senderAddressLine1 = null;

    /**
     * Second line of address information of the sender.
     * Length 0 - 35
     *
     * @var string|null
     */
    protected ?string $senderAddressLine2 = null;

    /**
     * City of the sender address.
     * Length 0 - 40
     *
     * @var string|null
     */
    protected ?string $senderCity = null;

    /**
     * Sender country of the item, based on ISO-3166-1.
     * Please check https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 for further details.
     * Length = 2
     *
     * @var string|null
     */
    protected ?string $senderCountry = null;

    /**
     * Email address of the sender. Used for notification.
     * Length 0 - 50
     *
     * @var string|null
     */
    protected ?string $senderEmail = null;

    /**
     * Name of the sender.
     * Length 0 - 40
     *
     * @var string|null
     */
    protected ?string $senderName = null;

    /**
     * Phone number of the sender.
     * Length 0 - 50
     *
     * @var string|null
     */
    protected ?string $senderPhone = null;

    /**
     * Postal code of the sender address.
     * Length 0 - 20
     *
     * @var string|null
     */
    protected ?string $senderPostalCode = null;

    /**
     * See ServiceLevel class
     *
     * @var string|null
     */
    protected ?string $serviceLevel = null;

    /**
     * Overall value of all content pieces of the item.
     *
     * @var float|null
     */
    protected ?float $shipmentAmount = null;

    /**
     * Currency code of the value, based on ISO-4217.
     * Please check https://en.wikipedia.org/wiki/ISO_4217#Active_codes for further details.
     * Length = 3
     *
     * @var string|null
     */
    protected ?string $shipmentCurrency = null;

    /**
     * Gross weight of the item (in g). May not exceed 2000 g.
     * Range 1 - 2000
     *
     * @var int
     */
    protected int $shipmentGrossWeight;

    /**
     * Nature of the pieces in this item, based on UPU code list 136.
     * SALE_GOODS, RETURN_GOODS, GIFT, COMMERCIAL_SAMPLE, DOCUMENTS, MIXED_CONTENTS, OTHERS
     *
     * @var string|null
     */
    protected ?string $shipmentNaturetype = null;

    /**
     * State of the recipient address.
     *
     * @var string|null
     */
    protected ?string $state = null;

    /**
     * ItemData constructor.
     * @param string $product
     * @param string $recipient
     * @param string $addressLine1
     * @param string $city
     * @param string $destinationCountry
     * @param string $shipmentGrossWeight
     */
    public function __construct(string $product, string $recipient, string $addressLine1, string $city, string $destinationCountry, string $shipmentGrossWeight)
    {
        $this->product = $product;
        $this->recipient = $recipient;
        $this->addressLine1 = $addressLine1;
        $this->city = $city;
        $this->destinationCountry = $destinationCountry;
        $this->shipmentGrossWeight = $shipmentGrossWeight;
    }

    /**
     * @param string $addressLine2
     */
    public function setAddressLine2(string $addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @param string $addressLine3
     */
    public function setAddressLine3(string $addressLine3)
    {
        $this->addressLine3 = $addressLine3;
    }

    /**
     * @param array $contents
     */
    public function setContents(array $contents)
    {
        $this->contents = $contents;
    }

    /**
     * @param string $custRef
     */
    public function setCustRef(string $custRef)
    {
        $this->custRef = $custRef;
    }

    /**
     * @param string $custRef2
     */
    public function setCustRef2(string $custRef2)
    {
        $this->custRef2 = $custRef2;
    }

    /**
     * @param string $custRef3
     */
    public function setCustRef3(string $custRef3)
    {
        $this->custRef3 = $custRef3;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @param string $recipientEmail
     */
    public function setRecipientEmail(string $recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * @param string $recipientFax
     */
    public function setRecipientFax(string $recipientFax)
    {
        $this->recipientFax = $recipientFax;
    }

    /**
     * @param string $recipientPhone
     */
    public function setRecipientPhone(string $recipientPhone)
    {
        $this->recipientPhone = $recipientPhone;
    }

    /**
     * @param bool $returnItemWanted
     */
    public function setReturnItemWanted(bool $returnItemWanted)
    {
        $this->returnItemWanted = $returnItemWanted;
    }

    /**
     * @param string $senderAddressLine1
     */
    public function setSenderAddressLine1(string $senderAddressLine1)
    {
        $this->senderAddressLine1 = $senderAddressLine1;
    }

    /**
     * @param string $senderAddressLine2
     */
    public function setSenderAddressLine2(string $senderAddressLine2)
    {
        $this->senderAddressLine2 = $senderAddressLine2;
    }

    /**
     * @param string $senderCity
     */
    public function setSenderCity(string $senderCity)
    {
        $this->senderCity = $senderCity;
    }

    /**
     * @param string $senderCountry
     */
    public function setSenderCountry(string $senderCountry)
    {
        $this->senderCountry = $senderCountry;
    }

    /**
     * @param string $senderEmail
     */
    public function setSenderEmail(string $senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @param string $senderName
     */
    public function setSenderName(string $senderName)
    {
        $this->senderName = $senderName;
    }

    /**
     * @param string $senderPhone
     */
    public function setSenderPhone(string $senderPhone)
    {
        $this->senderPhone = $senderPhone;
    }

    /**
     * @param string $senderPostalCode
     */
    public function setSenderPostalCode(string $senderPostalCode)
    {
        $this->senderPostalCode = $senderPostalCode;
    }

    /**
     * @param string $serviceLevel
     */
    public function setServiceLevel(string $serviceLevel)
    {
        $this->serviceLevel = $serviceLevel;
    }

    /**
     * @param float $shipmentAmount
     */
    public function setShipmentAmount(float $shipmentAmount)
    {
        $this->shipmentAmount = $shipmentAmount;
    }

    /**
     * @param string $shipmentCurrency
     */
    public function setShipmentCurrency(string $shipmentCurrency)
    {
        $this->shipmentCurrency = $shipmentCurrency;
    }

    /**
     * @param string $shipmentNaturetype
     */
    public function setShipmentNaturetype(string $shipmentNaturetype)
    {
        $this->shipmentNaturetype = $shipmentNaturetype;
    }

    /**
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    //todo do we need getteres at all?

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        //Basic fields validation
        $errorMessage = implode(' ,', array_merge(
            $this->isEnumFieldCorrect('product', $this->product, Product::$PRODUCTS),
            $this->isStringFieldCorrect('recipient', $this->recipient, 1, 30, true),
            $this->isStringFieldCorrect('addressLine1', $this->addressLine1, 1, 30, true),
            $this->isStringFieldCorrect('city', $this->city, 1, 30, true),
            $this->isStringFieldCorrect('destinationCountry', $this->destinationCountry, 2, null, true),
            $this->isIntFieldCorrect('shipmentGrossWeight', $this->shipmentGrossWeight, 1, 2000, true),
            $this->isStringFieldCorrect('addressLine2', $this->addressLine2, 0, 30),
            $this->isStringFieldCorrect('addressLine3', $this->addressLine3, 0, 30),
            $this->isStringFieldCorrect('custRef', $this->custRef, 0, 28),
            $this->isStringFieldCorrect('custRef2', $this->custRef2, 0, 28),
            $this->isStringFieldCorrect('custRef3', $this->custRef3, 0, 28),
            $this->isStringFieldCorrect('postalCode', $this->postalCode, 0, 20),
            $this->isStringFieldCorrect('recipientEmail', $this->recipientEmail, 0, 50),
            $this->isStringFieldCorrect('recipientFax', $this->recipientFax, 0, 15),
            $this->isStringFieldCorrect('recipientPhone', $this->recipientPhone, 0, 15),
            $this->isStringFieldCorrect('senderAddressLine1', $this->senderAddressLine1, 0, 35),
            $this->isStringFieldCorrect('senderAddressLine2', $this->senderAddressLine2, 0, 35),
            $this->isStringFieldCorrect('senderCity', $this->senderCity, 0, 40),
            $this->isStringFieldCorrect('senderCountry', $this->senderCountry, 2),
            $this->isStringFieldCorrect('senderEmail', $this->senderEmail, 0, 50),
            $this->isStringFieldCorrect('senderName', $this->senderName, 0, 40),
            $this->isStringFieldCorrect('senderPhone', $this->senderPhone, 0, 50),
            $this->isStringFieldCorrect('senderPostalCode', $this->senderPostalCode, 0, 20),
            $this->isEnumFieldCorrect('serviceLevel', $this->serviceLevel, ServiceLevel::$SERVICE_LEVELS),
            $this->isStringFieldCorrect('shipmentCurrency', $this->shipmentCurrency, 3),
            $this->isEnumFieldCorrect('shipmentNaturetype', $this->shipmentNaturetype, ShipmentNatureType::$TYPES),
            $this->isStringFieldCorrect('state', $this->state, 0, 20)
        ));

        //Additional fields validation
        if (empty($errorMessage) && !empty($this->serviceLevel)) {
            $errorMessage = $this->isProductCorrectForServiceLevel($this->product, $this->serviceLevel);
        }

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage;
        throw new WarenpostException($message, WarenpostException::ITEM_DATA_VALIDATION_ERROR);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'product' => $this->product,
            'recipient' => $this->recipient,
            'addressLine1' => $this->addressLine1,
            'city' => $this->city,
            'destinationCountry' => $this->destinationCountry,
            'shipmentGrossWeight' => $this->shipmentGrossWeight,
        ];

        $unrequiredFields = [
            'addressLine2',
            'addressLine3',
            'contents',
            'custRef',
            'custRef2',
            'custRef3',
            'id',
            'postalCode',
            'recipientEmail',
            'recipientFax',
            'recipientPhone',
            'returnItemWanted',
            'senderAddressLine1',
            'senderAddressLine2',
            'senderCity',
            'senderCountry',
            'senderEmail',
            'senderName',
            'senderPhone',
            'senderPostalCode',
            'serviceLevel',
            'shipmentAmount',
            'shipmentCurrency',
            'shipmentNaturetype',
            'state',
        ];

        foreach ($unrequiredFields as $field) {
            if ($this->$field !== null) {
                $array[$field] = $this->$field;
            }
        }

        return $array;
    }
}