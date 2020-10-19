<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogChangeInformationResponse
{

    /**
     * @var GetCatalogChangeInformationResponseType $Response
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
     * @param GetCatalogChangeInformationResponseType $Response
     * @param ExceptionCustom                         $Exception
     * @param boolean                                 $success
     */
    public function __construct($Response, $Exception, $success)
    {
      $this->Response = $Response;
      $this->Exception = $Exception;
      $this->success = $success;
    }

    /**
     * @return GetCatalogChangeInformationResponseType
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param GetCatalogChangeInformationResponseType $Response
     * @return GetCatalogChangeInformationResponse
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
     * @return GetCatalogChangeInformationResponse
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
     * @return GetCatalogChangeInformationResponse
     */
    public function setSuccess($success)
    {
      $this->success = $success;
      return $this;
    }

}
