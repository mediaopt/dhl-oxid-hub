<?php

namespace Mediaopt\DHL\Warenpost;

/**
 * This class represents an Awb DHL Model.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
trait Validator
{
    /**
     * @param string $name
     * @param mixed $value
     * @param int|null $minLength
     * @param int|null $maxLengt
     * @param bool $required
     * @return string[]
     */
    protected function isIntFieldCorrect(string $name, $value, $minLength = null, $maxLengt = null, $required = false): array
    {

        if ($value === null && !$required) {
            return [];
        }

        if (!is_int($value)) {
            return ["type of $name should be an int"];
        }

        if  ($minLength === null && $maxLengt === null) {
            return[];
        }

        if ($value < $minLength || $value > $maxLengt) {
            return ["$name should be between $minLength and $maxLengt, current value is $value"];
        }

        return[];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string|null $minLength
     * @param string|null $maxLength
     * @param bool $required
     * @return string[]
     */
    protected function isStringFieldCorrect(string $name, $value, $minLength = null, $maxLength = null, bool $required = false): array
    {
        if ($value === null && !$required) {
            return [];
        }

        if (!is_string($value)) {
            return ["type of $name should be a string"];
        }

        if ($minLength === null && $maxLength === null) {
            return [];
        }

        $length = strlen($value);

        if ($maxLength === null && $length !== $minLength) {
            return ["$name length should be exactly $minLength characters long, current length is $length"];
        }

        if ($maxLength !== null && ($length < $minLength || $length > $maxLength)) {
            return ["$name length should be between $minLength and $maxLength symbols, current length is $length"];
        }

        return [];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param array $availibleValues
     * @param bool $required
     * @return string[]
     */
    public function isEnumFieldCorrect(string $name, $value, array $availibleValues, $required = false): array
    {
        if ($value === null && !$required) {
            return [];
        }

        if (!in_array($value, $availibleValues, true)) {
            return ["unknown $name `$value`, availiable values: [" . implode(', ', $availibleValues) . "]"];
        }

        return [];
    }

    /**
     * @param string $serviceLevel
     * @param string $product
     * @return string[]
     */
    public function isProductCorrectForServiceLevel(string $product, string $serviceLevel): array
    {
        $compareArray = [
            ServiceLevel::REGISTERED => [
                Product::GMR
            ],
            ServiceLevel::STANDARD => [
                Product::GMM,
                Product::GMP
            ],
            ServiceLevel::PRIORITY => [
                Product::GPT,
                Product::GPP,
                Product::GMP
            ]
        ];

        if (!in_array($product, $compareArray[$serviceLevel], true)) {
            return [
                "for serviceLevel $serviceLevel product should be "
                . implode(' or ', $compareArray[$serviceLevel])
                . ", current product is $product. "
            ];
        }
        return [];
    }
}
