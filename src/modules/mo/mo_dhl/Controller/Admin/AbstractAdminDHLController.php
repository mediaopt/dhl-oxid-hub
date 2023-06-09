<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Controller\Admin;


use Mediaopt\DHL\Model\MoDHLInternetmarkeProduct;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
abstract class AbstractAdminDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    /**
     * @return string
     */
    protected abstract function moDHLGetTemplateName() : string;

    /**
     * @return string
     */
    protected abstract function moDHLGetBaseClassName() : string;

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        parent::render();
        if ($model = $this->getEditObject()) {
            $this->addTplParam("edit", $model);
            if ($model->isDerived()) {
                $this->addTplParam('readonly', true);
            }
        }
        return $this->moDHLGetTemplateName();
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

        $model = oxNew($this->moDHLGetBaseClassName());

        $model->load($id);

        if ($model->isDerived()) {
            return;
        }
        $model->assign($params);
        $model->save();
    }

    /**
     * @return object|null
     */
    protected function getEditObject()
    {
        $id = $this->getEditObjectId();
        if (!isset($id) || $id === "-1") {
            return null;
        }
        $model = \oxNew($this->moDHLGetBaseClassName());
        $model->load($id);
        return $model;
    }
}
