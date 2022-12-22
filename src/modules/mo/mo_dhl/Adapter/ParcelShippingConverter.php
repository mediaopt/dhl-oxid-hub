<?php

namespace Mediaopt\DHL\Adapter;

use DateTime;
use Exception;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ExportDocPosition;
use Mediaopt\DHL\Api\GKV\ExportDocumentType;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Api\GKV\ShipperType;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderType;
use Mediaopt\DHL\Api\ParcelShipping\Model\Commodity;
use Mediaopt\DHL\Api\ParcelShipping\Model\CustomsDetails;
use Mediaopt\DHL\Api\ParcelShipping\Model\Dimensions;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest;
use Mediaopt\DHL\Api\ParcelShipping\Model\ContactAddress;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipment;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentDetails;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipper;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShippingConfirmation;
use Mediaopt\DHL\Api\ParcelShipping\Model\Value;
use Mediaopt\DHL\Api\ParcelShipping\Model\VAS;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASCashOnDelivery;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASDhlRetoure;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASIdentCheck;
use Mediaopt\DHL\Api\ParcelShipping\Model\Weight;
use Mediaopt\DHL\Export\CsvExporter;
use function array_map;

/**
 * @author Mediaopt GmbH
 */
class ParcelShippingConverter
{
    /**
     * @link http://country.io/iso3.json
     * @var array<string,string>
     */
    protected const ISO2_TO_ISO3_COUNTRY_CODES = [
        "BD" => "BGD",
        "BE" => "BEL",
        "BF" => "BFA",
        "BG" => "BGR",
        "BA" => "BIH",
        "BB" => "BRB",
        "WF" => "WLF",
        "BL" => "BLM",
        "BM" => "BMU",
        "BN" => "BRN",
        "BO" => "BOL",
        "BH" => "BHR",
        "BI" => "BDI",
        "BJ" => "BEN",
        "BT" => "BTN",
        "JM" => "JAM",
        "BV" => "BVT",
        "BW" => "BWA",
        "WS" => "WSM",
        "BQ" => "BES",
        "BR" => "BRA",
        "BS" => "BHS",
        "JE" => "JEY",
        "BY" => "BLR",
        "BZ" => "BLZ",
        "RU" => "RUS",
        "RW" => "RWA",
        "RS" => "SRB",
        "TL" => "TLS",
        "RE" => "REU",
        "TM" => "TKM",
        "TJ" => "TJK",
        "RO" => "ROU",
        "TK" => "TKL",
        "GW" => "GNB",
        "GU" => "GUM",
        "GT" => "GTM",
        "GS" => "SGS",
        "GR" => "GRC",
        "GQ" => "GNQ",
        "GP" => "GLP",
        "JP" => "JPN",
        "GY" => "GUY",
        "GG" => "GGY",
        "GF" => "GUF",
        "GE" => "GEO",
        "GD" => "GRD",
        "GB" => "GBR",
        "GA" => "GAB",
        "SV" => "SLV",
        "GN" => "GIN",
        "GM" => "GMB",
        "GL" => "GRL",
        "GI" => "GIB",
        "GH" => "GHA",
        "OM" => "OMN",
        "TN" => "TUN",
        "JO" => "JOR",
        "HR" => "HRV",
        "HT" => "HTI",
        "HU" => "HUN",
        "HK" => "HKG",
        "HN" => "HND",
        "HM" => "HMD",
        "VE" => "VEN",
        "PR" => "PRI",
        "PS" => "PSE",
        "PW" => "PLW",
        "PT" => "PRT",
        "SJ" => "SJM",
        "PY" => "PRY",
        "IQ" => "IRQ",
        "PA" => "PAN",
        "PF" => "PYF",
        "PG" => "PNG",
        "PE" => "PER",
        "PK" => "PAK",
        "PH" => "PHL",
        "PN" => "PCN",
        "PL" => "POL",
        "PM" => "SPM",
        "ZM" => "ZMB",
        "EH" => "ESH",
        "EE" => "EST",
        "EG" => "EGY",
        "ZA" => "ZAF",
        "EC" => "ECU",
        "IT" => "ITA",
        "VN" => "VNM",
        "SB" => "SLB",
        "ET" => "ETH",
        "SO" => "SOM",
        "ZW" => "ZWE",
        "SA" => "SAU",
        "ES" => "ESP",
        "ER" => "ERI",
        "ME" => "MNE",
        "MD" => "MDA",
        "MG" => "MDG",
        "MF" => "MAF",
        "MA" => "MAR",
        "MC" => "MCO",
        "UZ" => "UZB",
        "MM" => "MMR",
        "ML" => "MLI",
        "MO" => "MAC",
        "MN" => "MNG",
        "MH" => "MHL",
        "MK" => "MKD",
        "MU" => "MUS",
        "MT" => "MLT",
        "MW" => "MWI",
        "MV" => "MDV",
        "MQ" => "MTQ",
        "MP" => "MNP",
        "MS" => "MSR",
        "MR" => "MRT",
        "IM" => "IMN",
        "UG" => "UGA",
        "TZ" => "TZA",
        "MY" => "MYS",
        "MX" => "MEX",
        "IL" => "ISR",
        "FR" => "FRA",
        "IO" => "IOT",
        "SH" => "SHN",
        "FI" => "FIN",
        "FJ" => "FJI",
        "FK" => "FLK",
        "FM" => "FSM",
        "FO" => "FRO",
        "NI" => "NIC",
        "NL" => "NLD",
        "NO" => "NOR",
        "NA" => "NAM",
        "VU" => "VUT",
        "NC" => "NCL",
        "NE" => "NER",
        "NF" => "NFK",
        "NG" => "NGA",
        "NZ" => "NZL",
        "NP" => "NPL",
        "NR" => "NRU",
        "NU" => "NIU",
        "CK" => "COK",
        "XK" => "XKX",
        "CI" => "CIV",
        "CH" => "CHE",
        "CO" => "COL",
        "CN" => "CHN",
        "CM" => "CMR",
        "CL" => "CHL",
        "CC" => "CCK",
        "CA" => "CAN",
        "CG" => "COG",
        "CF" => "CAF",
        "CD" => "COD",
        "CZ" => "CZE",
        "CY" => "CYP",
        "CX" => "CXR",
        "CR" => "CRI",
        "CW" => "CUW",
        "CV" => "CPV",
        "CU" => "CUB",
        "SZ" => "SWZ",
        "SY" => "SYR",
        "SX" => "SXM",
        "KG" => "KGZ",
        "KE" => "KEN",
        "SS" => "SSD",
        "SR" => "SUR",
        "KI" => "KIR",
        "KH" => "KHM",
        "KN" => "KNA",
        "KM" => "COM",
        "ST" => "STP",
        "SK" => "SVK",
        "KR" => "KOR",
        "SI" => "SVN",
        "KP" => "PRK",
        "KW" => "KWT",
        "SN" => "SEN",
        "SM" => "SMR",
        "SL" => "SLE",
        "SC" => "SYC",
        "KZ" => "KAZ",
        "KY" => "CYM",
        "SG" => "SGP",
        "SE" => "SWE",
        "SD" => "SDN",
        "DO" => "DOM",
        "DM" => "DMA",
        "DJ" => "DJI",
        "DK" => "DNK",
        "VG" => "VGB",
        "DE" => "DEU",
        "YE" => "YEM",
        "DZ" => "DZA",
        "US" => "USA",
        "UY" => "URY",
        "YT" => "MYT",
        "UM" => "UMI",
        "LB" => "LBN",
        "LC" => "LCA",
        "LA" => "LAO",
        "TV" => "TUV",
        "TW" => "TWN",
        "TT" => "TTO",
        "TR" => "TUR",
        "LK" => "LKA",
        "LI" => "LIE",
        "LV" => "LVA",
        "TO" => "TON",
        "LT" => "LTU",
        "LU" => "LUX",
        "LR" => "LBR",
        "LS" => "LSO",
        "TH" => "THA",
        "TF" => "ATF",
        "TG" => "TGO",
        "TD" => "TCD",
        "TC" => "TCA",
        "LY" => "LBY",
        "VA" => "VAT",
        "VC" => "VCT",
        "AE" => "ARE",
        "AD" => "AND",
        "AG" => "ATG",
        "AF" => "AFG",
        "AI" => "AIA",
        "VI" => "VIR",
        "IS" => "ISL",
        "IR" => "IRN",
        "AM" => "ARM",
        "AL" => "ALB",
        "AO" => "AGO",
        "AQ" => "ATA",
        "AS" => "ASM",
        "AR" => "ARG",
        "AU" => "AUS",
        "AT" => "AUT",
        "AW" => "ABW",
        "IN" => "IND",
        "AX" => "ALA",
        "AZ" => "AZE",
        "IE" => "IRL",
        "ID" => "IDN",
        "UA" => "UKR",
        "QA" => "QAT",
        "MZ" => "MOZ",
    ];

    /**
     * @param CreateShipmentOrderRequest $legacyShipmentOrderRequest
     * @return array{ 0: array, 1: ShipmentOrderRequest }
     */
    public function convertCreateShipmentOrderRequest(CreateShipmentOrderRequest $legacyShipmentOrderRequest): array
    {
        $shipments = array_map([$this, 'convertShipmentOrder'], $legacyShipmentOrderRequest->getShipmentOrder());
        $shipmentOrderRequest = new ShipmentOrderRequest();
        $shipmentOrderRequest->setShipments($shipments);
        return [$this->extractQueryParameters($legacyShipmentOrderRequest), $shipmentOrderRequest];
    }

    /**
     * @param ValidateShipmentOrderRequest $legacyShipmentOrderRequest
     * @return array{ 0: array, 1: ShipmentOrderRequest }
     * @throws Exception
     */
    public function convertValidateShipmentOrderRequest(ValidateShipmentOrderRequest $legacyShipmentOrderRequest): array
    {
        $shipment = $this->convertShipmentOrder($legacyShipmentOrderRequest->getShipmentOrder());
        $shipmentOrderRequest = new ShipmentOrderRequest();
        $shipmentOrderRequest->setShipments([$shipment]);
        return [['validate' => true], $shipmentOrderRequest];
    }

    /**
     * @param array $payload
     * @return string[]
     */
    public function extractErrorsFromResponsePayload(array $payload): array
    {
        $errors = [];
        foreach ($payload['items'] ?? [] as $error) {
            if (\array_key_exists('validationMessages', $error)) {
                foreach ($error['validationMessages'] as $validationMessage) {
                    $errors[] = "{$validationMessage['validationMessage']} ({$validationMessage['property']})";
                }
                continue;
            }
            if (\array_key_exists('message', $error)) {
                $errors[] = "{$error['message']} ({$error['propertyPath']})";
            }
        }
        if ($errors !== []) {
            return $errors;
        }
        return \array_key_exists('detail', $payload) ? [$payload['detail']] : [];
    }

    /**
     * @param ShipmentOrderType|ValidateShipmentOrderType $legacyShipmentOrder
     * @return Shipment
     * @throws Exception
     */
    protected function convertShipmentOrder($legacyShipmentOrder): Shipment
    {
        $shipment = new Shipment();
        $shipment->setShipper($this->buildShipper($this->extractContactAddressFromShipperType($legacyShipmentOrder->getShipment()->getShipper())));
        $shipment->setConsignee($this->extractConsignee($legacyShipmentOrder));
        $shipment->setDetails($this->extractShipmentDetails($legacyShipmentOrder));
        $shipment->setCreationSoftware(CsvExporter::CREATOR_TAG);
        if ($exportDocument = $legacyShipmentOrder->getShipment()->getExportDocument()) {
            $shipment->setCustoms($this->extractCustoms($exportDocument));
        }
        if ($accountNumber = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getAccountNumber()) {
            $shipment->setBillingNumber($accountNumber);
        }
        if ($costCenter = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getCostCentre()) {
            $shipment->setCostCenter($costCenter);
        }
        if ($product = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getProduct()) {
            $shipment->setProduct($product);
        }
        if ($refNo = $legacyShipmentOrder->getSequenceNumber()) {
            $shipment->setRefNo($refNo);
        }
        if ($services = $this->extractServices($legacyShipmentOrder)) {
            $shipment->setServices($services);
        }
        if ($shipmentDate = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getShipmentDate()) {
            $shipment->setShipDate(new DateTime($shipmentDate));
        }
        return $shipment;
    }

    /**
     * @param ShipmentOrderType|ValidateShipmentOrderType $legacyShipmentOrder
     * @return array
     */
    protected function extractConsignee($legacyShipmentOrder): array
    {
        $legacyReceiver = $legacyShipmentOrder->getShipment()->getReceiver();

        if ($legacyReceiver->getPackstation() !== null) {
            return array_filter([
                'city'       => $legacyReceiver->getPackstation()->getCity(),
                'lockerID'   => $legacyReceiver->getPackstation()->getPackstationNumber(),
                'postalCode' => $legacyReceiver->getPackstation()->getZip(),
                'postNumber' => $legacyReceiver->getPackstation()->getPostNumber(),
                'name'       => $legacyReceiver->getName1(),
                'country'    => $this->mapISO2ToISO3($legacyReceiver->getPackstation()->getOrigin()->getCountryISOCode()),
            ]);
        }
        if ($legacyReceiver->getPostfiliale() !== null) {
            return array_filter([
                'city'       => $legacyReceiver->getPostfiliale()->getCity(),
                'name'       => $legacyReceiver->getName1(),
                'postalCode' => $legacyReceiver->getPostfiliale()->getZip(),
                'retailID'   => $legacyReceiver->getPostfiliale()->getPostfilialNumber(),
                'postNumber' => $legacyReceiver->getPostfiliale()->getPostNumber(),
                'country'    => $this->mapISO2ToISO3($legacyReceiver->getPostfiliale()->getOrigin()->getCountryISOCode()),
            ]);
        }
        return array_filter([
            'name1'                         => $legacyReceiver->getName1(),
            'name2'                         => $legacyReceiver->getAddress()->getName2(),
            'name3'                         => $legacyReceiver->getAddress()->getName3(),
            'dispatchingInformation'        => $legacyReceiver->getAddress()->getDispatchingInformation(),
            'additionalAddressInformation1' => $legacyReceiver->getAddress()->getAddressAddition()[0] ?? null,
            'additionalAddressInformation2' => $legacyReceiver->getAddress()->getAddressAddition()[1] ?? null,
            'state'                         => $legacyReceiver->getAddress()->getProvince(),
            'contactName'                   => $legacyReceiver->getCommunication()->getContactPerson(),
            'phone'                         => $legacyReceiver->getCommunication()->getPhone(),
            'email'                         => $legacyReceiver->getCommunication()->getEmail(),
            'city'                          => $legacyReceiver->getAddress()->getCity(),
            'postalCode'                    => $legacyReceiver->getAddress()->getZip(),
            'addressStreet'                 => $legacyReceiver->getAddress()->getStreetName(),
            'addressHouse'                  => $legacyReceiver->getAddress()->getStreetNumber(),
            'country'                       => $this->mapISO2ToISO3($legacyReceiver->getAddress()->getOrigin()->getCountryISOCode()),
        ]);
    }

    /**
     * @param ExportDocumentType $legacyExportDocument
     * @return CustomsDetails
     */
    protected function extractCustoms(ExportDocumentType $legacyExportDocument): CustomsDetails
    {
        $customsDetails = new CustomsDetails();
        $customsDetails->setExportType($legacyExportDocument->getExportType());
        if ($description = $legacyExportDocument->getExportTypeDescription()) {
            $customsDetails->setExportDescription($description);
        }
        $customsDetails->setItems(array_map([$this, 'convertToCommodity'], $legacyExportDocument->getExportDocPosition()));
        if ($attestationNo = $legacyExportDocument->getAttestationNumber()) {
            $customsDetails->setAttestationNo($attestationNo);
        }
        if ($legacyExportDocument->getWithElectronicExportNtfctn() !== null && $legacyExportDocument->getWithElectronicExportNtfctn()->getActive()) {
            $customsDetails->setHasElectronicExportNotification(true);
        }
        if ($invoiceNo = $legacyExportDocument->getInvoiceNumber()) {
            $customsDetails->setInvoiceNo($invoiceNo);
        }
        if ($origin = $legacyExportDocument->getPlaceOfCommital()) {
            $customsDetails->setOfficeOfOrigin($origin);
        }
        if ($permitNo = $legacyExportDocument->getPermitNumber()) {
            $customsDetails->setPermitNo($permitNo);
        }
        if ($postalCharges = $legacyExportDocument->getAdditionalFee()) {
            $customsDetails->setPostalCharges($this->createValue($postalCharges, $legacyExportDocument->getCustomsCurrency()));
        }
        if ($shippingConditions = $legacyExportDocument->getTermsOfTrade()) {
            $customsDetails->setShippingConditions($shippingConditions);
        }
        return $customsDetails;
    }

    /**
     * @param ExportDocPosition $item
     * @return Commodity
     */
    protected function convertToCommodity(ExportDocPosition $item): Commodity
    {
        $commodity = new Commodity();
        $commodity->setItemDescription($item->getDescription());
        $commodity->setPackagedQuantity($item->getAmount());
        $commodity->setItemValue($this->createValue($item->getCustomsValue()));
        $weight = new Weight();
        $weight->setUom('kg');
        $weight->setValue($item->getNetWeightInKG());
        $commodity->setItemWeight($weight);
        if ($hsCode = $item->getCustomsTariffNumber()) {
            $commodity->setHsCode($hsCode);
        }
        if ($origin = $item->getCountryCodeOrigin()) {
            $commodity->setCountryOfOrigin($this->mapISO2ToISO3($origin));
        }
        return $commodity;
    }

    /**
     * @param ContactAddress $address
     * @return Shipper
     */
    protected function buildShipper(ContactAddress $address): Shipper
    {
        $shipper = new Shipper();
        $shipper->setName1($address->getName1());
        if ($address->isInitialized('name2')) {
            $shipper->setName2($address->getName2());
        }
        if ($address->isInitialized('name3')) {
            $shipper->setName3($address->getName3());
        }
        $shipper->setCity($address->getCity());
        $shipper->setPostalCode($address->getPostalCode());
        $shipper->setAddressStreet($address->getAddressStreet());
        $shipper->setAddressHouse($address->getAddressHouse());
        $shipper->setCountry($address->getCountry());
        return $shipper;
    }

    /**
     * @param ShipperType|null $legacyShipper
     * @return ContactAddress
     */
    protected function extractContactAddressFromShipperType(?ShipperType $legacyShipper): ContactAddress
    {
        $contactAddress = new ContactAddress();
        $contactAddress->setName1($legacyShipper->getName()->getName1());
        if ($legacyShipper->getName()->getName2()) {
            $contactAddress->setName2($legacyShipper->getName()->getName2());
        }
        if ($legacyShipper->getName()->getName3()) {
            $contactAddress->setName3($legacyShipper->getName()->getName3());
        }
        $contactAddress->setCity($legacyShipper->getAddress()->getCity());
        if ($legacyShipper->getAddress()->getZip()) {
            $contactAddress->setPostalCode($legacyShipper->getAddress()->getZip());
        }
        $contactAddress->setAddressStreet($legacyShipper->getAddress()->getStreetName());
        if ($legacyShipper->getAddress()->getStreetNumber()) {
            $contactAddress->setAddressHouse($legacyShipper->getAddress()->getStreetNumber());
        }
        $contactAddress->setCountry($this->mapISO2ToISO3($legacyShipper->getAddress()->getOrigin()->getCountryISOCode()));
        return $contactAddress;
    }

    /**
     * @param ShipmentOrderType|ValidateShipmentOrderType $legacyShipmentOrder
     * @return ShipmentDetails
     */
    protected function extractShipmentDetails($legacyShipmentOrder): ShipmentDetails
    {
        $shipmentDetails = new ShipmentDetails();
        $shipmentItem = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getShipmentItem();

        $dimensions = new Dimensions();
        if ($shipmentItem->getLengthInCM()) {
            $dimensions->setLength($shipmentItem->getLengthInCM());
            $dimensions->setUom('cm');
            $shipmentDetails->setDim($dimensions);
        }
        if ($shipmentItem->getWidthInCM()) {
            $dimensions->setWidth($shipmentItem->getWidthInCM());
            $dimensions->setUom('cm');
            $shipmentDetails->setDim($dimensions);
        }
        if ($shipmentItem->getHeightInCM()) {
            $dimensions->setHeight($shipmentItem->getHeightInCM());
            $dimensions->setUom('cm');
            $shipmentDetails->setDim($dimensions);
        }

        $weight = new Weight();
        if ($shipmentItem->getWeightInKG()) {
            $weight->setUom('kg');
            $weight->setValue($shipmentItem->getWeightInKG());
            $shipmentDetails->setWeight($weight);
        }

        return $shipmentDetails;
    }

    /**
     * @param ShipmentOrderType|ValidateShipmentOrderType $legacyShipmentOrder
     * @return VAS|null
     * @throws Exception
     */
    protected function extractServices($legacyShipmentOrder): ?VAS
    {
        $legacyServices = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getService();
        if ($legacyServices === null) {
            return null;
        }

        $services = new VAS();
        $initialized = false;
        if ($legacyServices->getBulkyGoods() !== null && $legacyServices->getBulkyGoods()->getActive()) {
            $services->setBulkyGoods(true);
            $initialized = true;
        }
        if ($legacyServices->getEndorsement() !== null && $legacyServices->getEndorsement()->getActive()) {
            $services->setEndorsement($legacyServices->getEndorsement()->getType());
            $initialized = true;
        }
        if ($legacyServices->getPreferredDay() !== null && $legacyServices->getPreferredDay()->getActive()) {
            $services->setPreferredDay(new DateTime($legacyServices->getPreferredDay()->getDetails()));
            $initialized = true;
        }
        if ($legacyServices->getPreferredLocation() !== null && $legacyServices->getPreferredLocation()->getActive()) {
            $services->setPreferredLocation($legacyServices->getPreferredLocation()->getDetails());
            $initialized = true;
        }
        if ($legacyServices->getPreferredNeighbour() !== null && $legacyServices->getPreferredNeighbour()->getActive()) {
            $services->setPreferredNeighbour($legacyServices->getPreferredNeighbour()->getDetails());
            $initialized = true;
        }
        if ($legacyServices->getVisualCheckOfAge() !== null && $legacyServices->getVisualCheckOfAge()->getActive()) {
            $services->setVisualCheckOfAge($legacyServices->getVisualCheckOfAge()->getType());
            $initialized = true;
        }
        if ($returnAccountNumber = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getReturnShipmentAccountNumber()) {
            $dhlRetoure = new VASDhlRetoure();
            $dhlRetoure->setBillingNumber($returnAccountNumber);
            $dhlRetoure->setReturnAddress($this->extractContactAddressFromShipperType($legacyShipmentOrder->getShipment()->getShipper()));
            if ($refNo = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getReturnShipmentReference()) {
                $dhlRetoure->setRefNo($refNo);
            }

            $services->setDhlRetoure($dhlRetoure);
            $initialized = true;
        }
        if ($legacyServices->getAdditionalInsurance() !== null && $legacyServices->getAdditionalInsurance()->getActive()) {
            $services->setAdditionalInsurance($this->createValue($legacyServices->getAdditionalInsurance()->getInsuranceAmount()));
            $initialized = true;
        }
        if ($legacyServices->getCashOnDelivery() !== null && $legacyServices->getCashOnDelivery()->getActive()) {
            $cashOnDelivery = new VASCashOnDelivery();
            $cashOnDelivery->setAmount($this->createValue($legacyServices->getCashOnDelivery()->getCodAmount()));
            $services->setCashOnDelivery($cashOnDelivery);
            $initialized = true;
        }
        if ($legacyServices->getIdentCheck() !== null && $legacyServices->getIdentCheck()->getActive()) {
            $legacyIdent = $legacyServices->getIdentCheck()->getIdent();
            $identCheck = new VASIdentCheck();
            $identCheck->setDateOfBirth(new DateTime($legacyIdent->getDateOfBirth()));
            $identCheck->setFirstName($legacyIdent->getGivenName());
            $identCheck->setLastName($legacyIdent->getSurname());
            $identCheck->setMinimumAge($legacyIdent->getMinimumAge());
            $services->setIdentCheck($identCheck);
            $initialized = true;
        }
        if ($legacyServices->getIndividualSenderRequirement() && $legacyServices->getIndividualSenderRequirement()->getActive()) {
            $services->setIndividualSenderRequirement($legacyServices->getIndividualSenderRequirement()->getDetails());
            $initialized = true;
        }
        if ($legacyServices->getNamedPersonOnly() !== null && $legacyServices->getNamedPersonOnly()->getActive()) {
            $services->setNamedPersonOnly(true);
            $initialized = true;
        }
        if ($legacyServices->getNoNeighbourDelivery() !== null && $legacyServices->getNoNeighbourDelivery()->getActive()) {
            $services->setNoNeighbourDelivery(true);
            $initialized = true;
        }
        if ($legacyServices->getPackagingReturn() !== null && $legacyServices->getPackagingReturn()->getActive()) {
            $services->setPackagingReturn(true);
            $initialized = true;
        }
        if ($legacyServices->getParcelOutletRouting() !== null && $legacyServices->getParcelOutletRouting()->getActive()) {
            $services->setParcelOutletRouting($legacyServices->getParcelOutletRouting()->getDetails());
            $initialized = true;
        }
        if ($legacyServices->getPDDP() !== null && $legacyServices->getPDDP()->getActive()) {
            $services->setPostalDeliveryDutyPaid(true);
            $initialized = true;
        }
        if ($legacyServices->getPremium() !== null && $legacyServices->getPremium()->getActive()) {
            $services->setPremium(true);
            $initialized = true;
        }
        if ($notification = $legacyShipmentOrder->getShipment()->getShipmentDetails()->getNotification()) {
            $confirmation = new ShippingConfirmation();
            $confirmation->setEmail($notification->getRecipientEmailAddress());
            if ($notification->getTemplateId() !== null) {
                $confirmation->setTemplateRef($notification->getTemplateId());
            }
            $services->setShippingConfirmation($confirmation);
            $initialized = true;
        }

        return $initialized ? $services : null;
    }

    /**
     * @param CreateShipmentOrderRequest $legacyShipmentOrderRequest
     * @return array
     */
    protected function extractQueryParameters(CreateShipmentOrderRequest $legacyShipmentOrderRequest): array
    {
        return [
            'includeDocs' => 'URL',
            'combine'     => (bool)$legacyShipmentOrderRequest->getCombinedPrinting(),
            'mustEncode'  => \in_array(true, array_map(function ($shipment) use ($legacyShipmentOrderRequest) {
                return $shipment->getPrintOnlyIfCodeable() !== null && $shipment->getPrintOnlyIfCodeable()->getActive();
            }, $legacyShipmentOrderRequest->getShipmentOrder()), true),
        ];
    }

    /**
     * @param string $iso2
     * @return string
     */
    protected function mapISO2ToISO3(string $iso2): string
    {
        if (!\array_key_exists(\strtoupper($iso2), self::ISO2_TO_ISO3_COUNTRY_CODES)) {
            throw new \InvalidArgumentException(\sprintf('Could not map ISO2 "%s" to ISO3', $iso2));
        }
        return self::ISO2_TO_ISO3_COUNTRY_CODES[\strtoupper($iso2)];
    }

    /**
     * This method will return a value with EUR as currency since the currency this class receives is EUR at the moment.
     *
     * @param float       $amount
     * @param string|null $currency
     * @return Value
     */
    protected function createValue(float $amount, ?string $currency = null): Value
    {
        $value = new Value();
        $value->setValue($amount);
        $value->setCurrency($currency ?: 'EUR');
        return $value;
    }
}
