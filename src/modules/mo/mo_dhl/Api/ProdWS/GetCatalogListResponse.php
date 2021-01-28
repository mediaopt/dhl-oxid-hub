<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogListResponse
{

    /**
     * @var GetCatalogListResponseType $Response
     */
    protected $Response = null;

    /**
     * @var ExceptionCustom $Exception
     */
    protected $Exception = null;

    /**
     * @var boolean $success
     */
    protected $success = null;

    /**
     * @param GetCatalogListResponseType $Response
     * @param ExceptionCustom            $Exception
     * @param boolean                    $success
     */
    public function __construct($Response, $Exception, $success)
    {
      $this->Response = $Response;
      $this->Exception = $Exception;
      $this->success = $success;
    }

    /**
     * @return GetCatalogListResponseType
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param GetCatalogListResponseType $Response
     * @return GetCatalogListResponse
     */
    public function setResponse($Response)
    {
      $this->Response = $Response;
      return $this;
    }

    /**
     * @return ExceptionCustom
     */
    public function getException()
    {
      return $this->Exception;
    }

    /**
     * @param ExceptionCustom $Exception
     * @return GetCatalogListResponse
     */
    public function setException($Exception)
    {
      $this->Exception = $Exception;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
      return $this->success;
    }

    /**
     * @param boolean $success
     * @return GetCatalogListResponse
     */
    public function setSuccess($success)
    {
      $this->success = $success;
      return $this;
    }

}
