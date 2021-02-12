<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrievePreviewVoucherPDFRequestType
{

    /**
     * @var ProductCode $productCode
     */
    protected $productCode = null;

    /**
     * @var ImageID $imageID
     */
    protected $imageID = null;

    /**
     * @var VoucherLayout $voucherLayout
     */
    protected $voucherLayout = null;

    /**
     * @var PageFormatId $pageFormatId
     */
    protected $pageFormatId = null;

    /**
     * @param ProductCode $productCode
     * @param VoucherLayout $voucherLayout
     * @param PageFormatId $pageFormatId
     */
    public function __construct($productCode, $voucherLayout, $pageFormatId)
    {
      $this->productCode = $productCode;
      $this->voucherLayout = $voucherLayout;
      $this->pageFormatId = $pageFormatId;
    }

    /**
     * @return ProductCode
     */
    public function getProductCode()
    {
      return $this->productCode;
    }

    /**
     * @param ProductCode $productCode
     * @return RetrievePreviewVoucherPDFRequestType
     */
    public function setProductCode($productCode)
    {
      $this->productCode = $productCode;
      return $this;
    }

    /**
     * @return ImageID
     */
    public function getImageID()
    {
      return $this->imageID;
    }

    /**
     * @param ImageID $imageID
     * @return RetrievePreviewVoucherPDFRequestType
     */
    public function setImageID($imageID)
    {
      $this->imageID = $imageID;
      return $this;
    }

    /**
     * @return VoucherLayout
     */
    public function getVoucherLayout()
    {
      return $this->voucherLayout;
    }

    /**
     * @param VoucherLayout $voucherLayout
     * @return RetrievePreviewVoucherPDFRequestType
     */
    public function setVoucherLayout($voucherLayout)
    {
      $this->voucherLayout = $voucherLayout;
      return $this;
    }

    /**
     * @return PageFormatId
     */
    public function getPageFormatId()
    {
      return $this->pageFormatId;
    }

    /**
     * @param PageFormatId $pageFormatId
     * @return RetrievePreviewVoucherPDFRequestType
     */
    public function setPageFormatId($pageFormatId)
    {
      $this->pageFormatId = $pageFormatId;
      return $this;
    }

}
