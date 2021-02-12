<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ExceptionCustom
{

    /**
     * @var ExceptionDetailType $exceptionDetail
     */
    protected $exceptionDetail = null;

    /**
     * @param ExceptionDetailType $exceptionDetail
     */
    public function __construct($exceptionDetail)
    {
      $this->exceptionDetail = $exceptionDetail;
    }

    /**
     * @return ExceptionDetailType
     */
    public function getExceptionDetail()
    {
      return $this->exceptionDetail;
    }

    /**
     * @param ExceptionDetailType $exceptionDetail
     * @return ExceptionCustom
     */
    public function setExceptionDetail($exceptionDetail)
    {
      $this->exceptionDetail = $exceptionDetail;
      return $this;
    }

}
