<?php
namespace Mediaopt\DHL\Api\Retoure;

/**
 * ** This file was generated automatically, you might want to avoid editing it **
 */
class SimpleAddress extends SwaggerModel
{
	/**
	 * @var string
	 * @required
	 */
	protected $name1;

	/**
	 * @var string
	 */
	protected $name2 = '';

	/**
	 * @var string
	 */
	protected $name3 = '';

	/**
	 * @var string
	 * @required
	 */
	protected $streetName;

	/**
	 * @var string
	 * @required
	 */
	protected $houseNumber;

	/**
	 * @var string
	 * @required
	 */
	protected $postCode;

	/**
	 * @var string
	 * @required
	 */
	protected $city;

	/**
	 * @var Country
	 */
	protected $country;


	/**
	 * @return string
	 */
	public function getName1()
	{
		return $this->name1;
	}


	/**
	 * @param string $name1
	 *
	 * @return $this
	 */
	public function setName1($name1)
	{
		$this->name1 = $name1;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getName2()
	{
		return $this->name2;
	}


	/**
	 * @param string $name2
	 *
	 * @return $this
	 */
	public function setName2($name2)
	{
		$this->name2 = $name2;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getName3()
	{
		return $this->name3;
	}


	/**
	 * @param string $name3
	 *
	 * @return $this
	 */
	public function setName3($name3)
	{
		$this->name3 = $name3;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getStreetName()
	{
		return $this->streetName;
	}


	/**
	 * @param string $streetName
	 *
	 * @return $this
	 */
	public function setStreetName($streetName)
	{
		$this->streetName = $streetName;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getHouseNumber()
	{
		return $this->houseNumber;
	}


	/**
	 * @param string $houseNumber
	 *
	 * @return $this
	 */
	public function setHouseNumber($houseNumber)
	{
		$this->houseNumber = $houseNumber;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this->postCode;
	}


	/**
	 * @param string $postCode
	 *
	 * @return $this
	 */
	public function setPostCode($postCode)
	{
		$this->postCode = $postCode;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}


	/**
	 * @param string $city
	 *
	 * @return $this
	 */
	public function setCity($city)
	{
		$this->city = $city;

		return $this;
	}


	/**
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
	}


	/**
	 * @param Country $country
	 *
	 * @return $this
	 */
	public function setCountry(Country $country)
	{
		$this->country = $country;

		return $this;
	}
}
