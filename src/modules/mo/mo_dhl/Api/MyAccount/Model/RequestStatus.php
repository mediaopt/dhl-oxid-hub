<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

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
     * http status code
     *
     * @var int
     */
    protected $statusCode;
    /**
     * http status reason
     *
     * @var string
     */
    protected $title;
    /**
     * description of error reason
     *
     * @var string
     */
    protected $detail;
    /**
     * source of error
     *
     * @var string
     */
    protected $instance;
    /**
     * http status code
     *
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }
    /**
     * http status code
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
     * http status reason
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }
    /**
     * http status reason
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
     * description of error reason
     *
     * @return string
     */
    public function getDetail() : string
    {
        return $this->detail;
    }
    /**
     * description of error reason
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
    /**
     * source of error
     *
     * @return string
     */
    public function getInstance() : string
    {
        return $this->instance;
    }
    /**
     * source of error
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
}