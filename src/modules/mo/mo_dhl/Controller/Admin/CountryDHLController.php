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
class CountryDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
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
            $country = oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
            $country->load($id);
            $this->addTplParam("edit", $country);
            if ($country->isDerived()) {
                $this->addTplParam('readonly', true);
            }
        }
        return 'mo_dhl__country_dhl.tpl';
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

        $country = oxNew(\OxidEsales\Eshop\Application\Model\Country::class);

        $country->load($id);

        if ($country->isDerived()) {
            return;
        }
        $country->assign($params);
        $country->save();
    }
}
