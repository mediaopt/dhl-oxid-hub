<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Controller\Admin;


use Mediaopt\DHL\Model\MoDHLInternetmarkeProductList;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class DeliverySetDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        parent::render();
        $this->addTplParam('processes', Process::getAvailableProcesses());
        $this->addTplParam('endorsements', $this->getEndorsements());
        $id = $this->getEditObjectId();
        if (isset($id) && $id != "-1") {
            $deliverySet = oxNew(\OxidEsales\Eshop\Application\Model\DeliverySet::class);
            $deliverySet->load($id);
            $this->addTplParam("edit", $deliverySet);
            if ($deliverySet->isDerived()) {
                $this->addTplParam('readonly', true);
            }
        }
        return 'mo_dhl__deliveryset_dhl.tpl';
    }

    /**
     * @extend
     * @throws \Exception
     */
    public function save()
    {
        parent::save();
        $id = $this->getEditObjectId();
        if ($id === "-1") {
            return;
        }

        $params = Registry::getConfig()->getRequestParameter("editval");

        $deliverySet = oxNew(\OxidEsales\Eshop\Application\Model\DeliverySet::class);

        $deliverySet->load($id);

        if ($deliverySet->isDerived()) {
            return;
        }
        $deliverySet->assign($params);
        try {
            $this->validateProcess($params['oxdeliveryset__mo_dhl_process']);
            if ($params['oxdeliveryset__mo_dhl_process'] === Process::INTERNETMARKE) {
                $this->validateInternetmarkeProduct($params['oxdeliveryset__mo_dhl_participation']);
            } else {
                $this->validateParticipation($params['oxdeliveryset__mo_dhl_participation']);
            }
        } catch (\InvalidArgumentException $exception) {
            $this->setEditObjectId($deliverySet->getId());
            return;
        }
        if (empty($params['oxdeliveryset__mo_dhl_process'])) {
            $deliverySet->oxdeliveryset__mo_dhl_process = null;
        }
        if (empty($params['oxdeliveryset__mo_dhl_participation'])) {
            $deliverySet->oxdeliveryset__mo_dhl_participation = null;
        }
        $deliverySet->save();
    }

    /**
     * @param string $identifier
     * @throws \InvalidArgumentException
     */
    private function validateProcess($identifier)
    {
        if (empty($identifier)) {
            return;
        }
        try {
            Process::build($identifier);
        } catch (\InvalidArgumentException $exception) {
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PROCESS_IDENTIFIER_ERROR');
            throw $exception;
        }
    }

    /**
     * @param string $participation
     * @throws \InvalidArgumentException
     */
    private function validateParticipation($participation)
    {
        if (empty($participation)) {
            return;
        }
        try {
            Participation::build($participation);
        } catch (\InvalidArgumentException $exception) {
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PARTICIPATION_NUMBER_ERROR');
            throw $exception;
        }
    }

    /**
     * @param $productCode
     * @throws \InvalidArgumentException
     */
    private function validateInternetmarkeProduct($productCode)
    {
        $productExists = DatabaseProvider::getDb()->getOne('SELECT 1 from mo_dhl_internetmarke_products where OXID = ?', [$productCode]);
        if (!$productExists) {
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__INTERNETMARKE_PRODUCT_ERROR');
            throw new \InvalidArgumentException('MO_DHL__INTERNETMARKE_PRODUCT_ERROR');
        }
    }

    /**
     * @return bool
     */
    public function usesInternetmarke()
    {
        $deliverySet = oxNew(\OxidEsales\Eshop\Application\Model\DeliverySet::class);
        $deliverySet->load($this->getEditObjectId());
        return $deliverySet->getFieldData('mo_dhl_process') === Process::INTERNETMARKE;
    }

    /**
     * template function
     */
    public function getInternetmarkeProductsBySearchString()
    {
        $searchString = Registry::getConfig()->getRequestParameter("search");
        $productsList = oxNew(MoDHLInternetmarkeProductList::class);
        $productsList->searchForProduct($searchString);

        $this->addTplParam('suggestions', $productsList->getArray());
        $this->setTemplateName('mo_dhl__internetmarke_products_search.tpl');
    }

    /**
     * @return string[]
     */
    protected function getEndorsements()
    {
        return [
            Registry::getLang()->translateString('MO_DHL__ENDORSEMENT_RETURN'),
            Registry::getLang()->translateString('MO_DHL__ENDORSEMENT_ABANDONMENT'),
        ];
    }
}
