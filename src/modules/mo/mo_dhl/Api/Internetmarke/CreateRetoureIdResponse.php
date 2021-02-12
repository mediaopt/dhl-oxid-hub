<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class CreateRetoureIdResponse
{

    /**
     * @var string $shopRetoureId
     */
    protected $shopRetoureId = null;

    /**
     * @param string $shopRetoureId
     */
    public function __construct($shopRetoureId)
    {
      $this->shopRetoureId = $shopRetoureId;
    }

    /**
     * @return string
     */
    public function getShopRetoureId()
    {
      return $this->shopRetoureId;
    }

    /**
     * @param string $shopRetoureId
     * @return \Mediaopt\DHL\Api\Internetmarke\CreateRetoureIdResponse
     */
    public function setShopRetoureId($shopRetoureId)
    {
      $this->shopRetoureId = $shopRetoureId;
      return $this;
    }

}
