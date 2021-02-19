<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SearchParameterList
{

    /**
     * @var SearchParameterType $searchParameter
     */
    protected $searchParameter = null;

    /**
     * @param SearchParameterType $searchParameter
     */
    public function __construct($searchParameter)
    {
      $this->searchParameter = $searchParameter;
    }

    /**
     * @return SearchParameterType
     */
    public function getSearchParameter()
    {
      return $this->searchParameter;
    }

    /**
     * @param SearchParameterType $searchParameter
     * @return SearchParameterList
     */
    public function setSearchParameter($searchParameter)
    {
      $this->searchParameter = $searchParameter;
      return $this;
    }

}
