<?php

namespace Mediaopt\DHL\Api\Warenpost;

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
     * @var int
     */
    const ADDRESS_LINE_LENGTH_MAX = 40;

    /**
     * @var int
     */
    const CITY_LENGTH_MAX = 30;

    /**
     * @var int
     */
    const CUST_REF_LENGTH_MAX = 20;

    /**
     * @var int
     */
    const COUNTRY_LENGTH = 2;

    /**
     * @var int
     */
    const TAX_ID_LENGTH_MAX = 35;

    /**
     * @var int
     */
    const POSTAL_CODE_LENGTH_MIN = 3;

    /**
     * @var int
     */
    const POSTAL_CODE_LENGTH_MAX = 13;

    /**
     * @var int
     */
    const NAME_LENGTH_MAX = 30;

    /**
     * @var int
     */
    const EMAIL_LENGTH_MAX = 50;

    /**
     * @var int
     */
    const FAX_LENGTH_MAX = 15;

    /**
     * @var int
     */
    const PHONE_LENGTH_MAX = 50;

    /**
     * @var int
     */
    const CURRENCY_LENGTH = 3;

    /**
     * @var int
     */
    const WEIGHT_MIN = 1;

    /**
     * @var int
     */
    const WEIGHT_MAX = 2000;

    /**
     * @var int
     */
    const STATE_LENGTH_MAX = 20;

    /**
     * First line with the recipient’s address details.
     * Length 0 - 40
     *
     * @var string
     */
    protected $addressLine1;

    /**
     * Second line with the recipient’s address details.
     * Length 0 - 40
     *
     * @var string|null
     */
    protected $addressLine2 = null;

    /**
     * Third line with the recipient’s address details.
     * Length 0 - 40
     *
     * @var string|null
     */
    protected $addressLine3 = null;

    /**
     * City of the recipient address.
     * Length 0 - 30
     *
     * @var string
     */
    protected $city;

    /**
     * The descriptions of the content pieces.
     * See Content class
     *
     * @var array|null
     */
    protected $contents = null;

    /**
     * Customer reference (not yet enabled for Warenpost)
     * Length 0 - 20
     *
     * @var string|null
     */
    protected $custRef = null;

    /**
     * Destination country of the item, based on ISO-3166-1.
     * Please check https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 for further details.
     * Length = 2
     *
     * @var string
     */
    protected $destinationCountry;

    /**
     * Item ID set by the system, relevant to subsequent requests
     *
     * @var int|null
     */
    protected $id = null;

    /**
     * Importer customs/tax ID
     * if present, appears on Item Label (each sender and recipient block).
     * Expected by some countries, e.g. Norway
     * Length 0-35
     *
     * @var string|null
     */
    protected $importerTaxId = null;

    /**
     * Postal code of the recipient address.
     * Length 3 - 13
     *
     * @var string|null
     */
    protected $postalCode = null;

    /**
     * Product number in accordance with PPL
     * See Product class
     *
     * @var string
     */
    protected $product;

    /**
     * Name of the recipient.
     * Length 0 - 30
     *
     * @var string
     */
    protected $recipient;

    /**
     * Recipient’s e-mail address
     * Length 0 - 50
     *
     * @var string|null
     */
    protected $recipientEmail = null;

    /**
     * Recipient’s fax number
     * Length 0 - 15
     *
     * @var string|null
     */
    protected $recipientFax = null;

    /**
     * Recipient’s telephone number
     * Length 0 - 50
     *
     * @var string|null
     */
    protected $recipientPhone = null;

    /**
     * A return label is to be generated.
     * Not yet available for Warenpost International.
     *
     * @var bool
     */
    protected $returnItemWanted = false;

    /**
     * First line with the sender’s address details
     * Length 0 - 40
     *
     * @var string
     */
    protected $senderAddressLine1;

    /**
     * Second line with the sender’s address details
     * Length 0 - 40
     *
     * @var string|null
     */
    protected $senderAddressLine2 = null;

    /**
     * Third line with the sender’s address details
     * Length 0 - 40
     *
     * @var string|null
     */
    protected $senderAddressLine3 = null;

    /**
     * City of the sender address.
     * Length 0 - 30
     *
     * @var string|null
     */
    protected $senderCity = null;

    /**
     * Country of origin of the article, based upon ISO-3166-1.
     * Please check https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 for further details.
     * Length = 2
     *
     * @var string|null
     */
    protected $senderCountry = null;

    /**
     * Sender’s e-mail address. Used for notification purposes
     * Length 0 - 50
     *
     * @var string|null
     */
    protected $senderEmail = null;

    /**
     * Name of the sender.
     * Length 0 - 30
     *
     * @var string
     */
    protected $senderName;

    /**
     * Sender’s telephone number.
     * Length 0 - 50
     *
     * @var string|null
     */
    protected $senderPhone = null;

    /**
     * "sender customs/tax ID
     * if present, appears on Item Label (each sender and recipient block)
     * Length 0 - 35
     *
     * @var string|null
     */
    protected $senderTaxId = null;

    /**
     * Postal code of the sender address.
     * Length 3 - 13
     *
     * @var string
     */
    protected $senderPostalCode;

    /**
     * The service level used for sending this article.
     * Currently notyet enabled for Warenpost.
     * STANDARD, no alternative for Warenpost
     * See ServiceLevel class
     *
     * @var string
     */
    protected $serviceLevel = ServiceLevel::STANDARD;

    /**
     * Total value of all items included with the article.
     *
     * @var int|null
     */
    protected $shipmentAmount = null;

    /**
     * Currency code of the value, based on ISO-4217.
     * Please check https://en.wikipedia.org/wiki/ISO_4217#Active_codes for further details.
     * Length = 3
     *
     * @var string|null
     */
    protected $shipmentCurrency = null;

    /**
     * Gross weight of the item (in g). May not exceed 2000 g.
     * Range 1 - 2000
     *
     * @var int
     */
    protected $shipmentGrossWeight;

    /**
     * Nature of the pieces in this item, based on UPU code list 136.
     * See ShipmentNaturetype class.
     *
     * @var string
     */
    protected $shipmentNaturetype;

    /**
     * Additional information in the recipient’s address.
     * Length 0 - 20
     *
     * @var string|null
     */
    protected $state = null;

    /**
     * ItemData constructor.
     * @param string $product
     * @param string $recipient
     * @param string $addressLine1
     * @param string $postalCode
     * @param string $city
     * @param string $destinationCountry
     * @param string $senderName
     * @param string $senderAddressLine1
     * @param string $senderPostalCode
     * @param string $senderCity
     * @param string $senderCountry
     * @param string $shipmentNaturetype
     * @param int $shipmentGrossWeight
     */
    public function __construct(
        string $product,
        string $recipient,
        string $addressLine1,
        string $postalCode,
        string $city,
        string $destinationCountry,
        string $senderName,
        string $senderAddressLine1,
        string $senderPostalCode,
        string $senderCity,
        string $senderCountry,
        string $shipmentNaturetype,
        int $shipmentGrossWeight
    )
    {
        $this->product = $product;
        $this->recipient = $recipient;
        $this->addressLine1 = $addressLine1;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->destinationCountry = $destinationCountry;
        $this->shipmentGrossWeight = $shipmentGrossWeight;
        $this->senderName = $senderName;
        $this->senderAddressLine1 = $senderAddressLine1;
        $this->senderPostalCode = $senderPostalCode;
        $this->senderCity = $senderCity;
        $this->senderCountry = $senderCountry;
        $this->shipmentNaturetype = $shipmentNaturetype;
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
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $importerTaxId
     */
    public function setImporterTaxId(string $importerTaxId)
    {
        $this->importerTaxId = $importerTaxId;
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
     * @param string $senderAddressLine2
     */
    public function setSenderAddressLine2(string $senderAddressLine2)
    {
        $this->senderAddressLine2 = $senderAddressLine2;
    }

    /**
     * @param string $senderAddressLine3
     */
    public function setSenderAddressLine3(string $senderAddressLine3)
    {
        $this->senderAddressLine3 = $senderAddressLine3;
    }

    /**
     * @param string $senderEmail
     */
    public function setSenderEmail(string $senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @param string $senderPhone
     */
    public function setSenderPhone(string $senderPhone)
    {
        $this->senderPhone = $senderPhone;
    }

    /**
     * @param string $senderTaxId
     */
    public function setSenderTaxId(string $senderTaxId)
    {
        $this->senderTaxId = $senderTaxId;
    }

    /**
     * @param int $shipmentAmount
     */
    public function setShipmentAmount(int $shipmentAmount)
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
     * @param string $state
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    /**
     * @return string|null
     */
    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    /**
     * @return string|null
     */
    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return array|null
     */
    public function getContents(): ?array
    {
        return $this->contents;
    }

    /**
     * @return string|null
     */
    public function getCustRef(): ?string
    {
        return $this->custRef;
    }

    /**
     * @return string
     */
    public function getDestinationCountry(): string
    {
        return $this->destinationCountry;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getImporterTaxId(): ?string
    {
        return $this->importerTaxId;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return string|null
     */
    public function getRecipientEmail(): ?string
    {
        return $this->recipientEmail;
    }

    /**
     * @return string|null
     */
    public function getRecipientFax(): ?string
    {
        return $this->recipientFax;
    }

    /**
     * @return string|null
     */
    public function getRecipientPhone(): ?string
    {
        return $this->recipientPhone;
    }

    /**
     * @return bool
     */
    public function getReturnItemWanted(): bool
    {
        return $this->returnItemWanted;
    }

    /**
     * @return string
     */
    public function getSenderAddressLine1(): string
    {
        return $this->senderAddressLine1;
    }

    /**
     * @return string|null
     */
    public function getSenderAddressLine2(): ?string
    {
        return $this->senderAddressLine2;
    }

    /**
     * @return string|null
     */
    public function getSenderAddressLine3(): ?string
    {
        return $this->senderAddressLine3;
    }

    /**
     * @return string|null
     */
    public function getSenderCity(): ?string
    {
        return $this->senderCity;
    }

    /**
     * @return string|null
     */
    public function getSenderCountry(): ?string
    {
        return $this->senderCountry;
    }

    /**
     * @return string|null
     */
    public function getSenderEmail(): ?string
    {
        return $this->senderEmail;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @return string|null
     */
    public function getSenderPhone(): ?string
    {
        return $this->senderPhone;
    }

    /**
     * @return string
     */
    public function getSenderPostalCode(): string
    {
        return $this->senderPostalCode;
    }

    /**
     * @return string|null
     */
    public function getSenderTaxId(): ?string
    {
        return $this->senderTaxId;
    }

    /**
     * @return string
     */
    public function getServiceLevel(): string
    {
        return $this->serviceLevel;
    }

    /**
     * @return int|null
     */
    public function getShipmentAmount(): ?float
    {
        return $this->shipmentAmount;
    }

    /**
     * @return string|null
     */
    public function getShipmentCurrency(): ?string
    {
        return $this->shipmentCurrency;
    }

    /**
     * @return int
     */
    public function getShipmentGrossWeight(): int
    {
        return $this->shipmentGrossWeight;
    }

    /**
     * @return string
     */
    public function getShipmentNaturetype(): string
    {
        return $this->shipmentNaturetype;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        //Basic fields validation
        $errorMessage = implode(' ,', array_merge(
            $this->isStringFieldCorrect('addressLine1', $this->addressLine1, 0, self::ADDRESS_LINE_LENGTH_MAX, true),
            $this->isStringFieldCorrect('addressLine2', $this->addressLine2, 0, self::ADDRESS_LINE_LENGTH_MAX),
            $this->isStringFieldCorrect('addressLine3', $this->addressLine3, 0, self::ADDRESS_LINE_LENGTH_MAX),
            $this->isStringFieldCorrect('city', $this->city, 1, self::CITY_LENGTH_MAX, true),
            $this->isStringFieldCorrect('custRef', $this->custRef, 0, self::CUST_REF_LENGTH_MAX),
            $this->isStringFieldCorrect('destinationCountry', $this->destinationCountry, self::COUNTRY_LENGTH, null, true),
            $this->isStringFieldCorrect('importerTaxId', $this->importerTaxId, 0, self::TAX_ID_LENGTH_MAX),
            $this->isStringFieldCorrect('postalCode', $this->postalCode, self::POSTAL_CODE_LENGTH_MIN, self::POSTAL_CODE_LENGTH_MAX, true),
            $this->isStringFieldCorrect('recipient', $this->recipient, 0, self::NAME_LENGTH_MAX, true),
            $this->isStringFieldCorrect('recipientEmail', $this->recipientEmail, 0, self::EMAIL_LENGTH_MAX),
            $this->isStringFieldCorrect('recipientFax', $this->recipientFax, 0, self::FAX_LENGTH_MAX),
            $this->isStringFieldCorrect('recipientPhone', $this->recipientPhone, 0, self::PHONE_LENGTH_MAX),
            $this->isStringFieldCorrect('senderAddressLine1', $this->senderAddressLine1, 0, self::ADDRESS_LINE_LENGTH_MAX, true),
            $this->isStringFieldCorrect('senderAddressLine2', $this->senderAddressLine2, 0, self::ADDRESS_LINE_LENGTH_MAX),
            $this->isStringFieldCorrect('senderAddressLine3', $this->senderAddressLine3, 0, self::ADDRESS_LINE_LENGTH_MAX),
            $this->isStringFieldCorrect('senderCity', $this->senderCity, 0, self::CITY_LENGTH_MAX, true),
            $this->isStringFieldCorrect('senderCountry', $this->senderCountry, self::COUNTRY_LENGTH, null, true),
            $this->isStringFieldCorrect('senderEmail', $this->senderEmail, 0, self::EMAIL_LENGTH_MAX),
            $this->isStringFieldCorrect('senderName', $this->senderName, 0, self::NAME_LENGTH_MAX, true),
            $this->isStringFieldCorrect('senderPhone', $this->senderPhone, 0, self::PHONE_LENGTH_MAX),
            $this->isStringFieldCorrect('senderTaxId', $this->senderTaxId, 0, self::TAX_ID_LENGTH_MAX),
            $this->isStringFieldCorrect('senderPostalCode', $this->senderPostalCode, self::POSTAL_CODE_LENGTH_MIN, self::POSTAL_CODE_LENGTH_MAX, true),
            $this->isStringFieldCorrect('shipmentCurrency', $this->shipmentCurrency, self::CURRENCY_LENGTH),
            $this->isIntFieldCorrect('shipmentGrossWeight', $this->shipmentGrossWeight, self::WEIGHT_MIN, self::WEIGHT_MAX, true),
            $this->isEnumFieldCorrect('shipmentNaturetype', $this->shipmentNaturetype, ShipmentNatureType::$TYPES, true),
            $this->isStringFieldCorrect('state', $this->state, 0, self::STATE_LENGTH_MAX)
        ));

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
            'postalCode' => $this->postalCode,
            'city' => $this->city,
            'destinationCountry' => $this->destinationCountry,
            'senderName' => $this->senderName,
            'senderAddressLine1' => $this->senderAddressLine1,
            'senderPostalCode' => $this->senderPostalCode,
            'senderCity' => $this->senderCity,
            'senderCountry' => $this->senderCountry,
            'shipmentNaturetype' => $this->shipmentNaturetype,
            'shipmentGrossWeight' => $this->shipmentGrossWeight,
            'serviceLevel' => $this->serviceLevel,
        ];

        $unrequiredFields = [
            'addressLine2',
            'addressLine3',
            'contents',
            'custRef',
            'id',
            'importerTaxId',
            'recipientEmail',
            'recipientFax',
            'recipientPhone',
            'returnItemWanted',
            'senderAddressLine2',
            'senderAddressLine3',
            'senderEmail',
            'senderPhone',
            'senderTaxId',
            'shipmentAmount',
            'shipmentCurrency',
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