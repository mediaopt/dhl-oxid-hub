<?php

namespace Mediaopt\DHL\Merchant;

/**
 * @author  derksen mediaopt GmbH
 * @package Mediaopt\DHL\Merchant
 */
class Ekp
{
    /**
     * @var string
     */
    protected $number;

    /**
     * @param string $number
     */
    protected function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @param string $number
     * @return Ekp
     * @throws \InvalidArgumentException
     */
    public static function build($number)
    {
        if (strlen($number) !== 10) {
            throw new \InvalidArgumentException('An EKP is ten digits long.');
        }
        if (!ctype_digit($number)) {
            throw new \InvalidArgumentException('An EKP consists solely of digits.');
        }

        return new self($number);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->number;
    }
}
