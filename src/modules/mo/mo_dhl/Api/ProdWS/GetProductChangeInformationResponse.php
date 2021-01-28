<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductChangeInformationResponse
{

    /**
     * @var GetProductChangeInformationResponseType $Response
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
     * @param GetProductChangeInformationResponseType $Response
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
     * @return GetProductChangeInformationResponseType
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param GetProductChangeInformationResponseType $Response
     * @return GetProductChangeInformationResponse
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
     * @return GetProductChangeInformationResponse
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
     * @return GetProductChangeInformationResponse
     */
    public function setSuccess($success)
    {
      $this->success = $success;
      return $this;
    }

}
