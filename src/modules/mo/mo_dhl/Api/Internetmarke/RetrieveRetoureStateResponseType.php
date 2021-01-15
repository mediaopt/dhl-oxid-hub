<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveRetoureStateResponseType
{

    /**
     * @var RetoureStateType[] $retoureState
     */
    protected $retoureState = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return RetoureStateType[]
     */
    public function getRetoureState()
    {
      return $this->retoureState;
    }

    /**
     * @param RetoureStateType[] $retoureState
     * @return \Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateResponseType
     */
    public function setRetoureState(array $retoureState = null)
    {
      $this->retoureState = $retoureState;
      return $this;
    }

}
