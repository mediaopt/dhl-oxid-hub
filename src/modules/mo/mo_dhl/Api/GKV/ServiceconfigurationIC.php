<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationIC
{

    /**
     * @var Ident|\stdClass $Ident
     */
    protected $Ident = null;

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @param Ident|\stdClass $Ident
     * @param bool  $active
     */
    public function __construct($Ident, $active)
    {
        $this->Ident = $Ident;
        $this->active = $active;
    }

    /**
     * @return Ident|\stdClass
     */
    public function getIdent()
    {
        return $this->Ident;
    }

    /**
     * @param Ident|\stdClass $Ident
     * @return ServiceconfigurationIC
     */
    public function setIdent($Ident)
    {
        $this->Ident = $Ident;
        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return ServiceconfigurationIC
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

}
