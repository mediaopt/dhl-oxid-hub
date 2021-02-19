<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrievePreviewVoucherResponseType
{

    /**
     * @var Link $link
     */
    protected $link = null;

    /**
     * @param Link $link
     */
    public function __construct($link)
    {
      $this->link = $link;
    }

    /**
     * @return Link
     */
    public function getLink()
    {
      return $this->link;
    }

    /**
     * @param Link $link
     * @return RetrievePreviewVoucherResponseType
     */
    public function setLink($link)
    {
      $this->link = $link;
      return $this;
    }

}
