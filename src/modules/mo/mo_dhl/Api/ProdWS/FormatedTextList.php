<?php


namespace Mediaopt\DHL\Api\ProdWS;

class FormatedTextList
{

    /**
     * @var FormatedTextType $formatedText
     */
    protected $formatedText = null;

    /**
     * @param FormatedTextType $formatedText
     */
    public function __construct($formatedText)
    {
      $this->formatedText = $formatedText;
    }

    /**
     * @return FormatedTextType
     */
    public function getFormatedText()
    {
      return $this->formatedText;
    }

    /**
     * @param FormatedTextType $formatedText
     * @return FormatedTextList
     */
    public function setFormatedText($formatedText)
    {
      $this->formatedText = $formatedText;
      return $this;
    }

}
