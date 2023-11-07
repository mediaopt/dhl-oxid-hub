<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class Detail extends \ArrayObject
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
     * contract billing number
     *
     * @var string
     */
    protected $billingNumber;
    /**
     * booking text
     *
     * @var string
     */
    protected $bookingText;
    /**
     * go green
     *
     * @var bool
     */
    protected $goGreen;
    /**
     * The customer's ship customer config product data
     *
     * @var Product
     */
    protected $product;
    /**
     * contract billing number
     *
     * @return string
     */
    public function getBillingNumber() : string
    {
        return $this->billingNumber;
    }
    /**
     * contract billing number
     *
     * @param string $billingNumber
     *
     * @return self
     */
    public function setBillingNumber(string $billingNumber) : self
    {
        $this->initialized['billingNumber'] = true;
        $this->billingNumber = $billingNumber;
        return $this;
    }
    /**
     * booking text
     *
     * @return string
     */
    public function getBookingText() : string
    {
        return $this->bookingText;
    }
    /**
     * booking text
     *
     * @param string $bookingText
     *
     * @return self
     */
    public function setBookingText(string $bookingText) : self
    {
        $this->initialized['bookingText'] = true;
        $this->bookingText = $bookingText;
        return $this;
    }
    /**
     * go green
     *
     * @return bool
     */
    public function getGoGreen() : bool
    {
        return $this->goGreen;
    }
    /**
     * go green
     *
     * @param bool $goGreen
     *
     * @return self
     */
    public function setGoGreen(bool $goGreen) : self
    {
        $this->initialized['goGreen'] = true;
        $this->goGreen = $goGreen;
        return $this;
    }
    /**
     * The customer's ship customer config product data
     *
     * @return Product
     */
    public function getProduct() : Product
    {
        return $this->product;
    }
    /**
     * The customer's ship customer config product data
     *
     * @param Product $product
     *
     * @return self
     */
    public function setProduct(Product $product) : self
    {
        $this->initialized['product'] = true;
        $this->product = $product;
        return $this;
    }
}