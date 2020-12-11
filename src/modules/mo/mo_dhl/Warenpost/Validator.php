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
     * @param int|null $minLenght
     * @param int|null $maxLengt
     * @param bool $required
     * @return string[]
     */
    protected function isIntFieldCorrect(string $name, $value, $minLenght = null, $maxLengt = null, $required = false): array
    {

        if ($value === null && !$required) {
            return [];
        }

        $messages = [];
        if (!is_int($value)) {
            $messages[] = "type of $name should be an int";
        }

        if ($minLenght === null && $maxLengt === null) {
            return $messages;
        }

        if ($value < $minLenght || $value > $maxLengt) {
            $messages[] = "$name should be between $minLenght and $maxLengt, current value is $value";
        }

        return $messages;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string|null $minLenght
     * @param string|null $maxLengt
     * @param bool $required
     * @return string[]
     */
    protected function isStringFieldCorrect(string $name, $value, $minLenght = null, $maxLengt = null, bool $required = false): array
    {
        if ($value === null && !$required) {
            return [];
        }

        $messages = [];
        if (!is_string($value)) {
            $messages[] = "type of $name should be a string";
        }

        if ($minLenght === null && $maxLengt === null) {
            return $messages;
        }

        $lenght = strlen($value);

        if ($maxLengt === null && $lenght !== $minLenght) {
            $messages[] = "$name length should be exactly $minLenght characters long, current lenght is $lenght";
        }

        if ($lenght < $minLenght || $lenght > $maxLengt) {
            $messages[] = "$name length should be between $minLenght and $maxLengt symbols, current lenght is $lenght";
        }

        return $messages;
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
            return [" - unknown $name `$value`"];
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

        if (!in_array($product, $compareArray[$serviceLevel])) {

            return [
                "for serviceLevel $serviceLevel product should be "
                . implode(' or ', $compareArray[$serviceLevel])
                . ". Current product is $product. "
            ];
        }
        return [];

    }

}
