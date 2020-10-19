<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogResponse
{

    /**
     * @var GetCatalogResponseType $Response
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
     * @param GetCatalogResponseType $Response
     * @param ExceptionCustom        $Exception
     * @param boolean                $success
     */
    public function __construct($Response, $Exception, $success)
    {
      $this->Response = $Response;
      $this->Exception = $Exception;
      $this->success = $success;
    }

    /**
     * @return GetCatalogResponseType
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param GetCatalogResponseType $Response
     * @return GetCatalogResponse
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
     * @return GetCatalogResponse
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
     * @return GetCatalogResponse
     */
    public function setSuccess($success)
    {
      $this->success = $success;
      return $this;
    }

}
