<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrievePreviewVoucherPNGRequestType
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
     * @param ProductCode $productCode
     * @param VoucherLayout $voucherLayout
     */
    public function __construct($productCode, $voucherLayout)
    {
      $this->productCode = $productCode;
      $this->voucherLayout = $voucherLayout;
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
     * @return RetrievePreviewVoucherPNGRequestType
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
     * @return RetrievePreviewVoucherPNGRequestType
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
     * @return RetrievePreviewVoucherPNGRequestType
     */
    public function setVoucherLayout($voucherLayout)
    {
      $this->voucherLayout = $voucherLayout;
      return $this;
    }

}
