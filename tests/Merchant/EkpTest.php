<?php

use Mediaopt\DHL\Merchant\Ekp;
use PhpUnit\Framework\TestCase;

class EkpTest extends TestCase
{
    public function testThatTheEkpRepresentsItsActualString()
    {
        $faker = \Faker\Factory::create();
        $numberOfTests = 100;
        for ($i = 0; $i < $numberOfTests; $i++) {
            $number = implode('', $faker->randomElements(range(0, 9), 10, true));
            $ekp = Ekp::build($number);
            $this->assertEquals($number, $ekp);
        }
    }

    public function testThatAnEkpThatIsTooShortLeadsToAnException()
    {
        $faker = \Faker\Factory::create();
        $exceptions = 0;
        $numberOfTests = 10;
        for ($i = 0; $i < $numberOfTests; $i++) {
            try {
                $number = implode('', $faker->randomElements(range(0, 9), $i, true));
                Ekp::build($number);
            } catch (InvalidArgumentException $exception) {
                $exceptions++;
            }
        }
        $this->assertEquals($numberOfTests, $exceptions);
    }

    public function testThatAnEkpThatIsTooLongLeadsToAnException()
    {
        $faker = \Faker\Factory::create();
        $exceptions = 0;
        $smallestLength = 11;
        $numberOfTests = 10;
        for ($i = $smallestLength; $i < $smallestLength + $numberOfTests; $i++) {
            try {
                $number = implode('', $faker->randomElements(range(0, 9), $i, true));
                Ekp::build($number);
            } catch (InvalidArgumentException $exception) {
                $exceptions++;
            }
        }
        $this->assertEquals($numberOfTests, $exceptions);
    }

    public function testThatAnEkpThatIsNotNumericLeadsToAnException()
    {
        $faker = \Faker\Factory::create();
        $elements = $faker->randomElements(range(0, 9), 9);

        $exceptions = 0;
        $numberOfTests = 50;
        for ($i = 0; $i < $numberOfTests; $i++) {
            do {
                $character = $faker->randomAscii;
            } while (ctype_digit($character));

            try {
                $number = $faker->shuffle(implode('', array_merge($elements, [$character])));
                Ekp::build($number);
            } catch (InvalidArgumentException $exception) {
                $exceptions++;
            }
        }
        $this->assertEquals($numberOfTests, $exceptions);
    }
}
