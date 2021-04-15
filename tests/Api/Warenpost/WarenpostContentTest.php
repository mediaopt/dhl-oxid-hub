<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\Warenspost;

use Mediaopt\DHL\Exception\WarenpostException;
use Mediaopt\DHL\Api\Warenpost\Content;

/**
 * @author Mediaopt GmbH
 */
class WarenpostContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Content
     */
    public function buildCorrectContent(): Content
    {
        return new Content(120.50, 1200, 2);
    }

    public function testSuccess()
    {
        $content = $this->buildCorrectContent();
        $content->setContentPieceOrigin('DE');
        $content->setContentPieceDescription('Trousers');
        $content->setContentPieceHsCode(1245678);
        $content->setContentPieceIndexNumber(1337);
        $content->validate();
        $this->assertEquals(
            $content->toArray(),
            [
                'contentPieceValue' => 120.50,
                'contentPieceNetweight' => 1200,
                'contentPieceAmount' => 2,
                'contentPieceOrigin' => 'DE',
                'contentPieceDescription' => 'Trousers',
                'contentPieceHsCode' => 1245678,
                'contentPieceIndexNumber' => 1337,
            ]
        );
    }

    public function testSuccessMinimal()
    {
        $content = $this->buildCorrectContent();
        $content->validate();
        $this->assertEquals(
            $content->toArray(),
            [
                'contentPieceValue' => 120.50,
                'contentPieceNetweight' => 1200,
                'contentPieceAmount' => 2,
            ]
        );
    }

    public function testZeroPieceDescriptionThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $content = $this->buildCorrectContent();
        $content->setContentPieceDescription('');
        $content->validate();
    }

    public function testBigPieceDescriptionThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $content = $this->buildCorrectContent();
        $content->setContentPieceDescription("It's big description, enough for an error!");
        $content->validate();
    }

    public function testZeroNetweightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceNetweight should be between/');
        $content = new Content(120.50, 0, 2);
        $content->validate();
    }

    public function testBigNetweightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceNetweight should be between/');
        $content = new Content(120.50, 2100, 2);
        $content->validate();
    }

    public function testWrongCountryCodeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceOrigin length should be exactly/');
        $content = $this->buildCorrectContent();
        $content->setContentPieceOrigin('DEU');
        $content->validate();
    }

    public function testZeroPieceAmountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceAmount should be between/');
        $content = new Content(120.50, 100, 0);
        $content->validate();
    }

    public function testBigPieceAmountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceAmount should be between/');
        $content = new Content(120.50, 100, 100);
        $content->validate();
    }
}