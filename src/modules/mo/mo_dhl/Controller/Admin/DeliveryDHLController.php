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
class DeliveryDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
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
            $delivery = oxNew(\OxidEsales\Eshop\Application\Model\Delivery::class);
            $delivery->load($id);
            $this->addTplParam("edit", $delivery);
            if ($delivery->isDerived()) {
                $this->addTplParam('readonly', true);
            }
        }
        return 'mo_dhl__delivery_dhl.tpl';
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

        $delivery = oxNew(\OxidEsales\Eshop\Application\Model\Delivery::class);

        $delivery->load($id);

        if ($delivery->isDerived()) {
            return;
        }
        $delivery->assign($params);
        $delivery->save();
    }
}
