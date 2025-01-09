<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class Commodity extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * A text that describes the commodity item. Only the first 50 characters of the description text is printed on the customs declaration form CN23.
     *
     * @var string
     */
    protected $itemDescription;
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @var string
     */
    protected $countryOfOrigin;
    /**
     * Harmonized System Code aka Customs tariff number.
     *
     * @var string
     */
    protected $hsCode;
    /**
     * How many items of that type are in the package
     *
     * @var int
     */
    protected $packagedQuantity;
    /**
     * Currency and numeric value.
     *
     * @var Value
     */
    protected $itemValue;
    /**
     * Weight of item or shipment. Both uom and value are required.
     *
     * @var Weight
     */
    protected $itemWeight;
    /**
     * A text that describes the commodity item. Only the first 50 characters of the description text is printed on the customs declaration form CN23.
     *
     * @return string
     */
    public function getItemDescription() : string
    {
        return $this->itemDescription;
    }
    /**
     * A text that describes the commodity item. Only the first 50 characters of the description text is printed on the customs declaration form CN23.
     *
     * @param string $itemDescription
     *
     * @return self
     */
    public function setItemDescription(string $itemDescription) : self
    {
        $this->initialized['itemDescription'] = true;
        $this->itemDescription = $itemDescription;
        return $this;
    }
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @return string
     */
    public function getCountryOfOrigin() : string
    {
        return $this->countryOfOrigin;
    }
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @param string $countryOfOrigin
     *
     * @return self
     */
    public function setCountryOfOrigin(string $countryOfOrigin) : self
    {
        $this->initialized['countryOfOrigin'] = true;
        $this->countryOfOrigin = $countryOfOrigin;
        return $this;
    }
    /**
     * Harmonized System Code aka Customs tariff number.
     *
     * @return string
     */
    public function getHsCode() : string
    {
        return $this->hsCode;
    }
    /**
     * Harmonized System Code aka Customs tariff number.
     *
     * @param string $hsCode
     *
     * @return self
     */
    public function setHsCode(string $hsCode) : self
    {
        $this->initialized['hsCode'] = true;
        $this->hsCode = $hsCode;
        return $this;
    }
    /**
     * How many items of that type are in the package
     *
     * @return int
     */
    public function getPackagedQuantity() : int
    {
        return $this->packagedQuantity;
    }
    /**
     * How many items of that type are in the package
     *
     * @param int $packagedQuantity
     *
     * @return self
     */
    public function setPackagedQuantity(int $packagedQuantity) : self
    {
        $this->initialized['packagedQuantity'] = true;
        $this->packagedQuantity = $packagedQuantity;
        return $this;
    }
    /**
     * Currency and numeric value.
     *
     * @return Value
     */
    public function getItemValue() : Value
    {
        return $this->itemValue;
    }
    /**
     * Currency and numeric value.
     *
     * @param Value $itemValue
     *
     * @return self
     */
    public function setItemValue(Value $itemValue) : self
    {
        $this->initialized['itemValue'] = true;
        $this->itemValue = $itemValue;
        return $this;
    }
    /**
     * Weight of item or shipment. Both uom and value are required.
     *
     * @return Weight
     */
    public function getItemWeight() : Weight
    {
        return $this->itemWeight;
    }
    /**
     * Weight of item or shipment. Both uom and value are required.
     *
     * @param Weight $itemWeight
     *
     * @return self
     */
    public function setItemWeight(Weight $itemWeight) : self
    {
        $this->initialized['itemWeight'] = true;
        $this->itemWeight = $itemWeight;
        return $this;
    }
}