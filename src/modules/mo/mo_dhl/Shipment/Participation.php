<?php

namespace Mediaopt\DHL\Shipment;

/**
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL\Export\Order
 */
class Participation
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
     * @return Participation
     * @throws \InvalidArgumentException
     */
    public static function build($number)
    {
        if (strlen($number) !== 2) {
            throw new \InvalidArgumentException('A participation number is exactly two characters long.');
        }
        if (!ctype_alnum($number)) {
            throw new \InvalidArgumentException('A participation number consists solely of alpha-numeric characters.');
        }

        return new self(strtoupper($number));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->number;
    }
}
