<?php

use Mediaopt\DHL\Address\Receiver;
use Mediaopt\DHL\Address\Sender;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use Mediaopt\DHL\Shipment\Shipment;


/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */
class ShipmentTest extends PHPUnit_Framework_TestCase
{

    protected function buildSampleOrder()
    {
        /** @var Receiver $receiverMock */
        $receiverMock = $this->getMockBuilder(Receiver::class)->disableOriginalConstructor()->getMock();
        /** @var Sender $senderMock */
        $senderMock = $this->getMockBuilder(Sender::class)->disableOriginalConstructor()->getMock();
        $reference = 'OXID-42';
        $weight = 42.23;
        $dateOfShipping = '15.08.2016';
        return new Shipment($reference, $receiverMock, $senderMock, $weight, $dateOfShipping);
    }

    public function testConstructorInjection()
    {
        /** @var Receiver $receiverMock */
        $receiverMock = $this->getMockBuilder(Receiver::class)->disableOriginalConstructor()->getMock();
        /** @var Sender $senderMock */
        $senderMock = $this->getMockBuilder(Sender::class)->disableOriginalConstructor()->getMock();
        $reference = 'OXID-42';
        $weight = 42.23;
        $dateOfShipping = '15.08.2016';
        $order = new Shipment($reference, $receiverMock, $senderMock, $weight, $dateOfShipping);
        $this->assertEquals($reference, $order->getReference());
        $this->assertSame($receiverMock, $order->getReceiver());
        $this->assertSame($senderMock, $order->getSender());
        $this->assertEquals($weight, $order->getWeight());
        $this->assertEquals($dateOfShipping, $order->getDateOfShipping());
    }

    public function testEkpSetter()
    {
        $order = $this->buildSampleOrder();
        $ekp = $this->getMockBuilder(Ekp::class)->disableOriginalConstructor()->getMock();
        /** @noinspection PhpParamsInspection */
        $this->assertSame($ekp, $order->setEkp($ekp)->getEkp());
    }

    public function testProcessSetter()
    {
        $order = $this->buildSampleOrder();
        $process = $this->getMockBuilder(Process::class)->disableOriginalConstructor()->getMock();
        /** @noinspection PhpParamsInspection */
        $this->assertSame($process, $order->setProcess($process)->getProcess());
    }

    public function testParticipationSetter()
    {
        $order = $this->buildSampleOrder();
        $participation = $this->getMockBuilder(Participation::class)->disableOriginalConstructor()->getMock();
        /** @noinspection PhpParamsInspection */
        $this->assertSame($participation, $order->setParticipation($participation)->getParticipation());
    }

    public function testBillingNumberSetter()
    {
        $ekp = Ekp::build('1234567890');
        $process = Process::build(Process::PAKET);
        $participation = Participation::build('AA');
        $billingNumber = new BillingNumber($ekp, $process, $participation);
        $order = $this->buildSampleOrder();
        $this->assertEquals($billingNumber, $order->setBillingNumber($billingNumber)->getBillingNumber());
    }

    public function testGettingABillingNumberBySettingEkpParticipationAndProcess()
    {
        $ekp = Ekp::build('1234567890');
        $process = Process::build(Process::PAKET);
        $participation = Participation::build('AA');
        $billingNumber = new BillingNumber($ekp, $process, $participation);
        $order = $this->buildSampleOrder()
            ->setEkp($ekp)
            ->setProcess($process)
            ->setParticipation($participation);
        $this->assertEquals($billingNumber, $order->getBillingNumber());
    }

    public function testGettingAnIncompleteBillingNumber()
    {
        $ekp = Ekp::build('1234567890');
        $process = Process::build(Process::PAKET);
        $participation = Participation::build('AA');
        /** @noinspection RepetitiveMethodCallsInspection */
        $ordersWithIncompletBillingNumber = [
            $this->buildSampleOrder(),
            $this->buildSampleOrder()->setEkp($ekp),
            $this->buildSampleOrder()->setEkp($ekp)->setParticipation($participation),
            $this->buildSampleOrder()->setProcess($process)->setParticipation($participation),
        ];
        foreach ($ordersWithIncompletBillingNumber as $order) {
            $this->assertNull($order->getBillingNumber());
        }
    }

    public function testGettingEkpProcessAndParticipationBySettingABillingNumber()
    {
        $ekp = Ekp::build('1234567890');
        $participation = Participation::build('AA');
        $process = Process::build(Process::PAKET);
        $billingNumber = new BillingNumber($ekp, $process, $participation);
        $order = $this->buildSampleOrder()->setBillingNumber($billingNumber);
        $this->assertEquals($ekp, $order->getEkp());
        $this->assertEquals($process, $order->getProcess());
        $this->assertEquals($participation, $order->getParticipation());
    }
}
