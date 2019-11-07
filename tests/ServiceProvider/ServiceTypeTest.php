<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 derksen mediaopt GmbH
 */

namespace sdk\ServiceProvider;

use Mediaopt\DHL\Exception\ServiceProviderException;
use Mediaopt\DHL\ServiceProvider\ServiceType;

class ServiceTypeTest extends \PHPUnit_Framework_TestCase
{

    public function testCreationOfServiceType()
    {
        foreach (ServiceType::$SERVICE_TYPES as $serviceType) {
            $serviceTypeObject = ServiceType::create($serviceType);
            $this->assertInstanceOf(ServiceType::class, $serviceTypeObject);
            $this->assertEquals($serviceType, (string)$serviceTypeObject);
        }
    }

    public function testCreationOfInvalidServiceType()
    {
        $this->expectException(ServiceProviderException::class);
        ServiceType::create('INVALID_SERVICE_TYPE');
    }

}
