<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\Warenspost;

use Mediaopt\DHL\Api\Warenpost\Content;
use Mediaopt\DHL\Api\Warenpost\Product;
use Mediaopt\DHL\Api\Warenpost\ShipmentNatureType;
use Mediaopt\DHL\Exception\WarenpostException;
use Mediaopt\DHL\Api\Warenpost\ItemData;

/**
 * @author Mediaopt GmbH
 */
class WarenpostItemDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $customValues
     * @return ItemData
     */
    public function buildItemData($customValues = []): ItemData
    {
        $product = new Product(Product::REGION_EU, Product::TRACKING_TYPE_SIGNATURE, Product::PACKAGE_TYPE_L);

        $defaultValues = [
            'product' => $product->getProduct(),
            'recipient' => 'Floppa',
            'addressLine1' => 'Main street 1',
            'postalCode' => '25487',
            'city' => 'Roma',
            'destinationCountry' => 'IT',
            'senderName' => 'Alfred J. Quack',
            'senderAddressLine1' => 'Alexanderplztz 1',
            'senderPostalCode' => '10179',
            'senderCity' => 'Berlin',
            'senderCountry' => 'DE',
            'shipmentNaturetype' => ShipmentNatureType::SALE_GOODS,
            'shipmentGrossWeight' => 1900,
        ];

        foreach ($customValues as $key=>$value){
            $defaultValues[$key] = $value;
        }

        return new ItemData(
            $defaultValues['product'],
            $defaultValues['recipient'],
            $defaultValues['addressLine1'],
            $defaultValues['postalCode'],
            $defaultValues['city'],
            $defaultValues['destinationCountry'],
            $defaultValues['senderName'],
            $defaultValues['senderAddressLine1'],
            $defaultValues['senderPostalCode'],
            $defaultValues['senderCity'],
            $defaultValues['senderCountry'],
            $defaultValues['shipmentNaturetype'],
            $defaultValues['shipmentGrossWeight']
        );
    }

    public function testSuccessItemData()
    {
        $itemData = $this->buildItemData();
        $itemData->setAddressLine2('Hinterhaus');
        $itemData->setAddressLine3('1. Etage');
        $itemData->setId(1);
        $itemData->setImporterTaxId('ImporterTaxId');
        $itemData->setRecipientEmail('alfred.j.quack@somewhere.eu');
        $itemData->setRecipientFax('+4935120681234');
        $itemData->setRecipientPhone('+4935120681234');
        $itemData->setSenderAddressLine2('Hinterhaus');
        $itemData->setSenderAddressLine3('2. Etage');
        $itemData->setSenderEmail('alfred.j.quack@somewhere.eu');
        $itemData->setSenderPhone('+4935120681234');
        $itemData->setSenderTaxId('SenderTaxId');
        $itemData->setShipmentAmount(4);
        $itemData->setShipmentCurrency('EUR');
        $itemData->setState('Sachsen');
        $itemData->setCustRef("REF-2361890-AB");
        $itemData->setContents([
            (new Content(120.50, 600, 2))->toArray(),
            (new Content(120.50, 350, 2))->toArray(),
        ]);
        $itemData->validate();

        $this->assertEquals(
            $itemData->toArray(),
            [
                'product' => '10287',
                'recipient' => 'Floppa',
                'addressLine1' => 'Main street 1',
                'postalCode' => '25487',
                'city' => 'Roma',
                'destinationCountry' => 'IT',
                'senderName' => 'Alfred J. Quack',
                'senderAddressLine1' => 'Alexanderplztz 1',
                'senderPostalCode' => '10179',
                'senderCity' => 'Berlin',
                'senderCountry' => 'DE',
                'shipmentNaturetype' => 'SALE_GOODS',
                'shipmentGrossWeight' => 1900,
                'serviceLevel' => 'STANDARD',
                'returnItemWanted' => false,

                'addressLine2' => 'Hinterhaus',
                'addressLine3' => '1. Etage',
                'id' => 1,
                'importerTaxId' => 'ImporterTaxId',
                'recipientEmail' => 'alfred.j.quack@somewhere.eu',
                'recipientFax' => '+4935120681234',
                'recipientPhone' => '+4935120681234',
                'senderAddressLine2' => 'Hinterhaus',
                'senderAddressLine3' => '2. Etage',
                'senderEmail' => 'alfred.j.quack@somewhere.eu',
                'senderPhone' => '+4935120681234',
                'senderTaxId' => 'SenderTaxId',
                'shipmentAmount' => 4,
                'shipmentCurrency' => 'EUR',
                'state' => 'Sachsen',
                'custRef' => 'REF-2361890-AB',

                'contents' => [
                    [
                        'contentPieceValue' => 120.50,
                        'contentPieceNetweight' => 600,
                        'contentPieceAmount' => 2,
                    ],
                    [
                        'contentPieceValue' => 120.50,
                        'contentPieceNetweight' => 350,
                        'contentPieceAmount' => 2,
                    ]
                ],
            ]
        );
    }

    public function testSuccessMinimalItemData()
    {
        $itemData = $this->buildItemData();
        $itemData->validate();

        $this->assertEquals(
            $itemData->toArray(),
            [
                'product' => '10287',
                'recipient' => 'Floppa',
                'addressLine1' => 'Main street 1',
                'postalCode' => '25487',
                'city' => 'Roma',
                'destinationCountry' => 'IT',
                'senderName' => 'Alfred J. Quack',
                'senderAddressLine1' => 'Alexanderplztz 1',
                'senderPostalCode' => '10179',
                'senderCity' => 'Berlin',
                'senderCountry' => 'DE',
                'shipmentNaturetype' => 'SALE_GOODS',
                'shipmentGrossWeight' => 1900,
                'serviceLevel' => 'STANDARD',
                'returnItemWanted' => false,
            ]
        );
    }

    public function testBigRecipientThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = $this->buildItemData(['recipient' => "Big recepient name, more than enough for an error"]);
        $itemData->validate();
    }

    public function testBigAddressLine1ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = $this->buildItemData(['addressLine1' => "Big address line 1, more than enough for an error"]);
        $itemData->validate();
    }

    public function testBigCityThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = $this->buildItemData(['city' => "Big city, more than enough for an error"]);
        $itemData->validate();
    }

    public function testWrongtDestinationCountryLengthThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be exactly/');
        $itemData = $this->buildItemData(['destinationCountry' => "DEU"]);
        $itemData->validate();
    }

    public function testZeroShipmentGrossWeightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['shipmentGrossWeight' => 0]);
        $itemData->validate();
    }

    public function testBigShipmentGrossWeightThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['shipmentGrossWeight' => 2100]);
        $itemData->validate();
    }

    public function testBigAddressLIne2ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setAddressLine2('Big address line 3, more than enough for an error');
        $itemData->validate();
    }

    public function testBigAddressLIne3ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setAddressLine3('Big address line 3, more than enough for an error');
        $itemData->validate();
    }

    public function testBigCustRefThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['custRef' => 'Big address line 2, more than enough for an error']);
        $itemData->setCustRef('Big custRef, more than enough for an error');
        $itemData->validate();
    }

    public function testBigPostalCodeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['postalCode' => 'Big postalCode']);
        $itemData->validate();
    }

    public function testBigRecipientEmailThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setRecipientEmail("Big recipientEmail, more than enough for an error. But let's make it bigger.");
        $itemData->validate();
    }

    public function testBigRecipientFaxThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setRecipientFax('Big recipientFax, more than enough for an error');
        $itemData->validate();
    }

    public function testBigRecipientPhoneThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setRecipientPhone('Big recipientPhone, more than enough for an error. Or not?');
        $itemData->validate();
    }

    public function testBigSenderAddressLine1ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['senderAddressLine1' => 'Big senderAddressLine1, more than enough for an error']);
        $itemData->validate();
    }

    public function testBigSenderAddressLine2ThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setSenderAddressLine2('Big senderAddressLine2, more than enough for an error');
        $itemData->validate();
    }

    public function testBigSenderCityThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['senderCity'=>'Big senderCity, more than enough for an error']);
        $itemData->validate();
    }

    public function testBigSenderCountryThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be exactly/');
        $itemData = $this->buildItemData(['senderCountry' => 'DEU']);
        $itemData->validate();
    }

    public function testBigSenderEmailThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setSenderEmail("Big senderEmail, more than enough for an error. But let's make it bigger.");
        $itemData->validate();
    }

    public function testBigSenderNameThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['senderName' => 'Big senderName, more than enough for an error']);
        $itemData->validate();
    }

    public function testBigSenderPhoneThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData();
        $itemData->setSenderPhone("Big senderPhone, more than enough for an error. But let's make it bigger.");
        $itemData->validate();
    }

    public function testBigSenderPostalCodeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/should be between/');
        $itemData = $this->buildItemData(['senderPostalCode' => 'Big senderPostalCode, more than enough for an error']);
        $itemData->validate();
    }

    public function testWrongShipmentCurrencyThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be exactly/');
        $itemData = $this->buildItemData();
        $itemData->setShipmentCurrency('E');
        $itemData->validate();
    }

    public function testWrongShipmentNaturetypeThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/unknown shipmentNaturetype/');
        $itemData = $this->buildItemData(['shipmentNaturetype' => 'Present']);
        $itemData->validate();
    }

    public function testBigStateThrowAnException()
    {
        $this->expectException(WarenpostException::class);
        $this->expectExceptionMessageRegExp('/length should be between/');
        $itemData = $this->buildItemData(['senderPostalCode' => 'Big senderPostalCode, more than enough for an error']);
        $itemData->validate();
    }
}