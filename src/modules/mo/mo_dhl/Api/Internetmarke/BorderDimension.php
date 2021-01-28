<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class BorderDimension
{

    /**
     * @var float $top
     */
    protected $top = null;

    /**
     * @var float $bottom
     */
    protected $bottom = null;

    /**
     * @var float $left
     */
    protected $left = null;

    /**
     * @var float $right
     */
    protected $right = null;

    /**
     * @param float $top
     * @param float $bottom
     * @param float $left
     * @param float $right
     */
    public function __construct($top, $bottom, $left, $right)
    {
      $this->top = $top;
      $this->bottom = $bottom;
      $this->left = $left;
      $this->right = $right;
    }

    /**
     * @return float
     */
    public function getTop()
    {
      return $this->top;
    }

    /**
     * @param float $top
     * @return BorderDimension
     */
    public function setTop($top)
    {
      $this->top = $top;
      return $this;
    }

    /**
     * @return float
     */
    public function getBottom()
    {
      return $this->bottom;
    }

    /**
     * @param float $bottom
     * @return BorderDimension
     */
    public function setBottom($bottom)
    {
      $this->bottom = $bottom;
      return $this;
    }

    /**
     * @return float
     */
    public function getLeft()
    {
      return $this->left;
    }

    /**
     * @param float $left
     * @return BorderDimension
     */
    public function setLeft($left)
    {
      $this->left = $left;
      return $this;
    }

    /**
     * @return float
     */
    public function getRight()
    {
      return $this->right;
    }

    /**
     * @param float $right
     * @return BorderDimension
     */
    public function setRight($right)
    {
      $this->right = $right;
      return $this;
    }

}
