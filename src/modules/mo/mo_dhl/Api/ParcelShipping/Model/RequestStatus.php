<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class RequestStatus extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * 
     *
     * @var string
     */
    protected $title;
    /**
     * The status code of the response. Usually, but not necessarliy the HTTP status code.
     *
     * @var int
     */
    protected $statusCode;
    /**
     * A URI reference that identifies the specific occurrence of the problem.
     *
     * @var string
     */
    protected $instance;
    /**
     * 
     *
     * @var string
     */
    protected $detail;
    /**
     * 
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }
    /**
     * 
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title) : self
    {
        $this->initialized['title'] = true;
        $this->title = $title;
        return $this;
    }
    /**
     * The status code of the response. Usually, but not necessarliy the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }
    /**
     * The status code of the response. Usually, but not necessarliy the HTTP status code.
     *
     * @param int $statusCode
     *
     * @return self
     */
    public function setStatusCode(int $statusCode) : self
    {
        $this->initialized['statusCode'] = true;
        $this->statusCode = $statusCode;
        return $this;
    }
    /**
     * A URI reference that identifies the specific occurrence of the problem.
     *
     * @return string
     */
    public function getInstance() : string
    {
        return $this->instance;
    }
    /**
     * A URI reference that identifies the specific occurrence of the problem.
     *
     * @param string $instance
     *
     * @return self
     */
    public function setInstance(string $instance) : self
    {
        $this->initialized['instance'] = true;
        $this->instance = $instance;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getDetail() : string
    {
        return $this->detail;
    }
    /**
     * 
     *
     * @param string $detail
     *
     * @return self
     */
    public function setDetail(string $detail) : self
    {
        $this->initialized['detail'] = true;
        $this->detail = $detail;
        return $this;
    }
}