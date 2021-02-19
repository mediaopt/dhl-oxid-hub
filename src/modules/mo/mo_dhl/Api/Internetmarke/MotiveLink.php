<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class MotiveLink
{

    /**
     * @var Link $link
     */
    protected $link = null;

    /**
     * @var Link $linkThumbnail
     */
    protected $linkThumbnail = null;

    /**
     * @param Link $link
     * @param Link $linkThumbnail
     */
    public function __construct($link, $linkThumbnail)
    {
      $this->link = $link;
      $this->linkThumbnail = $linkThumbnail;
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
     * @return MotiveLink
     */
    public function setLink($link)
    {
      $this->link = $link;
      return $this;
    }

    /**
     * @return Link
     */
    public function getLinkThumbnail()
    {
      return $this->linkThumbnail;
    }

    /**
     * @param Link $linkThumbnail
     * @return MotiveLink
     */
    public function setLinkThumbnail($linkThumbnail)
    {
      $this->linkThumbnail = $linkThumbnail;
      return $this;
    }

}
