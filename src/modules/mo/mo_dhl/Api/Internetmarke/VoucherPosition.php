<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class VoucherPosition extends Position
{

    /**
     * @var page $page
     */
    protected $page = null;

    /**
     * @param labelX $labelX
     * @param labelY $labelY
     * @param page $page
     */
    public function __construct($labelX, $labelY, $page)
    {
      parent::__construct($labelX, $labelY);
      $this->page = $page;
    }

    /**
     * @return page
     */
    public function getPage()
    {
      return $this->page;
    }

    /**
     * @param page $page
     * @return VoucherPosition
     */
    public function setPage($page)
    {
      $this->page = $page;
      return $this;
    }

}
