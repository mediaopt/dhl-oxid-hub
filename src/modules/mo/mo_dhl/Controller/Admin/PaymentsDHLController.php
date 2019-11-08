<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class PaymentsDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        parent::render();
        $id = $this->getEditObjectId();
        if (isset($id) && $id != "-1") {
            $payment = oxNew(\OxidEsales\Eshop\Application\Model\Payment::class);
            $payment->load($id);
            $this->addTplParam("edit", $payment);
            if ($payment->isDerived()) {
                $this->addTplParam('readonly', true);
            }
        }
        return 'mo_dhl__payments_dhl.tpl';
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

        $payment = oxNew(\OxidEsales\Eshop\Application\Model\Payment::class);

        $payment->load($id);

        if ($payment->isDerived()) {
            return;
        }
        $payment->assign($params);
        $payment->save();
    }
}
