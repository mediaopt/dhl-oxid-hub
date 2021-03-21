<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\Warenspost;

use Mediaopt\DHL\Api\Warenpost\PickupType;
use Mediaopt\DHL\Exception\WarenpostException;
use Mediaopt\DHL\Api\Warenpost\Paperwork;

/**
 * @author Mediaopt GmbH
 */
class WarenpostPaperworkTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $aws = new Paperwork("Max Mustermann", "Job ref");
        $aws->validate();
        $this->assertEquals(
            $aws->toArray(),
            [
                'contactName' => 'Max Mustermann',
                'jobReference' => 'Job ref',
                'awbCopyCount' => 1,
                'pickupType' => PickupType::CUSTOMER_DROP_OFF
            ]
        );
    }
    public function testBigJobRefrenceThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/jobReference length should be between/');
        $paperwork = new Paperwork("Max Mustermann", 'Big job reference. Enought for an error.');
        $paperwork->validate();
    }
}
