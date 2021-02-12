<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountryGroupType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $shortName
     */
    protected $shortName = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var string $user
     */
    protected $user = null;

    /**
     * @param string $shortName
     * @param string $user
     */
    public function __construct($shortName, $user)
    {
      $this->shortName = $shortName;
      $this->user = $user;
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
     * @return CountryGroupType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
      return $this->shortName;
    }

    /**
     * @param string $shortName
     * @return CountryGroupType
     */
    public function setShortName($shortName)
    {
      $this->shortName = $shortName;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }

    /**
     * @param string $description
     * @return CountryGroupType
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
      return $this->user;
    }

    /**
     * @param string $user
     * @return CountryGroupType
     */
    public function setUser($user)
    {
      $this->user = $user;
      return $this;
    }

}
