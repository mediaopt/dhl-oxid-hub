<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\Warenspost;

use Mediaopt\DHL\Exception\WarenpostException;
use Mediaopt\DHL\Api\Warenpost\ItemData;

/**
 * @author Mediaopt GmbH
 */
class WarenpostItemDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ItemData
     */
    public function buildSuccessItemData(): ItemData
    {
        return new ItemData("GPP", "Alfred J. Quack Jr.", "Main street 1", "Roma", "IT", 1500);
    }


    public function testSuccessItemData()
    {
        $itemData = $this->buildSuccessItemData();
        $itemData->setId(1);
        $itemData->setAddressLine2('Hinterhaus');
        $itemData->setAddressLine3('1. Etage');
        $itemData->setContents([
            (new WarenpostContentTest())->buildCorrectContent()->toArray(),
            (new WarenpostContentTest())->buildCorrectContent()->toArray(),
        ]);
        $itemData->setCustRef("REF-2361890-AB");
        $itemData->setCustRef2("EFI");
        $itemData->setCustRef3("123456");
        $itemData->setPostalCode('794');
        $itemData->setRecipientEmail('alfred.j.quack@somewhere.eu');
        $itemData->setRecipientFax('+4935120681234');
        $itemData->setRecipientPhone('+4935120681234');
        $itemData->setReturnItemWanted(true);
        $itemData->setSenderAddressLine1('Mustergasse 12');
        $itemData->setSenderAddressLine2('Hinterhaus');
        $itemData->setSenderCity('Dresden');
        $itemData->setSenderCountry('DE');
        $itemData->setSenderEmail('alfred.j.quack@somewhere.eu');
        $itemData->setSenderName('Alfred J. Quack');
        $itemData->setSenderPhone('+4935120681234');
        $itemData->setSenderPostalCode('794');
        $itemData->setServiceLevel('PRIORITY');
        $itemData->setShipmentAmount(100.00);
        $itemData->setShipmentCurrency('EUR');
        $itemData->setShipmentNaturetype('GIFT');
        $itemData->setState('Sachsen');
        $itemData->validate();

        $this->assertEquals(
            $itemData->toArray(),
            [
                'product' => 'GPP',
                'recipient' => 'Alfred J. Quack Jr.',
                'addressLine1' => 'Main street 1',
                'city' => 'Roma',
                'destinationCountry' => 'IT',
                'shipmentGrossWeight' => 1500,
                'addressLine2' => 'Hinterhaus',
                'addressLine3' => '1. Etage',
                'contents' => [
                    [
                        'contentPieceHsCode' => 1234567890,
                        'contentPieceDescription' => 'Trousers',
                        'contentPieceValue' => '120.50',
                        'contentPieceNetweight' => 1200,
                        'contentPieceOrigin' => 'DE',
                        'contentPieceAmount' => 2,
                        'contentPieceIndexNumber' => 1337,
                    ],
                    [
                        'contentPieceHsCode' => 1234567890,
                        'contentPieceDescription' => 'Trousers',
                        'contentPieceValue' => '120.50',
                        'contentPieceNetweight' => 1200,
                        'contentPieceOrigin' => 'DE',
                        'contentPieceAmount' => 2,
                        'contentPieceIndexNumber' => 1337,
                    ]
                ],
                'custRef' => 'REF-2361890-AB',
                'custRef2' => 'EFI',
                'custRef3' => '123456',
                'id' => 1,
                'postalCode' => '794',
                'recipientEmail' => 'alfred.j.quack@somewhere.eu',
                'recipientFax' => '+4935120681234',
                'recipientPhone' => '+4935120681234',
                'returnItemWanted' => true,
                'senderAddressLine1' => 'Mustergasse 12',
                'senderAddressLine2' => 'Hinterhaus',
                'senderCity' => 'Dresden',
                'senderCountry' => 'DE',
                'senderEmail' => 'alfred.j.quack@somewhere.eu',
                'senderName' => 'Alfred J. Quack',
                'senderPhone' => '+4935120681234',
                'senderPostalCode' => '794',
                'serviceLevel' => 'PRIORITY',
                'shipmentAmount' => 100.0,
                'shipmentCurrency' => 'EUR',
                'shipmentNaturetype' => 'GIFT',
                'state' => 'Sachsen',
            ]
        );
    }

    public function testSuccessMinimalItemData()
    {
        $itemData = $this->buildSuccessItemData();
        $this->assertEquals(
            $itemData->toArray(),
            [
                'product' => 'GPP',
                'recipient' => 'Alfred J. Quack Jr.',
                'addressLine1' => 'Main street 1',
                'city' => 'Roma',
                'destinationCountry' => 'IT',
                'shipmentGrossWeight' => 1500,
                'returnItemWanted' => false
            ]
        );
    }

    public function testShortRecipientThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = new ItemData("GPP", "", "Main street 1", "Roma", "IT", 1500);
        $itemData->validate();
    }

    public function testBigRecipientThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = new ItemData("GPP", "Big recepient name, more than enough for an error", "Main street 1", "Roma", "IT", 1500);
        $itemData->validate();
    }


    public function testShortAddressLine1ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "", "Roma", "IT", 1500);
        $itemData->validate();
    }

    public function testBigAddressLine1ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "Big address line 1, more than enough for an error", "Roma", "IT", 1500);
        $itemData->validate();
    }

    public function testShortCityThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "Main street 1", "", "IT", 1500);
        $itemData->validate();
    }

    public function testBigCityThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "Main street 1", "Big city, more than enough for an error", "IT", 1500);
        $itemData->validate();
    }

    public function testWrongtDestinationCountryLengthThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be exactly/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "Main street 1", "Roma", "I", 1500);
        $itemData->validate();
    }

    public function testZeroShipmentGrossWeightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "Main street 1", "Roma", "IT", 0);
        $itemData->validate();
    }

    public function testBigShipmentGrossWeightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = new ItemData("GPP", "Alfred J. Quack Jr.", "Main street 1", "Roma", "IT", 2350);
        $itemData->validate();
    }

    public function testBigAddressLIne2ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setAddressLine2('Big address line 2, more than enough for an error');
        $itemData->validate();
    }

    public function testBigAddressLIne3ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setAddressLine3('Big address line 3, more than enough for an error');
        $itemData->validate();
    }

    public function testBigCustRefThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setCustRef('Big custRef, more than enough for an error');
        $itemData->validate();
    }

    public function testBigCust2RefThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setCustRef2('Big custRef2, more than enough for an error');
        $itemData->validate();
    }

    public function testBigCust3RefThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setCustRef3('Big custRef3, more than enough for an error');
        $itemData->validate();
    }

    public function testBigPostalCodeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setPostalCode('Big postalCode, more than enough for an error');
        $itemData->validate();
    }

    public function testBigRecipientEmailThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setRecipientEmail("Big recipientEmail, more than enough for an error. But let's make it bigger.");
        $itemData->validate();
    }

    public function testBigRecipientFaxThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setRecipientFax('Big recipientFax, more than enough for an error');
        $itemData->validate();
    }

    public function testBigRecipientPhoneThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setRecipientPhone('Big recipientPhone, more than enough for an error');
        $itemData->validate();
    }

    public function testBigSenderAddressLine1ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderAddressLine1('Big senderAddressLine1, more than enough for an error');
        $itemData->validate();
    }

    public function testBigSenderAddressLine2ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderAddressLine1('Big senderAddressLine2, more than enough for an error');
        $itemData->validate();
    }

    public function testBigSenderCityThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderCity('Big senderCity, more than enough for an error');
        $itemData->validate();
    }

    public function testBigSenderCountryThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be exactly/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderCountry('D');
        $itemData->validate();
    }

    public function testBigSenderEmailThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderEmail("Big senderEmail, more than enough for an error. But let's make it bigger.");
        $itemData->validate();
    }

    public function testBigSenderNameThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderName('Big senderName, more than enough for an error');
        $itemData->validate();
    }

    public function testBigSenderPhoneThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderPhone("Big senderPhone, more than enough for an error. But let's make it bigger.");
        $itemData->validate();
    }

    public function testBigSenderPostalCodeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setSenderPostalCode('Big senderPostalCode, more than enough for an error');
        $itemData->validate();
    }

    public function testWrongServiceLevelThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown serviceLevel/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setServiceLevel('error');
        $itemData->validate();
    }

    public function testWrongShipmentCurrencyThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be exactly/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setShipmentCurrency('E');
        $itemData->validate();
    }

    public function testWrongShipmentNaturetypeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown shipmentNaturetype/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setShipmentNaturetype('Present');
        $itemData->validate();
    }

    public function testBigStateThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = $this->buildSuccessItemData();
        $itemData->setState('Big senderPostalCode, more than enough for an error');
        $itemData->validate();
    }
}