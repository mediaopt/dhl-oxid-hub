<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2021 Mediaopt GmbH
 */

namespace Mediaopt\DHL\ServiceProvider;

/**
 * Class that represents languages for non-eu countries
 *
 * @author Mediaopt GmbH
 * @package ${NAMenesCen}
 */

/**
 * Languages list:
 * de: Deutsch
 * da: Danisch
 * en: Englisch
 * fr: Französisch
 * el: Griechisch
 * it: Italienisch
 * nl: Niederländisch
 * no: Norwegisch
 * pt: Portugiesisch
 * ru: Russisch
 * es: Spanisch
 * sv: Schwedisch
 */
class CountriesLanguages
{
    /**
     * Array containing all non-eu countries with used languages
     *
     * @var string[]
     */
    public static $LIST = [
        'af' => ['en'], //Afghanistan
        'eg' => ['en', 'fr'], //Ägypten
        'ax' => ['en', 'sv'], //Åland-Inseln
        'al' => ['en'], //Albanien
        'dz' => ['fr', 'en'], //Algerien
        'vi' => ['en'], //Amerikan. Jungferninseln
        'as' => ['en'], //Amerikanisch-Samoa
        'ad' => ['fr'], //Andorra
        'ao' => ['fr', 'es'], //Angola
        'ai' => ['en'], //Anguilla
        'ag' => ['en'], //Antigua und Barbuda
        'gq' => ['fr', 'es'], //Äquatorialguinea
        'ar' => ['en', 'fr', 'es'], //Argentinien
        'am' => ['en', 'fr', 'ru'], //Armenien
        'aw' => ['en', 'nl'], //Aruba
        'sh' => ['en'], //Ascension, St. Helena, Tristan da Cunha
        'az' => ['en', 'fr', 'ru'], //Aserbaidschan
        'et' => ['en'], //Äthiopien
        'au' => ['en'], //Australien, Lord-Howe-Inseln, Tasmanien
        'bs' => ['en'], //Bahamas
        'bh' => ['en'], //Bahrain
        'bd' => ['en'], //Bangladesch
        'bb' => ['en', 'fr'], //Barbados
        'by' => ['en', 'fr', 'ru'], //Belarus
        'bz' => ['en'], //Belize
        'bj' => ['fr'], //Benin
        'gr' => ['en', 'fr'], //Berg Athos
        'bm' => ['en'], //Bermuda
        'bt' => ['en'], //Bhutan
        'bo' => ['es'], //Bolivien
        'bq' => ['en'], //Bonaire, Saba, Sint Eustatius
        'ba' => ['en'], //Bosnien und Herzegowina
        'bw' => ['en'], //Botsuana
        'bv' => ['da', 'en', 'sv'], //Bouvetinsel
        'br' => ['en', 'pt'], //Brasilien
        'bn' => ['en'], //Brunei Darussalam
        'bf' => ['fr'], //Burkina Faso
        'bi' => ['fr'], //Burundi
        'es' => ['en', 'fr', 'es'], //Ceuta, Kanarische Inseln, Melilla
        'cl' => ['en', 'es'], //Chile
        'cn' => ['en'], //China, Volksrepublik (ohne Hongkong, Taiwan)
        'ck' => ['en'], //Cookinseln
        'cr' => ['en', 'es'], //Costa Rica
        'ci' => ['en', 'fr'], //Côte d´Ivoire, Republik
        'cw' => ['en', 'es'], //Curaçao
        'dm' => ['en'], //Dominica
        'do' => ['es'], //Dominikanische Republik
        'dj' => ['fr'], //Dschibuti
        'ec' => ['es'], //Ecuador
        'sv' => ['en', 'fr', 'es'], //El Salvador
        'er' => ['en'], //Eritrea
        'fk' => ['en'], //Falklandinseln
        'fo' => ['en', 'fr'], //Färöer
        'fj' => ['en'], //Fidschi
        'gf' => ['en', 'fr'], //Französisch-Guayana
        'pf' => ['en', 'fr'], //Französisch-Polynesien
        'ga' => ['en', 'fr'], //Gabun
        'gm' => ['en'], //Gambia
        'ge' => ['en', 'fr'], //Georgien
        'gh' => ['en'], //Ghana
        'gi' => ['en'], //Gibraltar
        'gd' => ['en'], //Grenada
        'gl' => ['fr'], //Grönland
        'gb' => ['en'], //Großbritannien
        'gp' => ['en', 'fr'], //Guadeloupe
        'gu' => ['en'], //Guam
        'gt' => ['en', 'es'], //Guatemala
        'gg' => ['en'], //Guernsey, Kanalinseln
        'gn' => ['fr'], //Guinea
        'gw' => ['fr'], //Guinea-Bissau
        'gy' => ['en'], //Guyana
        'ht' => ['fr'], //Haiti
        'hm' => ['en'], //Heard- und McDonaldinseln
        'hn' => ['es'], //Honduras
        'hk' => ['en'], //Hongkong
        'in' => ['en'], //Indien
        'id' => ['en'], //Indonesien
        'iq' => ['en', 'fr', 'es'], //Irak
        'ir' => ['en', 'fr'], //Iran
        'is' => ['da', 'en', 'no', 'sv'], //Island
        'im' => ['en'], //Isle of Man
        'il' => ['en', 'fr'], //Israel
        'jm' => ['en'], //Jamaika
        'jp' => ['en', 'fr'], //Japan
        'ye' => ['en'], //Jemen
        'je' => ['en'], //Jersey
        'jo' => ['en'], //Jordanien
        'vg' => ['en'], //Jungferninseln
        'ky' => ['en'], //Kaiman-Inseln
        'kh' => ['en'], //Kambodscha
        'cm' => ['en', 'fr'], //Kamerun
        'ca' => ['en', 'fr'], //Kanada
        'cv' => ['en', 'fr', 'es'], //Kap Verde
        'kz' => ['en'], //Kasachstan
        'qa' => ['en'], //Katar
        'ke' => ['en'], //Kenia
        'kg' => ['en', 'fr', 'ru'], //Kirgisistan
        'ki' => ['en'], //Kiribati
        'cc' => ['en'], //Kokosinseln, Keelinginseln
        'co' => ['en', 'es'], //Kolumbien
        'km' => ['fr'], //Komoren
        'cd' => ['fr'], //Kongo, Demokratische Republik
        'cg' => ['fr'], //Kongo, Republik
        'kp' => ['fr'], //Korea, Nord
        'kr' => ['en'], //Korea, Süd
        'cu' => ['es'], //Kuba
        'kw' => ['en'], //Kuwait
        'la' => ['en', 'fr'], //Laos
        'ls' => ['en'], //Lesotho
        'lb' => ['en', 'fr'], //Libanon
        'lr' => ['en'], //Liberia
        'ly' => ['en', 'fr'], //Libyen
        'li' => ['de', 'en', 'fr', 'it'], //Liechtenstein
        'mo' => ['en', 'pt'], //Macau
        'mg' => ['fr'], //Madagaskar
        'mw' => ['en'], //Malawi
        'my' => ['en'], //Malaysia
        'mv' => ['en'], //Malediven
        'ml' => ['fr', 'en'], //Mali
        'ma' => ['en', 'fr', 'es'], //Marokko (inkl. Westsahara)
        'mh' => ['en'], //Marschallinseln
        'mq' => ['en', 'fr'], //Martinique
        'mr' => ['fr'], //Mauretanien
        'mu' => ['en', 'fr'], //Mauritius
        'yt' => ['en', 'fr'], //Mayotte
        'mx' => ['en', 'fr', 'es'], //Mexiko
        'fm' => ['en'], //Mikronesien (Föderierte Staaten von Mikronesien)
        'md' => ['en', 'fr', 'ru'], //Moldau, Republik
        'mn' => ['en'], //Mongolei
        'me' => ['en', 'fr'], //Montenegro, Republik
        'ms' => ['en'], //Montserrat
        'mz' => ['en', 'fr', 'pt'], //Mosambik
        'mm' => ['en'], //Myanmar
        'na' => ['en'], //Namibia
        'nr' => ['en'], //Nauru
        'np' => ['en'], //Nepal
        'nc' => ['fr'], //Neukaledonien
        'nz' => ['en'], //Neuseeland
        'ni' => ['en', 'fr', 'es'], //Nicaragua
        'ne' => ['fr'], //Niger
        'ng' => ['en'], //Nigeria
        'nu' => ['en'], //Niue
        'mp' => ['en'], //Nördliche Marianen
        'mk' => ['en', 'fr'], //Nordmazedonien (Republik)
        'nf' => ['en'], //Norfolkinsel
        'no' => ['da', 'en', 'sv'], //Norwegen
        'om' => ['en'], //Oman
        'tl' => ['en'], //Ost Timor
        'pk' => ['en'], //Pakistan
        'ps' => ['en', 'fr'], //Palästinensische Autonomiegebiete
        'pw' => ['en'], //Palau
        'pa' => ['en', 'fr', 'es'], //Panama
        'pg' => ['en'], //Papua-Neuguinea
        'py' => ['en', 'es'], //Paraguay
        'pe' => ['en', 'es', 'fr'], //Peru
        'ph' => ['en'], //Philippinen
        'pn' => ['en'], //Pitcairninseln
        'pr' => ['en'], //Puerto Rico
        're' => ['en', 'fr'], //Réunion
        'rw' => ['en', 'fr'], //Ruanda
        'ru' => ['en', 'fr', 'ru'], //Russische Föderation
        'mf' => ['en', 'fr'], //Saint Martin
        'bl' => ['en', 'fr'], //Saint-Barthélemy
        'sb' => ['en'], //Salomonen
        'zm' => ['en'], //Sambia
        'ws' => ['en'], //Samoa
        'sm' => ['en', 'fr'], //San Marino
        'st' => ['fr', 'pt'], //São Tomé und Príncipe
        'sa' => ['en'], //Saudi-Arabien, Königreich
        'ch' => ['de', 'en', 'fr', 'it'], //Schweiz
        'sn' => ['fr'], //Senegal
        'rs' => ['en', 'fr'], //Serbien, Republik
        'sc' => ['en', 'fr'], //Seychellen
        'sl' => ['en'], //Sierra Leone
        'zw' => ['en'], //Simbabwe
        'sg' => ['en'], //Singapur, Republik
        'sx' => ['en'], //Sint Maarten
        'so' => ['en', 'fr'], //Somalia
        'lk' => ['en'], //Sri Lanka
        'kn' => ['en'], //St. Kitts und Nevis
        'lc' => ['en'], //St. Lucia
        'pm' => ['en', 'fr'], //St. Pierre und Miquelon
        'vc' => ['en'], //St. Vincent und die Grenadinen
        'za' => ['en'], //Südafrika
        'sd' => ['en'], //Sudan
        'ss' => ['en'], //Südsudan
        'sr' => ['en'], //Suriname
        'sj' => ['da', 'en', 'sv'], //Svalbard (Spitzbergen) & Jan Mayen
        'sz' => ['en'], //Swasiland
        'sy' => ['en'], //Syrien
        'tj' => ['en', 'fr', 'ru'], //Tadschikistan
        'tw' => ['en', 'fr'], //Taiwan
        'tz' => ['en'], //Tansania
        'th' => ['en'], //Thailand
        'tg' => ['en', 'fr'], //Togo
        'tk' => ['en'], //Tokelau
        'to' => ['en'], //Tonga
        'tt' => ['en'], //Trinidad und Tobago
        'td' => ['fr'], //Tschad
        'tn' => ['en', 'fr'], //Tunesien
        'tr' => ['en', 'fr'], //Türkei
        'tm' => ['en', 'ru'], //Turkmenistan
        'tc' => ['en'], //Turks- und Caicosinseln
        'tv' => ['en'], //Tuvalu
        'ug' => ['en'], //Uganda
        'ua' => ['en', 'fr', 'ru'], //Ukraine
        'uy' => ['en', 'fr', 'es'], //Uruguay
        'uz' => ['en', 'fr', 'ru'], //Usbekistan
        'vu' => ['en', 'fr'], //Vanuatu
        'va' => ['en', 'fr'], //Vatikan
        've' => ['es'], //Venezuela
        'ae' => ['en'], //Vereinigte Arabische Emirate
        'us' => ['en'], //Vereinigte Staaten von Amerika
        'vn' => ['en'], //Vietnam
        'wf' => ['fr'], //Wallis und Futuna
        'cx' => ['en'], //Weihnachtsinsel
        'cf' => ['fr'], //Zentralafrikanische Republik
        'cy' => ['en', 'fr'], //Zypern, Republik (Nordteil)
    ];
}