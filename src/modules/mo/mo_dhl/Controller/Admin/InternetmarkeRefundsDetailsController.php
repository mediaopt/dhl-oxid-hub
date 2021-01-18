<?php


namespace Mediaopt\DHL\Controller\Admin;


use Mediaopt\DHL\Api\Internetmarke\RetoureStateType;
use Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType;
use Mediaopt\DHL\Model\MoDHLInternetmarkeRefund;
use OxidEsales\Eshop\Core\DatabaseProvider;

class InternetmarkeRefundsDetailsController extends AbstractAdminDHLController
{

    /**
     * @return string
     */
    protected function moDHLGetTemplateName() : string
    {
        return 'mo_dhl__internetmarke_refunds_details.tpl';
    }

    /**
     * @return string
     */
    protected function moDHLGetBaseClassName() : string
    {
        return MoDHLInternetmarkeRefund::class;
    }

    /**
     * @throws \Exception
     */
    public function updateRefundStatus()
    {
        $adapter = new \Mediaopt\DHL\Adapter\DHLAdapter();
        $api = $adapter->buildInternetmarkeRefund();
        $request = new RetrieveRetoureStateRequestType();
        $request->setRetoureTransactionId($this->getEditObjectId());
        $response = $api->retrieveRetoureState($request);
        /** @var RetoureStateType $retoureStatus */
        $retoureStatus = $response->getRetoureState()[0];
        $refund = $this->getEditObject();
        //var_dump($retoureStatus);
        $refund->assign([
            'status' => $this->extractStatus($retoureStatus),
        ]);
        $refund->save();
        $retoureStatusArray = [
            'created' =>  \DateTime::createFromFormat('dmY-his', $retoureStatus->getCreationDate())->format(\OxidEsales\Eshop\Core\Registry::getLang()->translateString('fullDateFormat')),
            'refunded' => $retoureStatus->getTotalCount() - $retoureStatus->getCountStillOpen(),
            'total' => $retoureStatus->getTotalCount(),
        ];
        $this->addTplParam('refundStatus', $retoureStatusArray);
        return;
    }

    /**
     * @param RetoureStateType $response
     * @return string
     */
    public function extractStatus(RetoureStateType $response)
    {
        if ($response->getCountStillOpen() === 0) {
            return 'finished';
        }
        if ($response->getCountStillOpen() === $response->getTotalCount()) {
            return 'requested';
        }
        return 'in progress';
    }
}
