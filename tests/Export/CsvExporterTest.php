<?php

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Address\Receiver;
use Mediaopt\DHL\Address\Sender;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Export\CsvExporter;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Shipment\Contact;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use Mediaopt\DHL\Shipment\Shipment;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */
class CsvExporterTest extends PHPUnit_Framework_TestCase
{
    const PROCESS_IDENTIFIERS = [
        Process::PAKET,
        Process::PAKET_PRIO,
        Process::PAKET_TAGGLEICH,
        Process::PAKET_INTERNATIONAL,
        Process::EUROPAKET,
        Process::PAKET_CONNECT,
        Process::PAKET_INTERNATIONAL_AT,
        Process::PAKET_AT,
        Process::PAKET_CONNECT_AT,
    ];

    const EXPECTED_ROW = [
        'Sendungsreferenz'                            => 'OXID-42',
        'Sendungsdatum'                               => '15.08.2016',
        'Absender Name 1'                             => 'Mediaopt GmbH',
        'Absender Name 2'                             => '1234567890',
        'Absender Name 3'                             => 'Armin Admin',
        'Absender Straße'                             => 'Elbestr.',
        'Absender Hausnummer'                         => '28',
        'Absender PLZ'                                => '12045',
        'Absender Ort'                                => 'Berlin-Neukölln',
        'Absender Provinz'                                   => '',
        'Absender Land'                                      => 'DEU',
        'Absenderreferenz'                                   => '',
        'Absender E-Mail-Adresse'                            => '',
        'Absender Telefonnummer'                             => '',
        'Empfänger Name 1'                                   => 'modiaept',
        'Empfänger Name 2 / Postnummer'                      => '12345678',
        'Empfänger Name 3'                                   => 'Arno Nühm',
        'Empfänger Straße'                                   => 'Wassermannstr.',
        'Empfänger Hausnummer'                               => '58',
        'Empfänger PLZ'                                      => '12489',
        'Empfänger Ort'                                      => 'Berlin-Adlershof',
        'Empfänger Provinz'                                  => '',
        'Empfänger Land'                                     => 'DEU',
        'Empfängerreferenz'                                  => '',
        'Empfänger E-Mail-Adresse'                           => 'arno@nue.hm',
        'Empfänger Telefonnummer'                            => '007',
        'Gewicht'                                            => '42,2300',
        'Länge'                                              => '',
        'Breite'                                             => '',
        'Höhe'                                               => '',
        'Produkt- und Servicedetails'                        => 'V01PAK.V00WN.V01PD',
        'Retourenempfänger Name 1'                           => '',
        'Retourenempfänger Name 2'                           => '',
        'Retourenempfänger Name 3'                           => '',
        'Retourenempfänger Straße'                           => '',
        'Retourenempfänger Hausnummer'                       => '',
        'Retourenempfänger PLZ'                              => '',
        'Retourenempfänger Ort'                              => '',
        'Retourenempfänger Provinz'                          => '',
        'Retourenempfänger Land'                             => '',
        'Retourenrempfänger E-Mail-Adresse'                  => '',
        'Retourenempfänger Telefonnummer'                    => '',
        'Retouren-Abrechnungsnummer'                         => '',
        'Abrechnungsnummer'                                  => '123456879001DD',
        'Service - Versandbestätigung - E-Mail Text-Vorlage' => '',
        'Service - Versandbestätigung - E-Mail-Adresse'      => '',
        'Service - Nachnahme - Kontoreferenz'                => '',
        'Service - Nachnahme - Betrag'                       => '',
        'Service - Nachnahme - IBAN'                         => '',
        'Service - Nachnahme - BIC'                          => '',
        'Service - Nachnahme - Zahlungsempfänger'            => '',
        'Service - Nachnahme - Bankname'                     => '',
        'Service - Nachnahme - Verwendungszweck 1'           => '',
        'Service - Nachnahme - Verwendungszweck 2'           => '',
        'Service - Transportversicherung - Betrag'           => '',
        'Service - Weltpaket - Vorausverfügungstyp'          => '',
        'Service - Vorausverfügung'                          => '',
        'Service - DHL Europaket - Frankaturtyp'             => '',
        'Sendungsdokumente - Ausfuhranmeldung'               => '',
        'Sendungsdokumente - Rechnungsnummer'                => '',
        'Sendungsdokumente - Genehmigungsnummer'             => '',
        'Sendungsdokumente - Bescheinigungsnummer'           => '',
        'Sendungsdokumente - Sendungsart'                    => '',
        'Sendungsdokumente - Beschreibung'                   => '',
        'Sendungsdokumente - Entgelte'                       => '',
        'Sendungsdokumente - Gesamtnettogewicht'             => '',
        'Sendungsdokumente - Beschreibung (WP1)'             => '',
        'Sendungsdokumente - Menge (WP1)'                    => '',
        'Sendungsdokumente - Zollwert (WP1)'                 => '',
        'Sendungsdokumente - Ursprungsland (WP1)'            => '',
        'Sendungsdokumente - Zolltarifnummer (WP1)'          => '',
        'Sendungsdokumente - Gewicht (WP1)'                  => '',
        'Sendungsdokumente - Beschreibung (WP2)'             => '',
        'Sendungsdokumente - Menge (WP2)'                    => '',
        'Sendungsdokumente - Zollwert (WP2)'                 => '',
        'Sendungsdokumente - Ursprungsland (WP2)'            => '',
        'Sendungsdokumente - Zolltarifnummer (WP2)'          => '',
        'Sendungsdokumente - Gewicht (WP2)'                  => '',
        'Sendungsdokumente - Beschreibung (WP3)'             => '',
        'Sendungsdokumente - Menge (WP3)'                    => '',
        'Sendungsdokumente - Zollwert (WP3)'                 => '',
        'Sendungsdokumente - Ursprungsland (WP3)'            => '',
        'Sendungsdokumente - Zolltarifnummer (WP3)'          => '',
        'Sendungsdokumente - Gewicht (WP3)'                  => '',
        'Sendungsdokumente - Beschreibung (WP4)'             => '',
        'Sendungsdokumente - Menge (WP4)'                    => '',
        'Sendungsdokumente - Zollwert (WP4)'                 => '',
        'Sendungsdokumente - Ursprungsland (WP4)'            => '',
        'Sendungsdokumente - Zolltarifnummer (WP4)'          => '',
        'Sendungsdokumente - Gewicht (WP4)'                  => '',
        'Sendungsdokumente - Beschreibung (WP5)'             => '',
        'Sendungsdokumente - Menge (WP5)'                    => '',
        'Sendungsdokumente - Zollwert (WP5)'                 => '',
        'Sendungsdokumente - Ursprungsland (WP5)'            => '',
        'Sendungsdokumente - Zolltarifnummer (WP5)'          => '',
        'Sendungsdokumente - Gewicht (WP5)'                  => '',
        'Sendungsdokumente - Beschreibung (WP6)'             => '',
        'Sendungsdokumente - Menge (WP6)'                    => '',
        'Sendungsdokumente - Zollwert (WP6)'                 => '',
        'Sendungsdokumente - Ursprungsland (WP6)'            => '',
        'Sendungsdokumente - Zolltarifnummer (WP6)'          => '',
        'Sendungsdokumente - Gewicht (WP6)'                  => '',
        'Sendungsreferenz (Retoure)'                         => '',
        'Absender Adresszusatz 1'                            => '',
        'Absender Adresszusatz 2'                            => '',
        'Absender Zustellinformation'                        => '',
        'Absender Ansprechpartner'                           => '',
        'Empfänger Adresszusatz 1'                    => '',
        'Empfänger Adresszusatz 2'                    => '',
        'Empfänger Zustellinformation'                => '',
        'Empfänger Ansprechpartner'                   => '',
        'Retourenempfänger Adresszusatz 1'            => '',
        'Retourenempfänger Adresszusatz 2'            => '',
        'Retourenempfänger Zustellinformation'        => '',
        'Retourenempfänger Ansprechpartner'           => '',
        'Service - Wunschnachbar - Details'           => 'Rudi Mentär',
        'Service - Wunschort - Details'               => '',
        'Service - Alterssichtprüfung - Altersgrenze' => '',
        'Service - Sendungshandling'                  => '',
        'Service - beliebiger Hinweistext'            => '',
        'Service - Zustelldatum'                      => '14.02.2018',
        'Sendungsdokumente - Einlieferungsstelle'     => '',
        'Creation-Software'                           => CsvExporter::CREATOR_TAG,
        'Service - ind. Versendervorgabe Kennzeichen' => '',
        'Service - Ident-Check - Vorname'             => '',
        'Service - Ident-Check - Nachname'            => '',
        'Service - Ident-Check - Geburtsdatum'        => '',
        'Service - Ident-Check - Mindestalter'        => '',
    ];

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create();
    }

    protected function buildSampleReceiver($locationType)
    {
        $contact = new Contact('Arno Nühm', 'arno@nue.hm', '007', 'modiaept');
        $address = new Address('Wassermannstr.', '58', '12489', 'Berlin-Adlershof');
        $wunschtag = '14.02.2018';
        return new Receiver($contact, '12345678', $address, $locationType, 'Rudi Mentär', $wunschtag);
    }

    protected function buildSampleSender()
    {
        $address = new Address('Elbestr.', '28', '12045', 'Berlin-Neukölln');
        return new Sender($address, 'Mediaopt GmbH', '1234567890', 'Armin Admin');
    }

    protected function buildSampleOrder($locationType)
    {
        $receiver = $this->buildSampleReceiver($locationType);
        $sender = $this->buildSampleSender();
        $order = new Shipment('OXID-42', $receiver, $sender, 42.23, '15.08.2016');
        $order->setEkp(Ekp::build('1234568790'));
        $order->setParticipation(Participation::build('DD'));
        $order->setProcess(Process::build(Process::PAKET));
        return $order;
    }

    public function testSave()
    {
        $exporter = new CsvExporter('UTF-8');
        $exporter->export([$this->buildSampleOrder(''), $this->buildSampleOrder('')]);
        $exporter->save();
    }

    public function testThatSaveContainsTheBillingNumber()
    {
        $billingNumber = $this->buildSampleBillingNumber();
        $order = $this->buildSampleOrder('')->setBillingNumber($billingNumber);
        $exporter = new CsvExporter('UTF-8');
        $exporter->export([$order]);
        $this->assertContains((string)$order->getBillingNumber(), $exporter->save());
    }

    public function testThatSaveContainsTheServiceIdentifier()
    {
        for ($i = 0; $i < 10; $i++) {
            $process = $this->buildSampleProcess();
            $order = $this->buildSampleOrder('')->setProcess($process);
            $exporter = new CsvExporter('UTF-8');
            $exporter->export([$order]);
            $this->assertContains((string)$process->getServiceIdentifier(), $exporter->save());
        }
    }

    public function testSaveWithWunschort()
    {
        $orderWithWunschort = $this->buildSampleOrder('Wunschort');
        $exporter = new CsvExporter('UTF-8');
        $exporter->export([$orderWithWunschort]);
        $exporter->save();
    }

    public function testSaveWithWunschnachbar()
    {
        $orderWithWunschort = $this->buildSampleOrder('Wunschnachbar');
        $exporter = new CsvExporter('UTF-8');
        $exporter->export([$orderWithWunschort]);
        $exporter->save();
    }

    public function testThatSaveContainsTheHeaderRow()
    {
        for ($i = 0; $i < 3; $i++) {
            $exporter = new CsvExporter('UTF-8');
            $exporter->export(array_fill(0, mt_rand(0, 10), $this->buildSampleOrder('')));
            [$header] = explode("\r\n", $exporter->save());
            $stream = fopen('php://memory', 'rwb');
            fwrite($stream, $header);
            rewind($stream);
            $header = fgetcsv($stream, 0, ';');
            fclose($stream);
            $this->assertEquals('Sendungsreferenz', $header[0]);
        }
    }

    public function testThatSaveReturnsTwoLinesMoreThanRowsWereExported()
    {
        for ($i = 0; $i < 10; $i++) {
            $exporter = new CsvExporter('UTF-8');
            $exporter->export(array_fill(0, $i, $this->buildSampleOrder('')));
            $this->assertCount(2 + $i, explode("\r\n", $exporter->save()));
        }
    }

    public function testThatSaveReturnsAStringWithWindowsStyleLineEndings()
    {
        $exporter = new CsvExporter('UTF-8');
        $exporter->export([$this->buildSampleOrder('')]);
        $csv = $exporter->save();
        $this->assertEquals(substr_count($csv, "\r\n"), substr_count($csv, "\n"));
    }

    public function testThatSaveContainsRelevantInformation()
    {
        $exporter = new CsvExporter('UTF-8');
        $exporter->export([$this->buildSampleOrder(Wunschpaket::WUNSCHNACHBAR)]);
        $row = explode("\r\n", $exporter->save())[1];
        $stream = fopen('php://memory', 'rwb');
        fwrite($stream, $row);
        rewind($stream);
        $row = fgetcsv($stream, 0, ';');
        fclose($stream);

        $index = 0;
        foreach (self::EXPECTED_ROW as $key => $value) {
            $this->assertEquals(iconv('UTF-8', CsvExporter::TARGET_CHARSET, $value), $row[$index], $key);
            $index++;
        }
    }

    public function testGetCharset()
    {
        foreach (['UTF-8', 'UTF-16', 'ISO-8859-1', 'WINDOWS-1252'] as $charset) {
            $this->assertEquals($charset, (new CsvExporter($charset))->getCharset());
        }
    }

    protected function buildSampleBillingNumber()
    {
        return new BillingNumber(
            $this->buildSampleEkp(),
            $this->buildSampleProcess(),
            $this->buildSampleParticipation()
        );
    }

    protected function buildSampleProcess()
    {
        return Process::build($this->faker->randomElement(self::PROCESS_IDENTIFIERS));
    }

    protected function buildSampleEkp()
    {
        return Ekp::build(implode('', $this->faker->randomElements(range(0, 9), 10, true)));
    }

    protected function buildSampleParticipation()
    {
        $characterSet = array_merge(range(0, 9), range('A', 'Z'));
        return Participation::build(implode('', $this->faker->randomElements($characterSet, 2, true)));
    }
}
