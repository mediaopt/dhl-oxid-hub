<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\Warenspost;

use Mediaopt\DHL\Exception\WarenpostException;
use Mediaopt\DHL\Api\Warenpost\Paperwork;

/**
 * @author Mediaopt GmbH
 */
class WarenpostPaperworkTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $aws = new Paperwork("Max Mustermann", 3, "Job ref", "DHL_GLOBAL_MAIl", "Mustergasse 12", "2019-01-02", "MIDDAY", "+4935120681234");
        $aws->validate();
        $this->assertEquals(
            $aws->toArray(),
            [
                'contactName' => 'Max Mustermann',
                'awbCopyCount' => 3,
                'jobReference' => 'Job ref',
                'pickupType' => 'DHL_GLOBAL_MAIl',
                'pickupLocation' => 'Mustergasse 12',
                'pickupDate' => '2019-01-02',
                'pickupTimeSlot' => 'MIDDAY',
                'telephoneNumber' => '+4935120681234',
            ]
        );
    }

    public function testZeroAwbCopyCountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/awbCopyCount should be between/');
        $paperwork = new Paperwork("Max Mustermann", 0);
        $paperwork->validate();
    }

    public function testBigAwbCopyCountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/awbCopyCount should be between/');
        $paperwork = new Paperwork("Max Mustermann", 199);
        $paperwork->validate();
    }

    public function testWrongPickupDateFormatThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/wrong pickupDate format/');
        $paperwork = new Paperwork("Max Mustermann", 3, "Job ref", "DHL_EXPRESS", null, "2019/01/02");
        $paperwork->validate();
    }

    public function testWrongPickupTypeForDateThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/if you want to select pickup date/');
        $paperwork = new Paperwork("Max Mustermann", 3, "Job ref", "CUSTOMER_DROP_OFF", null, "2019-01-02");
        $paperwork->validate();
    }

    public function testWrongPickupTypeForLocationThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/if you want to select pickup location/');
        $paperwork = new Paperwork("Max Mustermann", 3, "Job ref", "CUSTOMER_DROP_OFF", "Mustergasse 12");
        $paperwork->validate();
    }

    public function testWrongPickupTimeSlotThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown pickupTimeSlot/');
        $paperwork = new Paperwork("Max Mustermann", 3, "Job ref", "DHL_GLOBAL_MAIl", null, null, "MIDNIGHT");
        $paperwork->validate();
    }

    public function testPickupTimeSlotIsNecessary()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/pickup time slot is nesessary/');
        $paperwork = new Paperwork("Max Mustermann", 3, "Job ref", "DHL_GLOBAL_MAIl");
        $paperwork->validate();
    }

    public function testSuccessWithDefaultPickupType()
    {
        $aws = new Paperwork("Max Mustermann", 3);
        $aws->validate();
        $this->assertEquals(
            $aws->toArray(),
            [
                'contactName' => 'Max Mustermann',
                'awbCopyCount' => 3,
                'pickupType' => 'CUSTOMER_DROP_OFF',
            ]
        );
    }

    public function testWrongPickupTypeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown pickupType/');
        $paperwork = new Paperwork("Max Mustermann", 3, "Job ref", "error");
        $paperwork->validate();
    }
}
