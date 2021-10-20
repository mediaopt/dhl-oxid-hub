<?php

namespace Mediaopt\DHL\Api\Warenpost;

use Mediaopt\DHL\Exception\WarenpostException;

/**
 * This class represents a Content DHL Model.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Content
{
    use Validator;

    /**
     * @var int
     */
    const AMOUNT_MIN = 1;

    /**
     * @var int
     */
    const AMOUNT_MAX = 99;

    /**
     * @var int
     */
    const DESCRIPTION_LENGTH_MIN = 1;

    /**
     * @var int
     */
    const DESCRIPTION_LENGTH_MAX = 33;

    /**
     * @var int
     */
    const NETWEIGHT_MIN = 1;

    /**
     * @var int
     */
    const NETWEIGHT_MAX = 2000;

    /**
     * @var int
     */
    const ORIGIN_LENGTH = 2;

    /**
     * @var int
     */
    const HS_CODE_LENGTH_MIN = 4;

    /**
     * @var int
     */
    const HS_CODE_LENGTH_MAX = 10;

    /**
     * The HS code of this content.
     *
     * @var string
     */
    protected $contentPieceHsCode;

    /**
     * The (short) description of this content.
     * Length 1 - 33
     *
     * @var string
     */
    protected $contentPieceDescription;

    /**
     * Overall value of the content pieces of one type.
     *
     * @var string
     */
    protected $contentPieceValue;

    /**
     * The net weight of all pieces of this content type.
     * Range 1 - 2000
     *
     * @var int
     */
    protected $contentPieceNetweight;

    /**
     * Country of origin, based on ISO-3166-1.
     * Length = 2
     *
     * @var string
     */
    protected $contentPieceOrigin;

    /**
     * Number of pieces.
     * Range 1 - 99
     *
     * @var int
     */
    protected $contentPieceAmount;

    /**
     * @var int|null
     */
    protected $contentPieceIndexNumber;

    /**
     * @param string $contentPieceValue
     * @param int $contentPieceNetweight
     * @param int $contentPieceAmount
     */
    public function __construct(
        string $contentPieceValue,
        int $contentPieceNetweight,
        int $contentPieceAmount
    )
    {
        $this->contentPieceValue = $contentPieceValue;
        $this->contentPieceNetweight = $contentPieceNetweight;
        $this->contentPieceAmount = $contentPieceAmount;
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        $errorMessage = implode(' ,', array_merge(
            $this->isStringFieldCorrect('contentPieceDescription', $this->contentPieceDescription, self::DESCRIPTION_LENGTH_MIN, self::DESCRIPTION_LENGTH_MAX),
            $this->isIntFieldCorrect('contentPieceNetweight', $this->contentPieceNetweight, self::NETWEIGHT_MIN, self::NETWEIGHT_MAX, true),
            $this->isStringFieldCorrect('contentPieceOrigin', $this->contentPieceOrigin, self::ORIGIN_LENGTH, null, true),
            $this->isIntFieldCorrect('contentPieceAmount', $this->contentPieceAmount, self::AMOUNT_MIN, self::AMOUNT_MAX, true),
            $this->isStringFieldCorrect('contentPieceHsCode', $this->contentPieceHsCode, self::HS_CODE_LENGTH_MIN, self::HS_CODE_LENGTH_MAX)
        ));

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage;
        throw new WarenpostException($message, WarenpostException::CONTENT_VALIDATION_ERROR);
    }

    /**
     * @param string $contentPieceOrigin
     */
    public function setContentPieceOrigin(string $contentPieceOrigin)
    {
        $this->contentPieceOrigin = $contentPieceOrigin;
    }

    /**
     * @param int $contentPieceIndexNumber
     */
    public function setContentPieceIndexNumber(int $contentPieceIndexNumber)
    {
        $this->contentPieceIndexNumber = $contentPieceIndexNumber;
    }

    /**
     * @param string $contentPieceHsCode
     */
    public function setContentPieceHsCode(string $contentPieceHsCode)
    {
        $this->contentPieceHsCode = $contentPieceHsCode;
    }

    /**
     * @param string $contentPieceDescription
     */
    public function setContentPieceDescription(string $contentPieceDescription)
    {
        $this->contentPieceDescription = $contentPieceDescription;
    }

    /**
     * @return string|null
     */
    public function getContentPieceHsCode(): ?string
    {
        return $this->contentPieceHsCode;
    }

    /**
     * @return string|null
     */
    public function getContentPieceDescription(): ?string
    {
        return $this->contentPieceDescription;
    }

    /**
     * @return string
     */
    public function getContentPieceValue(): string
    {
        return $this->contentPieceValue;
    }

    /**
     * @return int
     */
    public function getContentPieceNetweight(): int
    {
        return $this->contentPieceNetweight;
    }

    /**
     * @return string|null
     */
    public function getContentPieceOrigin(): ?string
    {
        return $this->contentPieceOrigin;
    }

    /**
     * @return int
     */
    public function getContentPieceAmount(): int
    {
        return $this->contentPieceAmount;
    }

    /**
     * @return int|null
     */
    public function getContentPieceIndexNumber(): ?int
    {
        return $this->contentPieceIndexNumber;
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $array = [
            'contentPieceValue' => $this->contentPieceValue,
            'contentPieceNetweight' => $this->contentPieceNetweight,
            'contentPieceAmount' => $this->contentPieceAmount
        ];

        $unrequiredFields = [
            'contentPieceHsCode',
            'contentPieceDescription',
            'contentPieceOrigin',
            'contentPieceIndexNumber',
        ];

        foreach ($unrequiredFields as $field) {
            if ($this->$field !== null) {
                $array[$field] = $this->$field;
            }
        }

        return $array;
    }
}
