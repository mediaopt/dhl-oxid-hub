<?php

namespace Mediaopt\DHL\Controller;

/**
 * @author Mediaopt GmbH
 */
class YellowBoxController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     * @param mixed[] $option
     * @return string[]
     */
    public static function formatWunschtag($option)
    {
        $weekDayLabel = \OxidEsales\Eshop\Core\Registry::getLang()->translateString("MO_DHL__DAY_OF_WEEK_{$option['datetime']->format('w')}");
        return ['label' => "{$weekDayLabel},<br/>{$option['datetime']->format('d.')}", 'excluded' => $option['excluded']];
    }

    /**
     */
    public function render()
    {
        $zip = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('zip');
        $this->respond($zip !== '' ? $this->retrieveOptions($zip) : []);
    }

    /**
     * @param mixed $response
     */
    protected function respond($response)
    {
        $responseJson = json_encode($response);
        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($responseJson));
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Utils::class)->showMessageAndExit($responseJson);
    }

    /**
     * @param string $zip
     * @return mixed[]
     */
    protected function retrieveOptions($zip)
    {
        return ['preferredTimes' => $this->getPreferredTimes($zip), 'preferredDays' => $this->getPreferredDays($zip)];
    }

    /**
     * @param string $zip
     * @return string[]
     */
    protected function getPreferredTimes($zip)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->isWunschzeitActive() ? $wunschpaket->getWunschzeitOptions($zip) : [];
    }

    /**
     * @param string $zip
     * @return mixed[][]
     */
    protected function getPreferredDays($zip)
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->isWunschtagActive() ? array_map('self::formatWunschtag', $wunschpaket->getWunschtagOptions($basket, $zip)) : [];
    }
}
