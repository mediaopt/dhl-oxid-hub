<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrievePrivateGalleryResponseType
{

    /**
     * @var MotiveLink[] $imageLink
     */
    protected $imageLink = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return MotiveLink[]
     */
    public function getImageLink()
    {
      return $this->imageLink;
    }

    /**
     * @param MotiveLink[] $imageLink
     * @return RetrievePrivateGalleryResponseType
     */
    public function setImageLink(array $imageLink = null)
    {
      $this->imageLink = $imageLink;
      return $this;
    }

}
