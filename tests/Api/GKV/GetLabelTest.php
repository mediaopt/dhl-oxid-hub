<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Api\GKV\Request\GetLabelRequest;
use Mediaopt\DHL\Api\GKV\Response\GetLabelResponse;

/**
 * @author Mediaopt GmbH
 */
class GetLabelTest extends BaseGKVTest
{

    public function testGetLabelForIncorrectShipment()
    {
        $gkv = $this->buildGKV();
        $request = new GetLabelRequest($this->createVersion(), $this->getUniqueShipmentId());
        $response = $gkv->getLabel($request);
        $this->assertInstanceOf(GetLabelResponse::class, $response);
        $this->assertEquals(2000, $response->getStatus()->getStatusCode());
        $this->assertEquals(2000, $response->getLabelData()[0]->getStatus()->getStatusCode());
        $this->assertNull($response->getLabelData()[0]->getLabelUrl());
    }
}
