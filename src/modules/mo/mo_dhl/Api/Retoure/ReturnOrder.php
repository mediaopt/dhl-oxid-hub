<?php
namespace Mediaopt\DHL\Api\Retoure;

/**
 * ** This file was generated automatically, you might want to avoid editing it **
 */
class ReturnOrder extends SwaggerModel
{
	/**
	 * @var string
	 * @required
	 */
	protected $receiverId;

	/**
	 * @var string
	 */
	protected $customerReference = '';

	/**
	 * @var string
	 */
	protected $shipmentReference = '';

	/**
	 * @var SimpleAddress
	 * @required
	 */
	protected $senderAddress;

	/**
	 * @var string
	 */
	protected $email = '';

	/**
	 * @var string
	 */
	protected $telephoneNumber = '';

	/**
	 * @var integer
	 */
	protected $weightInGrams = 0;

	/**
	 * @var float
	 */
	protected $value = 0.0;

	/**
	 * @var CustomsDocument
	 */
	protected $customsDocument;

	/**
	 * The type of document(s) to return in the response':' The SHIPMENT_LABEL only, the QR_LABEL or BOTH.
	 * @var string
	 */
	protected $returnDocumentType = '';


	/**
	 * @return string
	 */
	public function getReceiverId()
	{
		return $this->receiverId;
	}


	/**
	 * @param string $receiverId
	 *
	 * @return $this
	 */
	public function setReceiverId($receiverId)
	{
		$this->receiverId = $receiverId;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCustomerReference()
	{
		return $this->customerReference;
	}


	/**
	 * @param string $customerReference
	 *
	 * @return $this
	 */
	public function setCustomerReference($customerReference)
	{
		$this->customerReference = $customerReference;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getShipmentReference()
	{
		return $this->shipmentReference;
	}


	/**
	 * @param string $shipmentReference
	 *
	 * @return $this
	 */
	public function setShipmentReference($shipmentReference)
	{
		$this->shipmentReference = $shipmentReference;

		return $this;
	}


	/**
	 * @return SimpleAddress
	 */
	public function getSenderAddress()
	{
		return $this->senderAddress;
	}


	/**
	 * @param SimpleAddress $senderAddress
	 *
	 * @return $this
	 */
	public function setSenderAddress(SimpleAddress $senderAddress)
	{
		$this->senderAddress = $senderAddress;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}


	/**
	 * @param string $email
	 *
	 * @return $this
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getTelephoneNumber()
	{
		return $this->telephoneNumber;
	}


	/**
	 * @param string $telephoneNumber
	 *
	 * @return $this
	 */
	public function setTelephoneNumber($telephoneNumber)
	{
		$this->telephoneNumber = $telephoneNumber;

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
	public function getValue()
	{
		return $this->value;
	}


	/**
	 * @param float $value
	 *
	 * @return $this
	 */
	public function setValue($value)
	{
		$this->value = $value;

		return $this;
	}


	/**
	 * @return CustomsDocument
	 */
	public function getCustomsDocument()
	{
		return $this->customsDocument;
	}


	/**
	 * @param CustomsDocument $customsDocument
	 *
	 * @return $this
	 */
	public function setCustomsDocument(CustomsDocument $customsDocument)
	{
		$this->customsDocument = $customsDocument;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getReturnDocumentType()
	{
		return $this->returnDocumentType;
	}


	/**
	 * @param string $returnDocumentType
	 *
	 * @return $this
	 */
	public function setReturnDocumentType($returnDocumentType)
	{
		$this->returnDocumentType = $returnDocumentType;

		return $this;
	}
}
