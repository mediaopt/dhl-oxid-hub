<?php

namespace Mediaopt\DHL\Api\GKV;

class NameType
{

    /**
     * @var string $name1
     */
    protected $name1 = null;

    /**
     * @var string $name2
     */
    protected $name2 = null;

    /**
     * @var string $name3
     */
    protected $name3 = null;

    /**
     * @param string $name1
     * @param string $name2
     * @param string $name3
     */
    public function __construct($name1, $name2 = null, $name3 = null)
    {
        $this->name1 = $name1;
        $this->name2 = $name2;
        $this->name3 = $name3;
    }

    /**
     * @return string
     */
    public function getName1()
    {
        return $this->name1;
    }

    /**
     * @param string $name1
     * @return NameType
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
     * @return NameType
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
     * @return NameType
     */
    public function setName3($name3)
    {
        $this->name3 = $name3;
        return $this;
    }

}
