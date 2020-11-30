<?php

namespace Mediaopt\DHL\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Exception\WebserviceException;
use Mediaopt\DHL\ServiceProvider\BasicServiceProvider;
use Mediaopt\DHL\ServiceProvider\ServiceProviderList;
use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;

/** @noinspection LongInheritanceChainInspection */

/**
 * This controller is used to call the finder asynchronously and returning the result as JSON object.
 *
 * @author Mediaopt GmbH
 */
class FinderController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     * @var Standortsuche
     */
    protected $standortsuche;

    /**
     * Uses the adapter to process the supplied input and sends the result.
     * If an exception occurs, a response containing the error is sent back.
     */
    public function render()
    {
        try {
            $serviceProviders = $this->resolveQuery($this->buildQuery());
            if (!empty($serviceProviders)) {
                $response = ['status' => 'success', 'payload' => $serviceProviders];
            } else {
                $message = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MO_DHL__ERROR_NO_RESULT');
                $response = ['status' => 'error', 'payload' => $message];
            }
            $this->respond($response);
        } catch (\RuntimeException $ex) {
            $this->respond(['status' => 'error', 'payload' => $ex->getMessage()]);
        } catch (\Exception $ex) {
            \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->getLogger()->error('Exception encountered: ' . $ex->getMessage(), ['exception' => $ex]);
            $this->respond(['status' => 'error', 'payload' => 'Unable to process request.']);
        }
    }

    /**
     * If the supplied string is a valid UTF-8 string, it is returned without changes.
     * If the supplied string is a valid ISO-8859-1 or ISO-8859-15 string, we convert it to UTF-8 and return the
     * converted string. Otherwise, we return the string without changes.
     *
     * @param string $string
     * @return string
     */
    protected function convertToUtf8($string)
    {
        foreach (['ISO-8859-1', 'ISO-8859-15'] as $charset) {
            if (mb_check_encoding($string, $charset)) {
                return mb_convert_encoding($string, 'UTF-8', $charset);
            }
        }
        return $string;
    }

    /**
     * Turns the supplied response into a JSON object, sends it and exits.
     *
     * @param array $response
     */
    protected function respond(array $response)
    {
        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($responseJson));
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Utils::class)->showMessageAndExit($responseJson);
    }

    /**
     * @return \Mediaopt\DHL\FinderQuery
     */
    protected function buildQuery()
    {
        $config = $this->getConfig();
        $street = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('street');
        $locality = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('locality');
        [$postalCode, $city] = explode(' ', $locality);
        $street = trim($street);
        $postalCode = trim($postalCode);
        $city = trim($city);

        $desiredBranchTypes = array_map('boolval', array_map([$config, 'getRequestParameter'], ['packstation', 'filiale', 'paketshop']));
        $parameters = array_merge([\Mediaopt\DHL\FinderQuery::class, $street, $postalCode, $city], $desiredBranchTypes);
        return call_user_func_array('oxNew', $parameters);
    }

    /**
     * @return \Mediaopt\DHL\FinderQuery[]
     */
    protected function buildQueries()
    {
        $config = $this->getConfig();
        $street = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('street');
        $locality = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('locality');
        $addresses = array_map('trim', [$locality . ' ' . $street, $locality, $street]);
        $desiredBranchTypes = array_map('boolval', array_map([$config, 'getRequestParameter'], ['packstation', 'filiale', 'paketshop']));
        $queries = [];
        foreach (array_unique($addresses) as $address) {
            $parameters = array_merge([\Mediaopt\DHL\FinderQuery::class, $address], $desiredBranchTypes);
            $queries[] = call_user_func_array('oxNew', $parameters);
        }
        return $queries;
    }

    /**
     * @param \Mediaopt\DHL\FinderQuery[] $queries
     * @return array
     */
    protected function resolveQuerySet($queries)
    {
        foreach ($queries as $query) {
            try {
                $providers = $this->resolveQuery($query);
                if ($providers !== []) {
                    return $providers;
                }
            } catch (WebserviceException $exception) {
                // We will retry with the next combination.
            }
        }
        return [];
    }

    /**
     * Finds Packstations, Postfiliales and Paketshops in the vicinity of the given city/zip/street combination.
     *
     * @param \Mediaopt\DHL\FinderQuery $query
     * @return array
     * @throws \RuntimeException
     */
    protected function resolveQuery(\Mediaopt\DHL\FinderQuery $query)
    {
        $adapter = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class);
        return array_map([$this, 'prepareServiceProvider'], array_slice($this->restrictTimetables($this->findServiceProviders($query)), 0, $adapter->getMaximumHits()));
    }

    /**
     * @param \Mediaopt\DHL\FinderQuery $query
     * @return ServiceProviderList
     * @throws \Mediaopt\DHL\Exception\WebserviceException
     */
    protected function findServiceProviders(\Mediaopt\DHL\FinderQuery $query)
    {
        $standortsuche = $this->getStandortsuche();
        $serviceProviders = $standortsuche->getParcellocationByAddress($query->getAddress(), $query->getPostalCode(), $query->getCity())->toArray();
        return $this->filterServiceProviders($serviceProviders, $query);
    }

    /**
     * @param BasicServiceProvider[]    $serviceProviders
     * @param \Mediaopt\DHL\FinderQuery $query
     * @return ServiceProviderList
     */
    protected function filterServiceProviders($serviceProviders, \Mediaopt\DHL\FinderQuery $query)
    {
        $adapter = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class);
        $serviceProviderList = new ServiceProviderList($serviceProviders);
        $packstation = $query->searchesForPackstation() && $adapter->canPackstationBeSelected();
        $filiale = $query->searchesForPostfiliale() && $adapter->canPostfilialeBeSelected();
        $paketshop = $query->searchesForPaketshop() && $adapter->canPaketshopBeSelected();
        return $serviceProviderList->filter($packstation, $filiale, $paketshop);
    }

    /**
     * @param ServiceProviderList $serviceProviders
     * @return BasicServiceProvider[]
     */
    protected function restrictTimetables($serviceProviders)
    {
        $providers = [];
        foreach ($serviceProviders->toArray() as $provider) {
            $providers[] = $provider->filterTimetable(TimeInfo::OPENING_HOURS);
        }
        return $providers;
    }

    /**
     * @param BasicServiceProvider $serviceProvider
     * @return array
     */
    protected function prepareServiceProvider(BasicServiceProvider $serviceProvider)
    {
        $languageCode = \OxidEsales\Eshop\Core\Registry::getLang()->getLanguageAbbr();
        $serviceProviderArray = $serviceProvider->toArray();
        $serviceProviderArray['remark'] = array_key_exists($languageCode, $serviceProviderArray['remark']) ? $serviceProviderArray['remark'][$languageCode] : '';
        return $serviceProviderArray;
    }

    /**
     * @return Standortsuche
     */
    protected function getStandortsuche()
    {
        if ($this->standortsuche !== null) {
            return $this->standortsuche;
        }

        $this->standortsuche = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->buildStandortsuche();
        return $this->standortsuche;
    }
}
