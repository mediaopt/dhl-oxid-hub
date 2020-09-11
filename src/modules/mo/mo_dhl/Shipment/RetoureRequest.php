<?php

namespace Mediaopt\DHL\Shipment;

/**
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL\Export\Order
 */
class RetoureRequest
{
    /**
     * @var string
     */
    const REQUESTED = 'REQUESTED';

    /**
     * @var string
     */
    const CREATED = 'CREATED';

    /**
     * @var string
     */
    const DECLINED = 'DECLINED';

    /**
     * @var string
     */
    protected $status;

    /**
     * @param string $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @param string $status
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function build($status)
    {
        $constant = __CLASS__ . '::' . $status;
        if (!defined($constant) || constant($constant) !== $status) {
            throw new \InvalidArgumentException('Invalid retoure request status.');
        }
        return $status;
    }

    /**
     * @return string[]
     */
    public static function getRetoureRequestStatuses()
    {
        return [
            self::REQUESTED => 'MO_DHL__RETOURE_REQUESTED',
            self::CREATED   => 'MO_DHL__RETOURE_CREATED',
            self::DECLINED  => 'MO_DHL__RETOURE_DECLINED',
        ];
    }
}
