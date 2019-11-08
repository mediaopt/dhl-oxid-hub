<?php

use Mediaopt\DHL\Shipment\Process;

class ProcessTest extends PHPUnit_Framework_TestCase
{
    const PROCESS_NUMBERS = ['01', '06', '53', '54', '55', '82', '86', '87'];

    const SERVICE_IDENTIFIERS = [
        'V01PAK',
        'V01PRIO',
        'V06PAK',
        'V01PAK',
        'V53WPAK',
        'V54EPAK',
        'V55PAK',
        'V86PARCEL',
        'V87PARCEL',
        'V82PARCEL',
    ];

    const PROCESS_IDENTIFIERS = [
        Process::PAKET,
        Process::PAKET_PRIO,
        Process::PAKET_TAGGLEICH,
        Process::RETOURE,
        Process::PAKET_INTERNATIONAL,
        Process::EUROPAKET,
        Process::PAKET_CONNECT,
        Process::PAKET_INTERNATIONAL_AT,
        Process::PAKET_AT,
        Process::PAKET_CONNECT_AT,
    ];

    public function testThatAProcessWithAnInvalidIdentifierCannotBeInstantiated()
    {
        $numberOfTests = 100;
        $expectedExceptions = $numberOfTests;
        $actualExceptions = 0;
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $numberOfTests; $i++) {
            $length = mt_rand(0, 10);
            $identifier = '';
            for ($j = 0; $j < $length; $j++) {
                $identifier .= $faker->randomLetter;
            }
            if (in_array($identifier, self::PROCESS_IDENTIFIERS, true)) {
                $expectedExceptions--;
                continue;
            }

            try {
                Process::build($identifier);
            } catch (InvalidArgumentException $exception) {
                $actualExceptions++;
            }
        }
        $this->assertEquals($expectedExceptions, $actualExceptions);
    }

    public function testTheStringRepresentationOfAProcess()
    {
        foreach (self::PROCESS_IDENTIFIERS as $number) {
            $processNumber = Process::build($number);
            $this->assertTrue(in_array((string)$processNumber, self::PROCESS_NUMBERS, true));
        }
    }

    public function testTheServiceIdentifiersOfAProcess()
    {
        foreach (self::PROCESS_IDENTIFIERS as $number) {
            $processNumber = Process::build($number);
            $this->assertTrue(in_array($processNumber->getServiceIdentifier(), self::SERVICE_IDENTIFIERS, true));
        }
    }

    public function testThatEachKeyOfGetProcessesIsAValidProcessIdentifier()
    {
        $invalidIdentifiers = [];
        foreach (array_keys(Process::getAvailableProcesses()) as $identifier) {
            try {
                Process::build($identifier);
            } catch (InvalidArgumentException $exception) {
                $invalidIdentifiers[] = $identifier;
            }
        }
        $this->assertEquals([], $invalidIdentifiers);
    }
}
