<?php


namespace Mediaopt\DHL\Api\ProdWS;

class InternationalDestinationAreaType
{

    /**
     * @var CountryList $countryList
     */
    protected $countryList = null;

    /**
     * @var CountryNegativList $countryNegativList
     */
    protected $countryNegativList = null;

    /**
     * @var CountryGroupList $countryGroupList
     */
    protected $countryGroupList = null;

    /**
     * @var ChargeZoneList $chargeZoneList
     */
    protected $chargeZoneList = null;


    public function __construct()
    {

    }

    /**
     * @return CountryList
     */
    public function getCountryList()
    {
      return $this->countryList;
    }

    /**
     * @param CountryList $countryList
     * @return InternationalDestinationAreaType
     */
    public function setCountryList($countryList)
    {
      $this->countryList = $countryList;
      return $this;
    }

    /**
     * @return CountryNegativList
     */
    public function getCountryNegativList()
    {
      return $this->countryNegativList;
    }

    /**
     * @param CountryNegativList $countryNegativList
     * @return InternationalDestinationAreaType
     */
    public function setCountryNegativList($countryNegativList)
    {
      $this->countryNegativList = $countryNegativList;
      return $this;
    }

    /**
     * @return CountryGroupList
     */
    public function getCountryGroupList()
    {
      return $this->countryGroupList;
    }

    /**
     * @param CountryGroupList $countryGroupList
     * @return InternationalDestinationAreaType
     */
    public function setCountryGroupList($countryGroupList)
    {
      $this->countryGroupList = $countryGroupList;
      return $this;
    }

    /**
     * @return ChargeZoneList
     */
    public function getChargeZoneList()
    {
      return $this->chargeZoneList;
    }

    /**
     * @param ChargeZoneList $chargeZoneList
     * @return InternationalDestinationAreaType
     */
    public function setChargeZoneList($chargeZoneList)
    {
      $this->chargeZoneList = $chargeZoneList;
      return $this;
    }

}
