<?php

use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use PhpUnit\Framework\TestCase;

class BillingNumberTest extends TestCase
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create();
    }

    public function testThatTheBillingNumberIsTheConcatenationOfEkpAndProcessNumberAndParticipationNumber()
    {
        $numberOfTests = 100;
        for ($i = 0; $i < $numberOfTests; $i++) {
            $ekp = $this->generateEkp();
            $processNumber = $this->generateProcessNumber();
            $participationNumber = $this->generateParticipationNumber();
            $billing = new BillingNumber($ekp, $processNumber, $participationNumber);
            $this->assertEquals($ekp . $processNumber . $participationNumber, $billing);
            $this->assertEquals(14, strlen($billing));
            $this->assertTrue(ctype_alnum((string)$billing));
        }
    }

    /**
     * @return Ekp
     */
    protected function generateEkp()
    {
        $number = implode('', $this->faker->randomElements(range(0, 9), 10, true));
        return Ekp::build($number);
    }

    /**
     * @return Process
     */
    protected function generateProcessNumber()
    {
        $number = $this->faker->randomElement(ProcessTest::PROCESS_IDENTIFIERS);
        return Process::build($number);
    }

    /**
     * @return Participation
     */
    protected function generateParticipationNumber()
    {
        $characterSet = array_merge(range(0, 9), range('A', 'Z'));
        $number = implode('', $this->faker->randomElements($characterSet, 2, true));
        return Participation::build($number);
    }

    public function testThatTheGettersReturnTheSameObject()
    {
        $ekp = $this->generateEkp();
        $processNumber = $this->generateProcessNumber();
        $participationNumber = $this->generateParticipationNumber();
        $billing = new BillingNumber($ekp, $processNumber, $participationNumber);
        $this->assertSame($ekp, $billing->getEkp());
        $this->assertSame($processNumber, $billing->getProcess());
        $this->assertSame($participationNumber, $billing->getParticipation());
    }
}
