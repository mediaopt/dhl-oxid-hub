# README

## Generate Parcel Shipping API

We use [Jane](https://github.com/janephp/janephp) to generate the Parcel Shipping API.
In particular, we use the package [jane-php/open-api-3](https://packagist.org/packages/jane-php/open-api-3).

1. Download OpenAPI specification: `curl -H "Accept: application/yaml" 'https://app.swaggerhub.com/apiproxy/registry/dpdhl/DHL-Parcel-DE-Shipping/2.0.2?resolved=true&flatten=true&pretty=true' > parcel-shipping-openapi.yaml`
2. Adapt the `parcel-shipping-openapi.yaml` file to our needs:
   1. The endpoint parameter `Authorization` causes problems with Jane, since Jane uses a plugin to set the authorization header based on the `security` definition.
      Therefore, we need to remove the `Authorization` parameter from the `parameters` section of each endpoint. 
      ```yaml
      #      - name: Authorization
      #        in: header
      #        description: Basic Auth String
      #        required: true
      #        style: simple
      #        explode: false
      #        schema:
      #          type: string
      ```
   2. The `shipment` parameter for some endpoints is supposed to be a repeated value, which causes problems with Jane.
      Since we don't need this feature, we adapt the `shipment` parameter to be a single value:
      ```yaml 
            - name: shipment
              in: query
              description: This parameter identifies shipments. The parameter can be used multiple times in one request to get the labels and/or documents for up to 30 shipments maximum. Only documents and label for shipments that are not yet closed can be retrieved.
              required: true
              style: form
              explode: true
              schema:
                type: string
      #          type: array
      #          items:
      #            type: string
      ```
3. Ensure appropriate environment for running Jane: `docker run -ti -v $PWD:/var/www/html --rm --entrypoint=bash <php-image>` or similar.
4. Generate API: `src/modules/mo/mo_dhl/vendor/bin/jane-openapi generate -c jane.php`