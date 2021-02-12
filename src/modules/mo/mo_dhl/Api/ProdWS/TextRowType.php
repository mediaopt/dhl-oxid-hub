<?php


namespace Mediaopt\DHL\Api\ProdWS;

class TextRowType
{

    /**
     * @var TextBlockType[] $textBlock
     */
    protected $textBlock = null;

    /**
     * @param TextBlockType[] $textBlock
     */
    public function __construct(array $textBlock)
    {
      $this->textBlock = $textBlock;
    }

    /**
     * @return TextBlockType[]
     */
    public function getTextBlock()
    {
      return $this->textBlock;
    }

    /**
     * @param TextBlockType[] $textBlock
     * @return TextRowType
     */
    public function setTextBlock(array $textBlock)
    {
      $this->textBlock = $textBlock;
      return $this;
    }

}
