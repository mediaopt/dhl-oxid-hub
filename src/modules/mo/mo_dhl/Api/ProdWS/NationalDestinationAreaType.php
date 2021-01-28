<?php


namespace Mediaopt\DHL\Api\ProdWS;

class NationalDestinationAreaType
{

    /**
     * @var NationalZipCodeListType[] $nationalZipCodeList
     */
    protected $nationalZipCodeList = null;

    /**
     * @var NationalZipCodeGroupType[] $nationalZipCodeGroup
     */
    protected $nationalZipCodeGroup = null;


    public function __construct()
    {

    }

    /**
     * @return NationalZipCodeListType[]
     */
    public function getNationalZipCodeList()
    {
      return $this->nationalZipCodeList;
    }

    /**
     * @param NationalZipCodeListType[] $nationalZipCodeList
     * @return NationalDestinationAreaType
     */
    public function setNationalZipCodeList(array $nationalZipCodeList = null)
    {
      $this->nationalZipCodeList = $nationalZipCodeList;
      return $this;
    }

    /**
     * @return NationalZipCodeGroupType[]
     */
    public function getNationalZipCodeGroup()
    {
      return $this->nationalZipCodeGroup;
    }

    /**
     * @param NationalZipCodeGroupType[] $nationalZipCodeGroup
     * @return NationalDestinationAreaType
     */
    public function setNationalZipCodeGroup(array $nationalZipCodeGroup = null)
    {
      $this->nationalZipCodeGroup = $nationalZipCodeGroup;
      return $this;
    }

}
