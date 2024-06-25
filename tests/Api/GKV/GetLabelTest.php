<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

/**
 * @author Mediaopt GmbH
 */
class GetLabelTest extends BaseGKVTest
{

    public function testGetLabelForIncorrectShipment()
    {
        $gkv = $this->buildParcelShipping();
        $response = $gkv->getLabel([
            'token' => $this->getUniqueShipmentId(),
        ]);
        $this->assertNull($response);
    }
}
