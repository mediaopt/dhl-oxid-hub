<?php


namespace Mediaopt\DHL\Api;


use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Adapter\RetoureRequestBuilder;
use Mediaopt\DHL\Api\Retoure\RetoureResponse;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLLabel;
use org\bovigo\vfs\DirectoryIterationTestCase;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;
use Psr\Log\LoggerInterface;

class Retoure extends Base
{

    /**
     * @var Credentials|null
     */
    protected $customerCredentials = null;

    /**
     * @var RetoureRequestBuilder|null
     */
    protected $retoureRequestBuilder = null;

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
        $this->retoureRequestBuilder = new RetoureRequestBuilder();
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
        return new RetoureResponse($this->callApi('', ['json' => $this->retoureRequestBuilder->build($order)], 'post'));
    }

    /**
     * @param Order           $order
     * @param RetoureResponse $response
     * @throws \Exception
     */
    public function handleResponse(Order $order, RetoureResponse $response)
    {
        $label = MoDHLLabel::fromOrderAndRetoure($order, $response);
        $label->save();

        (oxNew(\OxidEsales\Eshop\Core\Email::class))->moDHLSendRetoureLabelToCustomer($order);
    }

}
