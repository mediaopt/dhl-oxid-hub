<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Api\GKV\Request\GetManifestRequest;
use Mediaopt\DHL\Api\GKV\Response\GetManifestResponse;

/**
 * @author Mediaopt GmbH
 */
class GetManifestTest extends BaseGKVTest
{

    public function testGetManifestForToday()
    {
        $request = new GetManifestRequest($this->createVersion(), (new \DateTime())->format('Y-m-d'));
        $response = $this->buildGKV()->getManifest($request);
        $this->assertInstanceOf(GetManifestResponse::class, $response);
        $this->assertNotFalse(base64_decode($response->getManifestData()));
        $this->assertEquals(0, $response->getStatus()->getStatusCode());
    }

    public function testGetManifestForLastWeek()
    {
        $manifestDate = (new \DateTime('-7 days'))->format('Y-m-d');
        $request = new GetManifestRequest($this->createVersion(), $manifestDate);
        $response = $this->buildGKV()->getManifest($request);
        $this->assertInstanceOf(GetManifestResponse::class, $response);
        $this->assertNotFalse(base64_decode($response->getManifestData()));
        $this->assertEquals(0, $response->getStatus()->getStatusCode());
    }

    public function testGetManifestForNextWeek()
    {
        $manifestDate = (new \DateTime('+7 days'))->format('Y-m-d');
        $request = new GetManifestRequest($this->createVersion(), $manifestDate);
        $response = $this->buildGKV()->getManifest($request);
        $this->assertInstanceOf(GetManifestResponse::class, $response);
        $this->assertEquals(2000, $response->getStatus()->getStatusCode());
    }
}
