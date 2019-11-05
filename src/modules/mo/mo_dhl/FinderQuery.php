<?php
namespace Mediaopt\DHL;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

/**
 * Encapsulates a query to the finder.
 *
 * @author derksen mediaopt GmbH
 */
class FinderQuery
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var bool
     */
    protected $packstation;

    /**
     * @var bool
     */
    protected $postfiliale;

    /**
     * @var bool
     */
    protected $paketshop;

    /**
     * @param string $address
     * @param bool $packstation
     * @param bool $postfiliale
     * @param bool $paketshop
     */
    public function __construct($address, $packstation, $postfiliale, $paketshop)
    {
        $this->address = $address;
        $this->packstation = $packstation;
        $this->postfiliale = $postfiliale;
        $this->paketshop = $paketshop;
    }

    /**
     * @return bool
     */
    public function searchesForPackstation()
    {
        return $this->packstation;
    }

    /**
     * @return bool
     */
    public function searchesForPostfiliale()
    {
        return $this->postfiliale;
    }

    /**
     * @return bool
     */
    public function searchesForPaketshop()
    {
        return $this->paketshop;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
