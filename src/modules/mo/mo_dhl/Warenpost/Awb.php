<?php

namespace Mediaopt\DHL\Warenpost;

use Mediaopt\DHL\Exception\WarenpostException;

/**
 * This class represents an Awb DHL Model.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Awb
{
    use Validator;

    /**
     * @var string
     */
    const ITEM_FORMAT_P = 'P';

    /**
     * @var string
     */
    const ITEM_FORMAT_G = 'G';

    /**
     * @var string
     */
    const ITEM_FORMAT_E = 'E';

    /**
     * @var string
     */
    const ITEM_FORMAT_MIXED = 'MIXED';

    /**
     * Array containing all item formats.
     *
     * @var string[]
     */
    public static $ITEM_FORMATS = [
        self::ITEM_FORMAT_P,
        self::ITEM_FORMAT_G,
        self::ITEM_FORMAT_E,
        self::ITEM_FORMAT_MIXED,
    ];

    /**
     * @var int
     */
    const AWB_COPY_COUNT_MIN = 1;

    /**
     * @var int
     */
    const AWB_COPY_COUNT_MAX = 50;

    /**
     * @var int
     */
    const AWB_CONTACT_NAME_MIN_LENGTH = 1;

    /**
     * @var int
     */
    const AWB_CONTACT_NAME_MAX_LENGTH = 40;

    /**
     * @var int
     */
    const AWB_JOB_REFERENCE_MIN_LENGTH = 0;

    /**
     * @var int
     */
    const AWB_JOB_REFERENCE_MAX_LENGTH = 17;

    /**
     * Copies of AWB labels.
     * Min = 1, Max = 50
     *
     * @var int
     */
    protected $awbCopyCount;

    /**
     * Contact name for paperwork.
     * MinLength = 1, MaxLength = 40
     *
     * @var string
     */
    protected $contactName;

    /**
     * Deutsche Post Customer Account number (EKP) of the customer who wants to create an single awb.
     *
     * @var string
     */
    protected $customerEkp;

    /**
     * The item format for this awb.
     *
     * @var string
     */
    protected $itemFormat;

    /**
     * Job reference for paperwork.
     *
     * @var string
     */
    protected $jobReference;

    /**
     * See Product class
     *
     * @var string
     */
    protected $product;

    /**
     * See ServiceLevel class
     *
     * @var string
     */
    protected $serviceLevel;

    /**
     * Telephone number for paperwork.
     *
     * @var string
     */
    protected $telephoneNumber;

    /**
     * @param string $customerEkp
     * @param string $contactName
     * @param int $awbCopyCount
     * @param string $product
     * @param string $serviceLevel
     * @param string $itemFormat
     * @param string|null $jobReference
     * @param float|null $totalWeight
     * @param string|null $telephoneNumber
     */
    public function __construct(
        string $customerEkp,
        string $contactName,
        int $awbCopyCount,
        string $product,
        string $serviceLevel,
        string $itemFormat,
        $jobReference = null,
        $totalWeight = null,
        $telephoneNumber = null
    )
    {
        $this->customerEkp = $customerEkp;
        $this->contactName = $contactName;
        $this->awbCopyCount = $awbCopyCount;
        $this->product = $product;
        $this->serviceLevel = $serviceLevel;
        $this->itemFormat = $itemFormat;
        $this->jobReference = $jobReference;
        $this->totalWeight = $totalWeight;
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * Total weight of the awb (in kg).
     *
     * @var double
     */
    protected $totalWeight;

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        //Basic fields validation
        $errorMessages = array_merge(
            $this->isIntFieldCorrect('awbCopyCount', $this->awbCopyCount, self::AWB_COPY_COUNT_MIN, self::AWB_COPY_COUNT_MAX, true),
            $this->isStringFieldCorrect('contactName', $this->contactName, self::AWB_CONTACT_NAME_MIN_LENGTH, self::AWB_CONTACT_NAME_MAX_LENGTH, true),
            $this->isEnumFieldCorrect('itemFormat', $this->itemFormat, static::$ITEM_FORMATS, true),
            $this->isStringFieldCorrect('jobReference', $this->jobReference, self::AWB_JOB_REFERENCE_MIN_LENGTH, self::AWB_JOB_REFERENCE_MAX_LENGTH),
            $this->isEnumFieldCorrect('product', $this->product, Product::$PRODUCTS),
            $this->isEnumFieldCorrect('serviceLevel', $this->serviceLevel, ServiceLevel::$SERVICE_LEVELS)
        );
        $errorMessage = implode(', ', $errorMessages);

        //Additional fields validation
        if (empty($errorMessage)) {
            $errorMessages = array_merge(
                $this->isProductCorrectForServiceLevel($this->product, $this->serviceLevel)
            );
            $errorMessage = implode(', ', $errorMessages);
        }

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage;
        throw new WarenpostException($message, WarenpostException::AWB_VALIDATION_ERROR);
    }

    /**
     * @return int
     */
    public function getAwbCopyCount(): int
    {
        return $this->awbCopyCount;
    }

    /**
     * @return string
     */
    public function getContactName(): string
    {
        return $this->contactName;
    }

    /**
     * @return string
     */
    public function getCustomerEkp(): string
    {
        return $this->customerEkp;
    }

    /**
     * @return string
     */
    public function getItemFormat(): string
    {
        return $this->itemFormat;
    }

    /**
     * @return string
     */
    public function getJobReference(): string
    {
        return $this->jobReference;
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
    public function getServiceLevel(): string
    {
        return $this->serviceLevel;
    }

    /**
     * @return string
     */
    public function getTelephoneNumber(): string
    {
        return $this->telephoneNumber;
    }

    /**
     * @return float
     */
    public function getTotalWeight(): float
    {
        return $this->totalWeight;
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $awb = [
            'customerEkp' => $this->customerEkp,
            'contactName' => $this->contactName,
            'awbCopyCount' => $this->awbCopyCount,
            'product' => $this->product,
            'serviceLevel' => $this->serviceLevel,
            'itemFormat' => $this->itemFormat
        ];

        if ($this->jobReference !== null) {
            $awb['jobReference'] = $this->jobReference;
        }

        if ($this->totalWeight !== null) {
            $awb['totalWeight'] = $this->totalWeight;
        }

        if ($this->telephoneNumber !== null) {
            $awb['telephoneNumber'] = $this->telephoneNumber;
        }

        return $awb;
    }
}
