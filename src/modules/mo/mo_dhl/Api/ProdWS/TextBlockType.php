<?php


namespace Mediaopt\DHL\Api\ProdWS;

class TextBlockType
{

    /**
     * @var string $font
     */
    protected $font = null;

    /**
     * @var float $size
     */
    protected $size = null;

    /**
     * @var string $style
     */
    protected $style = null;

    /**
     * @var boolean $underline
     */
    protected $underline = null;

    /**
     * @var string $text
     */
    protected $text = null;

    /**
     * @param string $text
     */
    public function __construct($text)
    {
      $this->text = $text;
    }

    /**
     * @return string
     */
    public function getFont()
    {
      return $this->font;
    }

    /**
     * @param string $font
     * @return TextBlockType
     */
    public function setFont($font)
    {
      $this->font = $font;
      return $this;
    }

    /**
     * @return float
     */
    public function getSize()
    {
      return $this->size;
    }

    /**
     * @param float $size
     * @return TextBlockType
     */
    public function setSize($size)
    {
      $this->size = $size;
      return $this;
    }

    /**
     * @return string
     */
    public function getStyle()
    {
      return $this->style;
    }

    /**
     * @param string $style
     * @return TextBlockType
     */
    public function setStyle($style)
    {
      $this->style = $style;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getUnderline()
    {
      return $this->underline;
    }

    /**
     * @param boolean $underline
     * @return TextBlockType
     */
    public function setUnderline($underline)
    {
      $this->underline = $underline;
      return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
      return $this->text;
    }

    /**
     * @param string $text
     * @return TextBlockType
     */
    public function setText($text)
    {
      $this->text = $text;
      return $this;
    }

}
