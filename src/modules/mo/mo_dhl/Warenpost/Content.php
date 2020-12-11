<?php

namespace Mediaopt\DHL\Warenpost;

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
    const DESCRIPTION_LINGTH_MIN = 1;

    /**
     * @var int
     */
    const DESCRIPTION_LINGTH_MAX = 33;

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
     * The HS code of this content.
     *
     * @var string
     */
    protected $contentPieceHsCode;

    /**
     * The (short) description of this content.
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
     *
     * @var int
     */
    protected $contentPieceNetweight;

    /**
     * Country of origin, based on ISO-3166-1.
     *
     * @var string
     */
    protected $contentPieceOrigin;

    /**
     * Number of pieces.
     *
     * @var int
     */
    protected $contentPieceAmount;

    /**
     * @var int|null
     */
    protected $contentPieceIndexNumber;

    /**
     * @param string $contentPieceHsCode
     * @param string $contentPieceDescription
     * @param string $contentPieceValue
     * @param int $contentPieceNetweight
     * @param string $contentPieceOrigin
     * @param int $contentPieceAmount
     * @param int|null $contentPieceIndexNumber
     */
    public function __construct(
        $contentPieceHsCode,
        $contentPieceDescription,
        $contentPieceValue,
        $contentPieceNetweight,
        $contentPieceOrigin,
        $contentPieceAmount,
        $contentPieceIndexNumber = null
    )
    {
        $this->contentPieceHsCode = $contentPieceHsCode;
        $this->contentPieceDescription = $contentPieceDescription;
        $this->contentPieceValue = $contentPieceValue;
        $this->contentPieceNetweight = $contentPieceNetweight;
        $this->contentPieceOrigin = $contentPieceOrigin;
        $this->contentPieceAmount = $contentPieceAmount;
        $this->contentPieceIndexNumber = $contentPieceIndexNumber;
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        $errorMessage = implode(' ,', array_merge(
            $this->isStringFieldCorrect('contentPieceDescription', $this->contentPieceDescription, self::DESCRIPTION_LINGTH_MIN, self::DESCRIPTION_LINGTH_MAX, true),
            $this->isIntFieldCorrect('contentPieceNetweight', $this->contentPieceNetweight, self::NETWEIGHT_MIN, self::NETWEIGHT_MAX, true),
            $this->isStringFieldCorrect('contentPieceOrigin', $this->contentPieceOrigin, self::ORIGIN_LENGTH, null, true),
            $this->isIntFieldCorrect('contentPieceAmount', $this->contentPieceAmount, self::AMOUNT_MIN, self::AMOUNT_MAX, true)
        ));

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage;
        throw new WarenpostException($message, WarenpostException::CONTENT_VALIDATION_ERROR);
    }

    /**
     * @return string
     */
    public function getContentPieceHsCode(): string
    {
        return $this->contentPieceHsCode;
    }

    /**
     * @return string
     */
    public function getContentPieceDescription(): string
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
     * @return string
     */
    public function getContentPieceOrigin(): string
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
            'contentPieceHsCode' => $this->contentPieceHsCode,
            'contentPieceDescription' => $this->contentPieceDescription,
            'contentPieceValue' => $this->contentPieceValue,
            'contentPieceNetweight' => $this->contentPieceNetweight,
            'contentPieceOrigin' => $this->contentPieceOrigin,
            'contentPieceAmount' => $this->contentPieceAmount
        ];

        if ($this->contentPieceIndexNumber !== null) {
            $array['contentPieceIndexNumber'] = $this->contentPieceIndexNumber;
        }

        return $array;
    }
}
