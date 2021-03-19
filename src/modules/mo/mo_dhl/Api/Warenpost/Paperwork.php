<?php

namespace Mediaopt\DHL\Api\Warenpost;

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
     * Copies of the AWB label (not yet enabled for Warenpost)
     * Сan be only 1 now
     *
     * @var int
     */
    protected $awbCopyCount;

    /**
     * Contact person for questions (not yet enabled for Warenpost)
     *
     * @var string
     */
    protected $contactName;

    /**
     * Irrelevant to Warenpost International
     * Max 17 characters
     *
     * @var string|null
     */
    protected $jobReference;

    /**
     * Irrelevant to Warenpost International
     * For Warenpost International only CUSTOMER_DROP_OFF is possible
     *
     * @var string|null
     */
    protected $pickupType;

    /**
     * @param string $contactName
     * @param int $awbCopyCount
     * @param string|null $jobReference
     * @param string|null $pickupType
     */
    public function __construct(
        string $contactName,
        int $awbCopyCount,
        $jobReference = null
    )
    {
        $this->contactName = $contactName;
        $this->awbCopyCount = $awbCopyCount;
        $this->jobReference = $jobReference;
        $this->pickupType = PickupType::CUSTOMER_DROP_OFF;
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        $errorMessage = $this->isStringFieldCorrect('jobReference', $this->jobReference, 0, 17);

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
    public function getPickupType(): string
    {
        return $this->pickupType;
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

        if ($this->pickupType !== null){
            $array['pickupType'] = $this->pickupType;
        }

        return $array;
    }
}
