<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetChangedProductVersionsListResponse
{

    /**
     * @var GetChangedProductVersionsListResponseType $Response
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
     * @param GetChangedProductVersionsListResponseType $Response
     * @param ExceptionCustom                           $Exception
     * @param boolean                                   $success
     */
    public function __construct($Response, $Exception, $success)
    {
      $this->Response = $Response;
      $this->Exception = $Exception;
      $this->success = $success;
    }

    /**
     * @return GetChangedProductVersionsListResponseType
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param GetChangedProductVersionsListResponseType $Response
     * @return GetChangedProductVersionsListResponse
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
     * @return GetChangedProductVersionsListResponse
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
     * @return GetChangedProductVersionsListResponse
     */
    public function setSuccess($success)
    {
      $this->success = $success;
      return $this;
    }

}
