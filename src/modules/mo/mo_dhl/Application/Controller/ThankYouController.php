<?php
namespace Mediaopt\DHL\Application\Controller;

use Mediaopt\DHL\Application\Model\Order;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */


/** @noinspection LongInheritanceChainInspection */

/**
 * This class extends the thankyou controller with Wunschpaket functionality.
 *
 * @author derksen mediaopt GmbH
 */
class ThankYouController extends ThankYouController_parent
{
    /**
     * only show the tracking pixel on one out of 30 days
     * and only if an wunschpaket service is used
     *
     * @return bool
     */
    public function moDHLShowTrackingPixel()
    {
        /** @var Order $order */
        $order = $this->getOrder();
        $remark = $order->getFieldData('oxremark');
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        if (!$order->moDHLIsDeliveredToBranch() && !$wunschpaket->hasAnyWunschpaketService($remark)) {
            return false;
        }
        /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
        $day = (int) (time() / (60 * 60 * 24));
        return $day % 30 === 0;
    }
}
