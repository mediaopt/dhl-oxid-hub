<?php
namespace Mediaopt\DHL\Api\Retoure;

/**
 * ** This file was generated automatically, you might want to avoid editing it **
 */
class Country extends SwaggerModel
{
    public const EU_COUNTRIES_LIST = [
        "AUT","BEL","BGR","HRV","CYP","CZE","DNK","EST","FIN",
        "FRA","DEU","GRC","HUN","IRL","ITA","LVA","LTU","LUX",
        "MLT","NLD","POL","PRT","ROU","SVK","SVN","ESP","SWE"
    ];

	/**
	 * @var string
	 * @required
	 */
	protected $countryISOCode;

	/**
	 * @var string
	 */
	protected $country = '';

	/**
	 * @var string
	 */
	protected $state = '';


	/**
	 * @return string
	 */
	public function getCountryISOCode()
	{
		return $this->countryISOCode;
	}


	/**
	 * @param string $countryISOCode
	 *
	 * @return $this
	 */
	public function setCountryISOCode($countryISOCode)
	{
		$this->countryISOCode = $countryISOCode;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}


	/**
	 * @param string $country
	 *
	 * @return $this
	 */
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getState()
	{
		return $this->state;
	}


	/**
	 * @param string $state
	 *
	 * @return $this
	 */
	public function setState($state)
	{
		$this->state = $state;

		return $this;
	}
}
