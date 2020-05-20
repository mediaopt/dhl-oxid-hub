<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Export;

use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Shipment\Shipment;


/**
 * This class exports \Mediaopt\DHL\Export\Csv objects as a CSV-formatted string.
 *
 * The format is aligned to the template "DHL Vorlage Sendungsdatenimport" in the Geschäftskundenportal of DHL.
 *
 * @author  Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package ${NAMESPACE}
 */
class CsvExporter implements Exporter
{
    /**
     * @var string
     */
    const CREATOR_TAG = 'DHL-Wunschpaket SDK (created by Mediaopt)';

    /**
     * Target charset.
     *
     * @var string
     */
    const TARGET_CHARSET = 'ISO-8859-1';

    /**
     * Contains the header of the CSV.
     *
     * @var array
     */
    protected static $HEADER = [
        'Sendungsreferenz',
        'Sendungsdatum',
        'Absender Name 1',
        'Absender Name 2',
        'Absender Name 3',
        'Absender Straße',
        'Absender Hausnummer',
        'Absender PLZ',
        'Absender Ort',
        'Absender Provinz',
        'Absender Land',
        'Absenderreferenz',
        'Absender E-Mail-Adresse',
        'Absender Telefonnummer',
        'Empfänger Name 1',
        'Empfänger Name 2 / Postnummer',
        'Empfänger Name 3',
        'Empfänger Straße',
        'Empfänger Hausnummer',
        'Empfänger PLZ',
        'Empfänger Ort',
        'Empfänger Provinz',
        'Empfänger Land',
        'Empfängerreferenz',
        'Empfänger E-Mail-Adresse',
        'Empfänger Telefonnummer',
        'Gewicht',
        'Länge',
        'Breite',
        'Höhe',
        'Produkt- und Servicedetails',
        'Retourenempfänger Name 1',
        'Retourenempfänger Name 2',
        'Retourenempfänger Name 3',
        'Retourenempfänger Straße',
        'Retourenempfänger Hausnummer',
        'Retourenempfänger PLZ',
        'Retourenempfänger Ort',
        'Retourenempfänger Provinz',
        'Retourenempfänger Land',
        'Retourenrempfänger E-Mail-Adresse',
        'Retourenempfänger Telefonnummer',
        'Retouren-Abrechnungsnummer',
        'Abrechnungsnummer',
        'Service - Versandbestätigung - E-Mail Text-Vorlage',
        'Service - Versandbestätigung - E-Mail-Adresse',
        'Service - Nachnahme - Kontoreferenz',
        'Service - Nachnahme - Betrag',
        'Service - Nachnahme - IBAN',
        'Service - Nachnahme - BIC',
        'Service - Nachnahme - Zahlungsempfänger',
        'Service - Nachnahme - Bankname',
        'Service - Nachnahme - Verwendungszweck 1',
        'Service - Nachnahme - Verwendungszweck 2',
        'Service - Transportversicherung - Betrag',
        'Service - Weltpaket - Vorausverfügungstyp',
        'Service - Vorausverfügung',
        'Service - DHL Europaket - Frankaturtyp',
        'Sendungsdokumente - Ausfuhranmeldung',
        'Sendungsdokumente - Rechnungsnummer',
        'Sendungsdokumente - Genehmigungsnummer',
        'Sendungsdokumente - Bescheinigungsnummer',
        'Sendungsdokumente - Sendungsart',
        'Sendungsdokumente - Beschreibung',
        'Sendungsdokumente - Entgelte',
        'Sendungsdokumente - Gesamtnettogewicht',
        'Sendungsdokumente - Beschreibung (WP1)',
        'Sendungsdokumente - Menge (WP1)',
        'Sendungsdokumente - Zollwert (WP1)',
        'Sendungsdokumente - Ursprungsland (WP1)',
        'Sendungsdokumente - Zolltarifnummer (WP1)',
        'Sendungsdokumente - Gewicht (WP1)',
        'Sendungsdokumente - Beschreibung (WP2)',
        'Sendungsdokumente - Menge (WP2)',
        'Sendungsdokumente - Zollwert (WP2)',
        'Sendungsdokumente - Ursprungsland (WP2)',
        'Sendungsdokumente - Zolltarifnummer (WP2)',
        'Sendungsdokumente - Gewicht (WP2)',
        'Sendungsdokumente - Beschreibung (WP3)',
        'Sendungsdokumente - Menge (WP3)',
        'Sendungsdokumente - Zollwert (WP3)',
        'Sendungsdokumente - Ursprungsland (WP3)',
        'Sendungsdokumente - Zolltarifnummer (WP3)',
        'Sendungsdokumente - Gewicht (WP3)',
        'Sendungsdokumente - Beschreibung (WP4)',
        'Sendungsdokumente - Menge (WP4)',
        'Sendungsdokumente - Zollwert (WP4)',
        'Sendungsdokumente - Ursprungsland (WP4)',
        'Sendungsdokumente - Zolltarifnummer (WP4)',
        'Sendungsdokumente - Gewicht (WP4)',
        'Sendungsdokumente - Beschreibung (WP5)',
        'Sendungsdokumente - Menge (WP5)',
        'Sendungsdokumente - Zollwert (WP5)',
        'Sendungsdokumente - Ursprungsland (WP5)',
        'Sendungsdokumente - Zolltarifnummer (WP5)',
        'Sendungsdokumente - Gewicht (WP5)',
        'Sendungsdokumente - Beschreibung (WP6)',
        'Sendungsdokumente - Menge (WP6)',
        'Sendungsdokumente - Zollwert (WP6)',
        'Sendungsdokumente - Ursprungsland (WP6)',
        'Sendungsdokumente - Zolltarifnummer (WP6)',
        'Sendungsdokumente - Gewicht (WP6)',
        'Sendungsreferenz (Retoure)',
        'Absender Adresszusatz 1',
        'Absender Adresszusatz 2',
        'Absender Zustellinformation',
        'Absender Ansprechpartner',
        'Empfänger Adresszusatz 1',
        'Empfänger Adresszusatz 2',
        'Empfänger Zustellinformation',
        'Empfänger Ansprechpartner',
        'Retourenempfänger Adresszusatz 1',
        'Retourenempfänger Adresszusatz 2',
        'Retourenempfänger Zustellinformation',
        'Retourenempfänger Ansprechpartner',
        'Service - Wunschnachbar - Details',
        'Service - Wunschort - Details',
        'Service - Alterssichtprüfung - Altersgrenze',
        'Service - Sendungshandling',
        'Service - beliebiger Hinweistext',
        'Service - Zustelldatum',
        'Sendungsdokumente - Einlieferungsstelle',
        'Creation-Software',
        'Service - ind. Versendervorgabe Kennzeichen',
        'Service - Ident-Check - Vorname',
        'Service - Ident-Check - Nachname',
        'Service - Ident-Check - Geburtsdatum',
        'Service - Ident-Check - Mindestalter',
    ];

    /**
     * @var string
     */
    protected $charset;

    /**
     * Contains the rows that are to be exported.
     *
     * @var array
     */
    protected $rows = [];

    /**
     * @param string $charset
     */
    public function __construct($charset)
    {
        $this->charset = $charset;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function convertToTargetCharset($value)
    {
        return iconv($this->getCharset(), static::TARGET_CHARSET, $value);
    }

    /**
     * @param Shipment $shipment
     * @return string[]
     */
    protected function buildRow(Shipment $shipment)
    {
        $row = array_fill_keys(static::$HEADER, '');
        $row['Sendungsdatum'] = $this->determineDateOfShipping($shipment);
        $row['Sendungsreferenz'] = $shipment->getReference();
        $row['Sendungsreferenz (Retoure)'] = '';
        $row['Produkt- und Servicedetails'] = $this->determineServiceDetails($shipment);
        $row['Abrechnungsnummer'] = (string)$shipment->getBillingNumber();
        $row['Retouren-Abrechnungsnummer'] = '';
        $row['Creation-Software'] = self::CREATOR_TAG;
        $row = $this->injectReceiver($shipment, $row);
        $row = $this->injectReturnReceiver($row);
        $row = $this->injectSender($shipment, $row);
        $row = $this->injectService($shipment, $row);
        $row = $this->injectShipmentDocuments($row);
        $row = $this->injectShipmentMetrics($shipment, $row);
        return array_map([$this, 'convertToTargetCharset'], $row);
    }

    /**
     * @param Shipment $shipment
     * @return string
     */
    protected function determineDateOfShipping(Shipment $shipment)
    {
        $dateOfShipping = $shipment->getDateOfShipping();
        return !empty($dateOfShipping) ? date('d.m.Y', strtotime($dateOfShipping)) : '';
    }

    /**
     * @param Shipment $shipment
     * @param string[] $row
     * @return string[]
     */
    protected function injectShipmentMetrics(Shipment $shipment, array $row)
    {
        $row['Gewicht'] = number_format($shipment->getWeight(), 4, ',', '');
        $row['Länge'] = '';
        $row['Breite'] = '';
        $row['Höhe'] = '';
        return $row;
    }

    /**
     * @param Shipment $shipment
     * @param string[] $row
     * @return string[]
     */
    protected function injectSender(Shipment $shipment, array $row)
    {
        $row['Absender Name 1'] = $shipment->getSender()->getLine1();
        $row['Absender Name 2'] = $shipment->getSender()->getLine2();
        $row['Absender Name 3'] = $shipment->getSender()->getLine3();
        $row['Absender Straße'] = $shipment->getSender()->getAddress()->getStreet();
        $row['Absender Hausnummer'] = $shipment->getSender()->getAddress()->getStreetNo();
        $row['Absender PLZ'] = $shipment->getSender()->getAddress()->getZip();
        $row['Absender Ort'] = $shipment->getSender()->getAddress()->getCity();
        $row['Absender Provinz'] = '';
        $row['Absender Land'] = $shipment->getSender()->getAddress()->getCountry();
        $row['Absenderreferenz'] = '';
        $row['Absender E-Mail-Adresse'] = '';
        $row['Absender Telefonnummer'] = '';
        $row['Absender Adresszusatz 1'] = '';
        $row['Absender Adresszusatz 2'] = '';
        $row['Absender Zustellinformation'] = '';
        $row['Absender Ansprechpartner'] = '';
        return $row;
    }

    /**
     * @param Shipment $shipment
     * @param string[] $row
     * @return string[]
     */
    protected function injectReceiver(Shipment $shipment, array $row)
    {
        $row['Empfänger Name 1'] = $shipment->getReceiver()->getLine1();
        $row['Empfänger Name 2 / Postnummer'] = $shipment->getReceiver()->getLine2();
        $row['Empfänger Name 3'] = $shipment->getReceiver()->getLine3();
        $row['Empfänger Straße'] = $shipment->getReceiver()->getAddress()->getStreet();
        $row['Empfänger Hausnummer'] = $shipment->getReceiver()->getAddress()->getStreetNo();
        $row['Empfänger PLZ'] = $shipment->getReceiver()->getAddress()->getZip();
        $row['Empfänger Ort'] = $shipment->getReceiver()->getAddress()->getCity();
        $row['Empfänger Provinz'] = '';
        $row['Empfänger Land'] = $shipment->getReceiver()->getAddress()->getCountry();
        $row['Empfängerreferenz'] = '';
        $row['Empfänger E-Mail-Adresse'] = $shipment->getReceiver()->getReceiver()->getEmail();
        $row['Empfänger Telefonnummer'] = $shipment->getReceiver()->getReceiver()->getPhone();
        $row['Empfänger Adresszusatz 1'] = '';
        $row['Empfänger Adresszusatz 2'] = '';
        $row['Empfänger Zustellinformation'] = '';
        $row['Empfänger Ansprechpartner'] = '';
        return $row;
    }

    /**
     * @param string[] $row
     * @return \string[]
     */
    protected function injectReturnReceiver(array $row)
    {
        $row['Retourenempfänger Name 1'] = '';
        $row['Retourenempfänger Name 2'] = '';
        $row['Retourenempfänger Name 3'] = '';
        $row['Retourenempfänger Straße'] = '';
        $row['Retourenempfänger Hausnummer'] = '';
        $row['Retourenempfänger PLZ'] = '';
        $row['Retourenempfänger Ort'] = '';
        $row['Retourenempfänger Provinz'] = '';
        $row['Retourenempfänger Land'] = '';
        $row['Retourenrempfänger E-Mail-Adresse'] = '';
        $row['Retourenempfänger Telefonnummer'] = '';
        $row['Retourenempfänger Adresszusatz 1'] = '';
        $row['Retourenempfänger Adresszusatz 2'] = '';
        $row['Retourenempfänger Zustellinformation'] = '';
        $row['Retourenempfänger Ansprechpartner'] = '';
        return $row;
    }

    /**
     * @param string[] $row
     * @return \string[]
     */
    protected function injectShipmentDocuments(array $row)
    {
        $row['Sendungsdokumente - Ausfuhranmeldung'] = '';
        $row['Sendungsdokumente - Rechnungsnummer'] = '';
        $row['Sendungsdokumente - Genehmigungsnummer'] = '';
        $row['Sendungsdokumente - Bescheinigungsnummer'] = '';
        $row['Sendungsdokumente - Sendungsart'] = '';
        $row['Sendungsdokumente - Beschreibung'] = '';
        $row['Sendungsdokumente - Entgelte'] = '';
        $row['Sendungsdokumente - Gesamtnettogewicht'] = '';
        $row['Sendungsdokumente - Beschreibung (WP1)'] = '';
        $row['Sendungsdokumente - Menge (WP1)'] = '';
        $row['Sendungsdokumente - Zollwert (WP1)'] = '';
        $row['Sendungsdokumente - Ursprungsland (WP1)'] = '';
        $row['Sendungsdokumente - Zolltarifnummer (WP1)'] = '';
        $row['Sendungsdokumente - Gewicht (WP1)'] = '';
        $row['Sendungsdokumente - Beschreibung (WP2)'] = '';
        $row['Sendungsdokumente - Menge (WP2)'] = '';
        $row['Sendungsdokumente - Zollwert (WP2)'] = '';
        $row['Sendungsdokumente - Ursprungsland (WP2)'] = '';
        $row['Sendungsdokumente - Zolltarifnummer (WP2)'] = '';
        $row['Sendungsdokumente - Gewicht (WP2)'] = '';
        $row['Sendungsdokumente - Beschreibung (WP3)'] = '';
        $row['Sendungsdokumente - Menge (WP3)'] = '';
        $row['Sendungsdokumente - Zollwert (WP3)'] = '';
        $row['Sendungsdokumente - Ursprungsland (WP3)'] = '';
        $row['Sendungsdokumente - Zolltarifnummer (WP3)'] = '';
        $row['Sendungsdokumente - Gewicht (WP3)'] = '';
        $row['Sendungsdokumente - Beschreibung (WP4)'] = '';
        $row['Sendungsdokumente - Menge (WP4)'] = '';
        $row['Sendungsdokumente - Zollwert (WP4)'] = '';
        $row['Sendungsdokumente - Ursprungsland (WP4)'] = '';
        $row['Sendungsdokumente - Zolltarifnummer (WP4)'] = '';
        $row['Sendungsdokumente - Gewicht (WP4)'] = '';
        $row['Sendungsdokumente - Beschreibung (WP5)'] = '';
        $row['Sendungsdokumente - Menge (WP5)'] = '';
        $row['Sendungsdokumente - Zollwert (WP5)'] = '';
        $row['Sendungsdokumente - Ursprungsland (WP5)'] = '';
        $row['Sendungsdokumente - Zolltarifnummer (WP5)'] = '';
        $row['Sendungsdokumente - Gewicht (WP5)'] = '';
        $row['Sendungsdokumente - Beschreibung (WP6)'] = '';
        $row['Sendungsdokumente - Menge (WP6)'] = '';
        $row['Sendungsdokumente - Zollwert (WP6)'] = '';
        $row['Sendungsdokumente - Ursprungsland (WP6)'] = '';
        $row['Sendungsdokumente - Zolltarifnummer (WP6)'] = '';
        $row['Sendungsdokumente - Gewicht (WP6)'] = '';
        $row['Sendungsdokumente - Einlieferungsstelle'] = '';
        return $row;
    }

    /**
     * @param Shipment $shipment
     * @param string[] $row
     * @return string[]
     */
    protected function injectService(Shipment $shipment, array $row)
    {
        $row['Service - Versandbestätigung - E-Mail Text-Vorlage'] = '';
        $row['Service - Versandbestätigung - E-Mail-Adresse'] = '';
        $row['Service - Nachnahme - Kontoreferenz'] = '';
        $row['Service - Nachnahme - Betrag'] = '';
        $row['Service - Nachnahme - IBAN'] = '';
        $row['Service - Nachnahme - BIC'] = '';
        $row['Service - Nachnahme - Zahlungsempfänger'] = '';
        $row['Service - Nachnahme - Bankname'] = '';
        $row['Service - Nachnahme - Verwendungszweck 1'] = '';
        $row['Service - Nachnahme - Verwendungszweck 2'] = '';
        $row['Service - Transportversicherung - Betrag'] = '';
        $row['Service - Weltpaket - Vorausverfügungstyp'] = '';
        $row['Service - Vorausverfügung'] = '';
        $row['Service - DHL Europaket - Frankaturtyp'] = '';
        $row['Service - Wunschnachbar - Details']
            = $shipment->getReceiver()->getDesiredLocationType() === Wunschpaket::WUNSCHNACHBAR
            ? $shipment->getReceiver()->getDesiredLocation()
            : '';
        $row['Service - Wunschort - Details']
            = $shipment->getReceiver()->getDesiredLocationType() === Wunschpaket::WUNSCHORT
            ? $shipment->getReceiver()->getDesiredLocation()
            : '';
        $row['Service - Alterssichtprüfung - Altersgrenze'] = '';
        $row['Service - Sendungshandling'] = '';
        $row['Service - beliebiger Hinweistext'] = '';
        $row['Service - Zustelldatum'] = $shipment->getReceiver()->getWunschtag();
        $row['Service - ind. Versendervorgabe Kennzeichen'] = '';
        $row['Service - Ident-Check - Vorname'] = '';
        $row['Service - Ident-Check - Nachname'] = '';
        $row['Service - Ident-Check - Geburtsdatum'] = '';
        $row['Service - Ident-Check - Mindestalter'] = '';
        return $row;
    }

    /**
     * @param Shipment $shipment
     * @return string
     */
    protected function determineServiceDetails(Shipment $shipment)
    {
        $process = $shipment->getProcess();
        $details = [$process !== null ? (string)$process->getServiceIdentifier() : 'V01PAK'];
        if ($shipment->getReceiver()->getDesiredLocationType() === Wunschpaket::WUNSCHORT) {
            $details[] = 'V00WO';
        }
        if ($shipment->getReceiver()->getDesiredLocationType() === Wunschpaket::WUNSCHNACHBAR) {
            $details[] = 'V00WN';
        }
        $wunschtag = $shipment->getReceiver()->getWunschtag();
        if (!empty($wunschtag)) {
            $details[] = 'V01PD';
        }
        return implode('.', $details);
    }

    /**
     * @param Shipment[] $entities
     * @return $this
     */
    public function export(array $entities)
    {
        $this->rows = array_merge($this->rows, array_map([$this, 'buildRow'], $entities));
        return $this;
    }

    /**
     * Returns a string (as CSV) containing each exported row.
     *
     * Also deletes the rows that have been exported.
     *
     * @return string
     */
    public function save()
    {
        $header = array_map([$this, 'convertToTargetCharset'], static::$HEADER);
        $rowsWithHeader = array_merge([$header], $this->rows);
        $this->rows = [];

        $csvStream = fopen('php://memory', 'rwb');
        foreach ($rowsWithHeader as $row) {
            fputcsv($csvStream, $row, ';');
        }
        rewind($csvStream);
        $csv = str_replace("\n", "\r\n", stream_get_contents($csvStream));
        fclose($csvStream);

        return $csv;
    }
}
