<?php


use Mediaopt\DHL\Shipment\Participation;
use PhpUnit\Framework\TestCase;

class ParticipationTest extends TestCase
{
    public function testThatAParticipationNumberRepresentsItsActualStringInUppercase()
    {
        $characterSet = $this->getAlphaNumericCharacters();
        $faker = \Faker\Factory::create();
        $numberOfTests = 100;
        for ($i = 0; $i < $numberOfTests; $i++) {
            $number = implode('', $faker->randomElements($characterSet, 2, true));
            $participation = Participation::build($number);
            $this->assertEquals(strtoupper($number), $participation);
        }
    }

    protected function getAlphaNumericCharacters()
    {
        return array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    }

    public function testThatAParticipationNumberThatIsTooShortLeadsToAnException()
    {
        $faker = \Faker\Factory::create();
        $exceptions = 0;
        $maximumLength = 1;
        for ($i = 0; $i <= $maximumLength; $i++) {
            try {
                $number = implode('', $faker->randomElements(range(0, 9), $i, true));
                Participation::build($number);
            } catch (InvalidArgumentException $exception) {
                $exceptions++;
            }
        }
        $this->assertEquals($maximumLength + 1, $exceptions);
    }

    public function testThatAParticipationNumberThatIsTooLongLeadsToAnException()
    {
        $faker = \Faker\Factory::create();
        $characterSet = $this->getAlphaNumericCharacters();
        $exceptions = 0;
        $numberOfTests = 10;
        $smallestLength = 3;
        for ($i = $smallestLength; $i < $smallestLength + $numberOfTests; $i++) {
            try {
                $number = implode('', $faker->randomElements($characterSet, $i, true));
                Participation::build($number);
            } catch (InvalidArgumentException $exception) {
                $exceptions++;
            }
        }
        $this->assertEquals($numberOfTests, $exceptions);
    }

    public function testThatAParticipationNumberThatIsNotAlphaNumericLeadsToAnException()
    {
        $faker = \Faker\Factory::create();
        $element = $faker->randomElement($this->getAlphaNumericCharacters());

        $exceptions = 0;
        $numberOfTests = 50;
        for ($i = 0; $i < $numberOfTests; $i++) {
            do {
                $character = $faker->randomAscii;
            } while (ctype_alnum($character));

            try {
                $number = $faker->shuffle($element . $character);
                Participation::build($number);
            } catch (InvalidArgumentException $exception) {
                $exceptions++;
            }
        }
        $this->assertEquals($numberOfTests, $exceptions);
    }
}
