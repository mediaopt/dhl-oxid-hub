<?php


namespace Mediaopt\DHL\Api\ProdWS;

class FormatedTextType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var TextRowType[] $textRow
     */
    protected $textRow = null;

    /**
     * @param TextRowType[] $textRow
     */
    public function __construct(array $textRow)
    {
      $this->textRow = $textRow;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     * @return FormatedTextType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return TextRowType[]
     */
    public function getTextRow()
    {
      return $this->textRow;
    }

    /**
     * @param TextRowType[] $textRow
     * @return FormatedTextType
     */
    public function setTextRow(array $textRow)
    {
      $this->textRow = $textRow;
      return $this;
    }

}
