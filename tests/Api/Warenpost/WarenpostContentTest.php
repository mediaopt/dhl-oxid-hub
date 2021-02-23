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
        return new Content(1234567890, "Trousers", "120.50", 1200, "DE", 2, 1337);
    }

    public function testSuccess()
    {
        $content = $this->buildCorrectContent();
        $content->validate();
        $this->assertEquals(
            $content->toArray(),
            [
                'contentPieceHsCode' => 1234567890,
                'contentPieceDescription' => 'Trousers',
                'contentPieceValue' => '120.50',
                'contentPieceNetweight' => 1200,
                'contentPieceOrigin' => 'DE',
                'contentPieceAmount' => 2,
                'contentPieceIndexNumber' => 1337,
            ]
        );
    }

    public function testSuccessWithoutIndex()
    {
        $content = new Content(1234567890, "Trousers", "120.50", 1200, "DE", 2);
        $content->validate();
        $this->assertEquals(
            $content->toArray(),
            [
                'contentPieceHsCode' => 1234567890,
                'contentPieceDescription' => 'Trousers',
                'contentPieceValue' => '120.50',
                'contentPieceNetweight' => 1200,
                'contentPieceOrigin' => 'DE',
                'contentPieceAmount' => 2
            ]
        );
    }

    public function testZeroPieceDescriptionThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $content = new Content(1234567890, "", "120.50", 1200, "DE", 2);
        $content->validate();
    }

    public function testBigPieceDescriptionThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $content = new Content(1234567890, "It's big description, enough for an error!", "120.50", 1200, "DE", 2);
        $content->validate();
    }

    public function testZeroNetweightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceNetweight should be between/');
        $content = new Content(1234567890, "Trousers", "120.50", 0, "DE", 2);
        $content->validate();
    }

    public function testBigNetweightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceNetweight should be between/');
        $content = new Content(1234567890, "Trousers", "120.50", 2400, "DE", 2);
        $content->validate();
    }

    public function testWrongCountryCodeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceOrigin length should be exactly/');
        $content = new Content(1234567890, "Trousers", "120.50", 2000, "DEU", 2);
        $content->validate();
    }

    public function testZeroPieceAmountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceAmount should be between/');
        $content = new Content(1234567890, "Trousers", "120.50", 2000, "DE", 0);
        $content->validate();
    }

    public function testBigPieceAmountThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/contentPieceAmount should be between/');
        $content = new Content(1234567890, "Trousers", "120.50", 2000, "DE", 100);
        $content->validate();
    }
}