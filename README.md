# Post & DHL Versand Oxid Modul
Über die Deutsche Post & DHL Integration in Oxid können Versandscheine manuell oder automatisch aus dem Oxid Backend erzeugt werden. Im Checkout Ihres Onlineshops können Ihre Kunden mehrere Empfängerservices auswählen und so ganz flexibel ihren Versand steuern.

## Links 
* https://www.dhl.de/de/geschaeftskunden/paket/versandsoftware/partnersysteme/oxid-esales.html
* https://github.com/mediaopt/dhl-oxid-hub/wiki/Post-&-DHL-Versand-Oxid-Modul

## Generate Parcel Shipping API (Module developers only)

We use [Jane](https://github.com/janephp/janephp) to generate the Parcel Shipping API.
In particular, we use the package [jane-php/open-api-3](https://packagist.org/packages/jane-php/open-api-3).

1. Download OpenAPI specification from https://developer.dhl.com/api-reference/parcel-de-shipping-post-parcel-germany-v2#downloads-section
2. Ensure appropriate environment for running Jane: `docker run -ti -v $PWD:/var/www/html --rm --entrypoint=bash <php-image>` or similar.
3. Generate API: `src/modules/mo/mo_dhl/vendor/bin/jane-openapi generate -c jane.php`