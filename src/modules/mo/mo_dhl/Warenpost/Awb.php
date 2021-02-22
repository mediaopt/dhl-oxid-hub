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
     * @var int
     */
    const COPY_COUNT_MIN = 1;

    /**
     * @var int
     */
    const COPY_COUNT_MAX = 50;

    /**
     * @var int
     */
    const CONTACT_NAME_MIN_LENGTH = 1;

    /**
     * @var int
     */
    const CONTACT_NAME_MAX_LENGTH = 40;

    /**
     * @var int
     */
    const JOB_REFERENCE_MIN_LENGTH = 0;

    /**
     * @var int
     */
    const JOB_REFERENCE_MAX_LENGTH = 17;

    /**
     * Copies of AWB labels.
     * Min = 1, Max = 50
     *
     * @var int
     */
    protected int $awbCopyCount;

    /**
     * Contact name for paperwork.
     * Lenght 1 - 40
     *
     * @var string
     */
    protected string $contactName;

    /**
     * Deutsche Post Customer Account number (EKP) of the customer who wants to create an single awb.
     *
     * @var string
     */
    protected string $customerEkp;

    /**
     * The item format for this awb.
     *
     * @var string
     */
    protected string $itemFormat;

    /**
     * Job reference for paperwork.
     *
     * @var string|null
     */
    protected ?string $jobReference;

    /**
     * See Product class
     *
     * @var string
     */
    protected string $product;

    /**
     * See ServiceLevel class
     *
     * @var string
     */
    protected string $serviceLevel;

    /**
     * Telephone number for paperwork.
     *
     * @var string|null
     */
    protected ?string $telephoneNumber;

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
     * @var float|null
     */
    protected ?float $totalWeight;

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        //Basic fields validation
        $errorMessage = implode(' ,', array_merge(
            $this->isIntFieldCorrect('awbCopyCount', $this->awbCopyCount, self::COPY_COUNT_MIN, self::COPY_COUNT_MAX, true),
            $this->isStringFieldCorrect('contactName', $this->contactName, self::CONTACT_NAME_MIN_LENGTH, self::CONTACT_NAME_MAX_LENGTH, true),
            $this->isEnumFieldCorrect('itemFormat', $this->itemFormat, ItemFormat::$ITEM_FORMATS, true),
            $this->isStringFieldCorrect('jobReference', $this->jobReference, self::JOB_REFERENCE_MIN_LENGTH, self::JOB_REFERENCE_MAX_LENGTH),
            $this->isEnumFieldCorrect('product', $this->product, Product::$PRODUCTS),
            $this->isEnumFieldCorrect('serviceLevel', $this->serviceLevel, ServiceLevel::$SERVICE_LEVELS)
        ));

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
        $array = [
            'customerEkp' => $this->customerEkp,
            'contactName' => $this->contactName,
            'awbCopyCount' => $this->awbCopyCount,
            'product' => $this->product,
            'serviceLevel' => $this->serviceLevel,
            'itemFormat' => $this->itemFormat
        ];

        $unrequiredFields = [
            'jobReference',
            'totalWeight',
            'telephoneNumber'
        ];

        foreach ($unrequiredFields as $field) {
            if ($this->$field !== null) {
                $array[$field] = $this->$field;
            }
        }

        return $array;
    }
}
