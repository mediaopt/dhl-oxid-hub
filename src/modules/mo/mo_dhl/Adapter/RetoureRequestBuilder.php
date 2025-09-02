<?php


namespace Mediaopt\DHL\Adapter;


use Mediaopt\DHL\Api\Retoure\Country;
use Mediaopt\DHL\Api\Retoure\CustomsDocument;
use Mediaopt\DHL\Api\Retoure\CustomsDocumentPosition;
use Mediaopt\DHL\Api\Retoure\ReturnOrder;
use Mediaopt\DHL\Api\Retoure\SimpleAddress;
use Mediaopt\DHL\Api\Retoure\VAS;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLGoGreenProgram;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Core\Registry;

class RetoureRequestBuilder
{

    /**
     * @param Order $order
     * @return ReturnOrder
     */
    public function build(Order $order)
    {
        $returnOrder = new ReturnOrder();
        $returnOrder
            ->setCustomerReference($order->getFieldData('oxordernr'))
            ->setShipmentReference(Registry::getConfig()->getShopConfVar('mo_dhl__retoure_reference_prefix') . $order->getFieldData('oxordernr'))
            ->setReceiverId($this->buildReceiverId($order->getFieldData('oxbillcountryid')))
            ->setSenderAddress($this->buildSenderAddress($order))
            ->setEmail($order->getFieldData('oxbillemail'))
            ->setTelephoneNumber($order->moDHLGetAddressData('fon'));

        if ($vas = $this->buildVas()) {
            $returnOrder->setServices($vas);
        }

        $country = $this->buildCountry($order->getFieldData('oxbillcountryid'));
        if (!in_array($country->getCountryISOCode(), Country::EU_COUNTRIES_LIST)) {
            $returnOrder->setCustomsDocument($this->buildCustomsDocument($order));
        }

        return $returnOrder;
    }

    /**
     * @param string $countryId
     *
     * @return string
     */
    protected function buildReceiverId(string $countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        if (!$receiverId = $country->getFieldData('mo_dhl_retoure_receiver_id')) {
            throw new \InvalidArgumentException(sprintf(Registry::getLang()->translateString('MO_DHL__NO_RECEIVER_ID'), $country->getFieldData('title')));
        }
        return $receiverId;
    }

    /**
     * @param Order $order
     * @return SimpleAddress
     */
    protected function buildSenderAddress(Order $order)
    {
        $address = new SimpleAddress();
        $config = Registry::getConfig();
        $address->setName1($order->getFieldData('oxbillfname') . ' ' . $order->getFieldData('oxbilllname'))
            ->setName2($order->getFieldData('oxbillcompany') ?: '')
            ->setName3($order->getFieldData('oxbilladdinfo') ?: '')
            ->setStreetName($order->getFieldData('oxbillstreet'))
            ->setHouseNumber($order->getFieldData('oxbillstreetnr'))
            ->setPostCode($order->getFieldData('oxbillzip'))
            ->setCity($order->getFieldData('oxbillcity'))
            ->setCountry($this->buildCountry($order->getFieldData('oxbillcountryid')));
        return $address;
    }

    /**
     * @param string $countryId
     * @return Country
     */
    protected function buildCountry(string $countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return (new Country())
            ->setCountryISOCode($country->getFieldData('oxisoalpha3'))
            ->setCountry($country->getFieldData('oxtitle'));
    }

    /**
     * @param Order $order
     * @return CustomsDocument
     */
    protected function buildCustomsDocument(Order $order)
    {
        return (new CustomsDocument())
            ->setCurrency($order->getFieldData('oxcurrency'))
            ->setOriginalShipmentNumber($order->getFieldData('oxtrackcode'))
            ->setOriginalOperator($order->getFieldData('mo_dhl_operator'))
            ->setPositions($this->buildPositions($order));
    }

    /**
     * @param Order $order
     * @return CustomsDocumentPosition[]
     */
    protected function buildPositions(Order $order)
    {
        $positions = [];
        /** @var OrderArticle $orderArticle */
        foreach ($order->getOrderArticles() as $orderArticle) {
            $count = $orderArticle->getFieldData('oxamount');
            $positions[] = (new CustomsDocumentPosition())
                ->setPositionDescription(substr($orderArticle->getArticle()->getFieldData('oxtitle'), 0, 50))
                ->setCount($count)
                ->setWeightInGrams($orderArticle->getFieldData('oxweight') * 1000.0 * $count)
                ->setValues($orderArticle->getPrice()->getPrice() * $count)
                ->setArticleReference($orderArticle->getArticle()->getId());
        }

        return $positions;
    }


    /**
     * @return VAS|null
     */
    protected function buildVas()
    {
        if (Registry::getConfig()->getShopConfVar('mo_dhl__go_green_program') == MoDHLGoGreenProgram::GO_GREEN_PLUS) {
            return (new VAS())->setGoGreenPlus(true);
        }

        return null;
    }
}
