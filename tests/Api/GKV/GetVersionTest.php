<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Api\GKV\Response\GetVersionResponse;
use Mediaopt\DHL\Api\GKV\Version;

/**
 * @author Mediaopt GmbH
 */
class GetVersionTest extends BaseGKVTest
{

    public function testGetVersion()
    {
        $gkv = $this->buildGKV();
        $response = $gkv->getVersion($this->createVersion());
        $this->assertInstanceOf(GetVersionResponse::class, $response);
        $this->assertInstanceOf(Version::class, $response->getVersion());
        $this->assertEquals(3, $response->getVersion()->getMajorRelease());
        $this->assertEquals(0, $response->getVersion()->getMinorRelease());
    }
}
