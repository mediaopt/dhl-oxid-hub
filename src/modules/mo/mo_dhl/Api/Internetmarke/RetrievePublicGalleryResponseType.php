<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrievePublicGalleryResponseType
{

    /**
     * @var GalleryItem[] $items
     */
    protected $items = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return GalleryItem[]
     */
    public function getItems()
    {
      return $this->items;
    }

    /**
     * @param GalleryItem[] $items
     * @return RetrievePublicGalleryResponseType
     */
    public function setItems(array $items = null)
    {
      $this->items = $items;
      return $this;
    }

}
