<?php
namespace Mediaopt\DHL\Api\Retoure;

/**
 * ** This file was generated automatically, you might want to avoid editing it **
 *
 * Represents the returned items.
 */
class CustomsDocumentPosition extends SwaggerModel
{
	/**
	 * Description of the returend item.
	 * @var string
	 * @required
	 */
	protected $positionDescription;

	/**
	 * Amount of items declared per position.
	 * @var integer
	 * @required
	 */
	protected $count;

	/**
	 * Weight of the returend item.
	 * @var integer
	 * @required
	 */
	protected $weightInGrams;

	/**
	 * Value of returned item.
	 * @var float
	 * @required
	 */
	protected $values;

	/**
	 * Country the returned item was produced.
	 * @var string
	 */
	protected $originCountry = '';

	/**
	 * Reference of the returned item.
	 * @var string
	 * @required
	 */
	protected $articleReference;

	/**
	 * Customs tariff number.
	 * @var string
	 */
	protected $tarifNumber = '';


	/**
	 * @return string
	 */
	public function getPositionDescription()
	{
		return $this->positionDescription;
	}


	/**
	 * @param string $positionDescription
	 *
	 * @return $this
	 */
	public function setPositionDescription($positionDescription)
	{
		$this->positionDescription = $positionDescription;

		return $this;
	}


	/**
	 * @return integer
	 */
	public function getCount()
	{
		return $this->count;
	}


	/**
	 * @param integer $count
	 *
	 * @return $this
	 */
	public function setCount($count)
	{
		$this->count = $count;

		return $this;
	}


	/**
	 * @return integer
	 */
	public function getWeightInGrams()
	{
		return $this->weightInGrams;
	}


	/**
	 * @param integer $weightInGrams
	 *
	 * @return $this
	 */
	public function setWeightInGrams($weightInGrams)
	{
		$this->weightInGrams = $weightInGrams;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getValues()
	{
		return $this->values;
	}


	/**
	 * @param float $values
	 *
	 * @return $this
	 */
	public function setValues($values)
	{
		$this->values = $values;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginCountry()
	{
		return $this->originCountry;
	}


	/**
	 * @param string $originCountry
	 *
	 * @return $this
	 */
	public function setOriginCountry($originCountry)
	{
		$this->originCountry = $originCountry;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getArticleReference()
	{
		return $this->articleReference;
	}


	/**
	 * @param string $articleReference
	 *
	 * @return $this
	 */
	public function setArticleReference($articleReference)
	{
		$this->articleReference = $articleReference;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getTarifNumber()
	{
		return $this->tarifNumber;
	}


	/**
	 * @param string $tarifNumber
	 *
	 * @return $this
	 */
	public function setTarifNumber($tarifNumber)
	{
		$this->tarifNumber = $tarifNumber;

		return $this;
	}
}
