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
     * @var int
     */
    const JOB_REFERENCE_LENGTH_MAX = 17;

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
     * @var string
     */
    protected $pickupType;

    /**
     * @param string $contactName
     * @param string|null $jobReference
     */
    public function __construct(string $contactName, $jobReference = null)
    {
        $this->contactName = $contactName;
        $this->jobReference = $jobReference;
        $this->awbCopyCount = 1;
        $this->pickupType = PickupType::CUSTOMER_DROP_OFF;
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        $errorMessage = $this->isStringFieldCorrect('jobReference', $this->jobReference, 0, self::JOB_REFERENCE_LENGTH_MAX);

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage[0];
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

        if ($this->jobReference !== null){
            $array['jobReference'] = $this->jobReference;
        }

        return $array;
    }
}
