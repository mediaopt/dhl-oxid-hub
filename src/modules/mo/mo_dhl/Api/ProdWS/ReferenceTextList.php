<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ReferenceTextList
{

    /**
     * @var FormatedTextType $referenceText
     */
    protected $referenceText = null;

    /**
     * @param FormatedTextType $referenceText
     */
    public function __construct($referenceText)
    {
      $this->referenceText = $referenceText;
    }

    /**
     * @return FormatedTextType
     */
    public function getReferenceText()
    {
      return $this->referenceText;
    }

    /**
     * @param FormatedTextType $referenceText
     * @return ReferenceTextList
     */
    public function setReferenceText($referenceText)
    {
      $this->referenceText = $referenceText;
      return $this;
    }

}
