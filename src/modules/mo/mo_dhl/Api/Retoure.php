<?php


namespace Mediaopt\DHL\Api;


use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Adapter\ReturnRequestBuilder;
use Mediaopt\DHL\Application\Model\Order;
use Psr\Log\LoggerInterface;

class Retoure extends Base
{

    /**
     * @var Credentials|null
     */
    protected $customerCredentials = null;

    /**
     * @var ReturnRequestBuilder|null
     */
    protected $returnRequestBuilder = null;

    /**
     * @param Credentials     $credentials
     * @param Credentials     $customerCredentials
     * @param LoggerInterface $logger
     * @param ClientInterface $client
     */
    public function __construct(Credentials $credentials, Credentials $customerCredentials, LoggerInterface $logger, ClientInterface $client)
    {
        parent::__construct($credentials, $logger, $client);
        $this->customerCredentials = $customerCredentials;
        $this->returnRequestBuilder = new ReturnRequestBuilder();
    }

    /**
     * @return string
     */
    protected function getIdentifier()
    {
        return 'returns';
    }

    /**
     * @return string[][]
     */
    protected function buildRequestOptions()
    {
        $options = parent::buildRequestOptions();
        $options['headers'] = [
            'DPDHL-User-Authentication-Token' => $this->customerCredentials->getBasicAuth(),
            'Accept'                          => 'application/json',
        ];
        return $options;
    }

    /**
     * @param Order $order
     * @return \stdClass
     */
    public function createRetoure(Order $order)
    {
        return $this->callApi('', ['json' => $this->returnRequestBuilder->build($order)], 'post');
    }
}