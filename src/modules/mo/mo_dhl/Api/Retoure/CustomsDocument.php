<?php
namespace Mediaopt\DHL\Api\Retoure;

/**
 * ** This file was generated automatically, you might want to avoid editing it **
 *
 * A customs form ("CN23") is only needed for returns from outside the EEC (e.g. Switzerland).
 */
class CustomsDocument extends SwaggerModel
{
	/**
	 * Currency the returned goods were payed in.
	 * @var string
	 * @required
	 */
	protected $currency;

	/**
	 * Original shipment number.
	 * @var string
	 * @required
	 */
	protected $originalShipmentNumber;

	/**
	 * Company that delivered the original parcel.
	 * @var string
	 * @required
	 */
	protected $originalOperator;

	/**
	 * Additional documents.
	 * @var string
	 */
	protected $acommpanyingDocument = '';

	/**
	 * Invoice number of the returned goods.
	 * @var string
	 */
	protected $originalInvoiceNumber = '';

	/**
	 * Date of the invoice number.
	 * @var string
	 */
	protected $originalInvoiceDate = '';

	/**
	 * Comment.
	 * @var string
	 */
	protected $comment = '';

	/**
	 * The customs items to be declared.
	 * @var CustomsDocumentPosition[]
	 * @required
	 */
	protected $positions;


	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}


	/**
	 * @param string $currency
	 *
	 * @return $this
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginalShipmentNumber()
	{
		return $this->originalShipmentNumber;
	}


	/**
	 * @param string $originalShipmentNumber
	 *
	 * @return $this
	 */
	public function setOriginalShipmentNumber($originalShipmentNumber)
	{
		$this->originalShipmentNumber = $originalShipmentNumber;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginalOperator()
	{
		return $this->originalOperator;
	}


	/**
	 * @param string $originalOperator
	 *
	 * @return $this
	 */
	public function setOriginalOperator($originalOperator)
	{
		$this->originalOperator = $originalOperator;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getAcommpanyingDocument()
	{
		return $this->acommpanyingDocument;
	}


	/**
	 * @param string $acommpanyingDocument
	 *
	 * @return $this
	 */
	public function setAcommpanyingDocument($acommpanyingDocument)
	{
		$this->acommpanyingDocument = $acommpanyingDocument;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginalInvoiceNumber()
	{
		return $this->originalInvoiceNumber;
	}


	/**
	 * @param string $originalInvoiceNumber
	 *
	 * @return $this
	 */
	public function setOriginalInvoiceNumber($originalInvoiceNumber)
	{
		$this->originalInvoiceNumber = $originalInvoiceNumber;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginalInvoiceDate()
	{
		return $this->originalInvoiceDate;
	}


	/**
	 * @param string $originalInvoiceDate
	 *
	 * @return $this
	 */
	public function setOriginalInvoiceDate($originalInvoiceDate)
	{
		$this->originalInvoiceDate = $originalInvoiceDate;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}


	/**
	 * @param string $comment
	 *
	 * @return $this
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;

		return $this;
	}


	/**
	 * @return CustomsDocumentPosition[]
	 */
	public function getPositions()
	{
		return $this->positions;
	}


	/**
	 * @param CustomsDocumentPosition[] $positions
	 *
	 * @return $this
	 */
	public function setPositions(array $positions)
	{
		$this->positions = $positions;

		return $this;
	}


	/**
	 * @param CustomsDocumentPosition $position
	 *
	 * @return $this
	 */
	public function addPosition(CustomsDocumentPosition $position)
	{
		$this->positions[] = $position;

		return $this;
	}
}
