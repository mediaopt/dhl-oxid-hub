<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\Warenspost;

use Mediaopt\DHL\Exception\WarenpostException;
use Mediaopt\DHL\Warenpost\Awb;

/**
 * @author Mediaopt GmbH
 */
class WarenpostAwbTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessAwb()
    {
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'GPP', 'PRIORITY', 'P', 'Job ref', 5, '+4935120681234');
        $awb->validate();
        $this->assertEquals(
            $awb->toArray(),
            [
                'customerEkp' => 9012345678,
                'contactName' => 'Max Mustermann',
                'awbCopyCount' => 3,
                'product' => 'GPP',
                'serviceLevel' => 'PRIORITY',
                'itemFormat' => 'P',
                'jobReference' => 'Job ref',
                'totalWeight' => 5,
                'telephoneNumber' => '+4935120681234',
            ]
        );
    }

    public function testOutOfRangeCopyCountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/awbCopyCount should be between/');
        $awb = new Awb('9012345678', 'Max Mustermann', Awb::COPY_COUNT_MAX + 13, 'GPP', 'PRIORITY', 'P');
        $awb->validate();
    }

    public function testFloatCopyCountCastToInt()
    {
        $awb = new Awb('9012345678', 'Max Mustermann', 13.37, 'GPP', 'PRIORITY', 'P');
        $awb->validate();
        $this->assertEquals(
            $awb->toArray(),
            [
                'customerEkp' => '9012345678',
                'contactName' => 'Max Mustermann',
                'awbCopyCount' => 13,
                'product' => 'GPP',
                'serviceLevel' => 'PRIORITY',
                'itemFormat' => 'P'
            ]
        );
    }

    public function testShortContactNameAwbThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contactName length should be between/');
        $awb = new Awb('9012345678', '', 3, 'GPP', 'PRIORITY', 'P');
        $awb->validate();
    }

    public function testLongContactNameAwbThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contactName length should be between/');
        $awb = new Awb('9012345678', "Realy, realy, realy long name. It's long, isn't it?", 3, 'GPP', 'PRIORITY', 'P');
        $awb->validate();
    }

    public function testWrongItemFormatThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown itemFormat/');
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'GPP', 'PRIORITY', 'error');
        $awb->validate();
    }

    public function testSuccessZeroJobReferenceAwb()
    {
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'GPP', 'PRIORITY', 'P');
        $awb->validate();
        $this->assertEquals(
            $awb->toArray(),
            [
                'customerEkp' => '9012345678',
                'contactName' => 'Max Mustermann',
                'awbCopyCount' => 3,
                'product' => 'GPP',
                'serviceLevel' => 'PRIORITY',
                'itemFormat' => 'P'
            ]
        );
    }

    public function testLongJobReferenceAwbThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/jobReference length should be between/');
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'GPP', 'PRIORITY', 'P', "it's huge JobReference");
        $awb->validate();
    }

    public function testWrongProductThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown product/');
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'error', 'PRIORITY', 'P');
        $awb->validate();
    }

    public function testWrongServiceLevelThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown serviceLevel/');
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'GPP', 'error', 'P');
        $awb->validate();
    }

    public function testWrongProductForServiceLevelThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/for serviceLevel/');
        $awb = new Awb('9012345678', 'Max Mustermann', 3, 'GPP', 'REGISTERED', 'P');
        $awb->validate();
    }
}