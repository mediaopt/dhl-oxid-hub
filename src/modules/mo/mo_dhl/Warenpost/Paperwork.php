<?php

namespace Mediaopt\DHL\Warenpost;

use Mediaopt\DHL\Exception\WarenpostException;

/**
 * This class represents an Awb DHL Model.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Paperwork
{
    use Validator;

    /**
     * @var int
     */
    const COPY_COUNT_MIN = 1;

    /**
     * @var int
     */
    const COPY_COUNT_MAX = 99; //todo check is copy count same with Awb

    /**
     * Copies of AWB labels.
     * Range 1 - 99
     *
     * @var int
     */
    protected int $awbCopyCount;

    /**
     * Contact name for paperwork.
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
     * Job reference for paperwork.
     *
     * @var string|null
     */
    protected ?string $jobReference;

    /**
     * Pickup date used in pickup information.
     * Only applicable, if you have chosen Pick-Up Type DHL_GLOBAL_MAIl or DHL_EXPRESS.
     *
     * @var string|null
     */
    protected ?string $pickupDate;

    /**
     * Pickup location used in pickup information.
     * Only applicable, if you have chosen Pick-Up Type DHL_GLOBAL_MAIl or DHL_EXPRESS.
     *
     * @var string|null
     */
    protected ?string $pickupLocation;

    /**
     * Pickup location used in pickup information.
     * See PickupTimeSlot class
     *
     * @var string|null
     */
    protected ?string $pickupTimeSlot;
    /**
     * Pickup type used in pickup information.
     * If not set it defaults to "CUSTOMER_DROP_OFF".
     *
     * @var string|null
     */
    protected ?string $pickupType;

    /**
     * Telephone number for paperwork. Required for sales channel EXPRESS. //todo what is sales channel
     *
     * @var string|null
     */
    protected ?string $telephoneNumber;

    /**
     * @param string $contactName
     * @param int $awbCopyCount
     * @param string|null $jobReference
     * @param string|null $pickupType
     * @param string|null $pickupLocation
     * @param string|null $pickupDate
     * @param string|null $pickupTimeSlot
     * @param string|null $telephoneNumber
     */
    public function __construct(
        string $contactName,
        int $awbCopyCount,
        $jobReference = null,
        $pickupType = null,
        $pickupLocation = null,
        $pickupDate = null,
        $pickupTimeSlot = null,
        $telephoneNumber = null
    )
    {
        if ($pickupType === null) {
            $pickupType = PickupType::CUSTOMER_DROP_OFF;
        }

        $this->contactName = $contactName;
        $this->awbCopyCount = $awbCopyCount;
        $this->jobReference = $jobReference;
        $this->pickupType = $pickupType;
        $this->pickupLocation = $pickupLocation;
        $this->pickupDate = $pickupDate;
        $this->pickupTimeSlot = $pickupTimeSlot;
        $this->telephoneNumber = $telephoneNumber;
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        $errorMessage = implode(', ', array_merge(
            $this->isIntFieldCorrect('awbCopyCount', $this->awbCopyCount, self::COPY_COUNT_MIN, self::COPY_COUNT_MAX, true),
            $this->isEnumFieldCorrect('pickupType', $this->pickupType, PickupType::$PICKUP_TYPES),
            $this->isEnumFieldCorrect('pickupTimeSlot', $this->pickupTimeSlot, PickupTimeSlot::$SLOTS),
            $this->isCorrectPickupDate(),
            $this->isCorrectPickupLocation(),
            $this->isPickupTimeSlotNecessary()
        ));

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage;
        throw new WarenpostException($message, WarenpostException::PAPERWORK_VALIDATION_ERROR);
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
    public function getJobReference(): string
    {
        return $this->jobReference;
    }

    /**
     * @return string
     */
    public function getPickupDate(): string
    {
        return $this->pickupDate;
    }

    /**
     * @return string
     */
    public function getPickupLocation(): string
    {
        return $this->pickupLocation;
    }

    /**
     * @return string
     */
    public function getPickupTimeSlot(): string
    {
        return $this->pickupTimeSlot;
    }

    /**
     * @return string
     */
    public function getPickupType(): string
    {
        return $this->pickupType;
    }

    /**
     * @return string
     */
    public function getTelephoneNumber(): string
    {
        return $this->telephoneNumber;
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $array = [
            'contactName' => $this->contactName,
            'awbCopyCount' => $this->awbCopyCount,
            'pickupType' => $this->pickupType
        ];

        $unrequiredFields = [
            'jobReference',
            'pickupType',
            'pickupLocation',
            'pickupDate',
            'pickupTimeSlot',
            'telephoneNumber'
        ];

        foreach ($unrequiredFields as $field) {
            if ($this->$field !== null) {
                $array[$field] = $this->$field;
            }
        }

        return $array;
    }

    /**
     * @return string[]
     */
    protected function isCorrectPickupDate(): array
    {
        $messages = [];
        if (!empty($this->pickupDate)) {
            $dateTime = \DateTime::createFromFormat('Y-m-d', $this->pickupDate);
            if (!$dateTime || $dateTime->format('Y-m-d') !== $this->pickupDate) {
                $messages[] = "wrong pickupDate format, should be a YYYY-MM-DD, current is `$this->pickupDate`";
            }

            $pickupTypeIsDHL = in_array($this->pickupType, PickupType::$DHL_PICKUP_TYPES, true);
            if (!$pickupTypeIsDHL) {
                $messages[] = 'if you want to select pickup date, pickup type should be '
                    . implode(' or ', PickupType::$DHL_PICKUP_TYPES) . ", pickup type is `$this->pickupType`";
            }
        }

        return $messages;
    }

    /**
     * @return string[]
     */
    protected function isCorrectPickupLocation(): array
    {
        $messages = [];
        if (!empty($this->pickupLocation)) {
            $pickupTypeIsDHL = in_array($this->pickupType, PickupType::$DHL_PICKUP_TYPES, true);
            if (!$pickupTypeIsDHL) {
                $messages[] = "if you want to select pickup location, pickup type should be "
                    . implode(' or ', PickupType::$DHL_PICKUP_TYPES) . ", pickup type is `$this->pickupType`";
            }
        }
        return $messages;
    }

    /**
     * @throws string[]
     */
    protected function isPickupTimeSlotNecessary(): array
    {
        $messages = [];
        $pickupTypeIsDHL = in_array($this->pickupType, PickupType::$DHL_PICKUP_TYPES, true);
        if ($pickupTypeIsDHL && empty($this->pickupTimeSlot)) {
            $messages[] = "pickup time slot is nesessary for pickup type "
                . implode(' or ', PickupType::$DHL_PICKUP_TYPES);
        }
        return $messages;
    }
}
