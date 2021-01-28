<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrievePageFormatsResponseType
{

    /**
     * @var PageFormat[] $pageFormat
     */
    protected $pageFormat = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return PageFormat[]
     */
    public function getPageFormat()
    {
      return $this->pageFormat;
    }

    /**
     * @param PageFormat[] $pageFormat
     * @return RetrievePageFormatsResponseType
     */
    public function setPageFormat(array $pageFormat = null)
    {
      $this->pageFormat = $pageFormat;
      return $this;
    }

}
