# Changelog

## 1.7.1
* NoNeighbourDelivery service added
* NamedPersonOnly service added

## 1.7.0
* dont allow Packstation and Postfiliale as delivery address street names for regular addresses
* show a list of branches when google maps api key is not provided
* async google maps js load
* bugfix:validate fields before saving in order dhl tab
* bugfix: show correct error messages if wunschpaket is not enabled
* bugfix: use del address inputs if no address is selected
* bugfix: prevent label generation in batch mode if order has no dhl product assigned

## 1.6.9
* removed unused DHL products
* bugfix for Ident in GKV API
* split name of sender and return receiver in name1, name2 and name3 for custom labels

## 1.6.8
* bugfix: improved PHP 8.1 compatibility
* fixed country value not being sent in form

## 1.6.7
* bugfix: remove PackstationType.php
* bugfix: prevent null parameter in html_entity_decode
* bugfix for custom label with Postfiliale

## 1.6.6
* new Service CDP (Closest Droppoint) for Paket International
* bugfix: multibyte substring problem for article title in export documents 
* templating changes: proper use of smarty.block.parent call in chipping country form
* extended output for soap errors

## 1.6.5
* bugfix for selecting a Paketshop in the Filialfinder


## 1.6.4
* new Service PDDP (Postal Delivery Duty Paid) for Paket International

## 1.6.3
* bugfix: don't apply the billing country to an existing delivery address
* add order numbers to Soap fault log messages in GKV calls

## 1.6.2
* filter out results not suitable to receive packages

## 1.6.1
* add weight inputs for articles in custom label form
* use article weight over orderarticle weight
* handle comma in weight inputs in custom label form
* added optional radius as parameter for location searches

## 1.6.0
* new Warenpost International process

## 1.5.9
* bugfix for empty additional sender lines

## 1.5.8
* sender data build logic updated for warenpost international
* retoure and individual label buttons removed for warenpost international
* package announcement customisation link added in settings  

## 1.5.7
* use existing mandant id for prodws requests

## 1.5.6
* renamed DHL services

## 1.5.5
* display company on custom label creation form
* warenpost international request formatting to be compliant to API
* add piece origin to warenpost international request for compliance to non EU delivery 
* bugfix: catch internetmarke refund error on admin controller

## 1.5.4
* use existing partner id for warenpost requests

## 1.5.3
* bugfix: add country selection to standortsuche in wave theme
* add complete bank data for cash on delivery
* adjusted valid preferred day check to handle test errorrs

## 1.5.2
* set note1 for cash on delivery

## 1.5.1
* same weight calculation for local and international delivery
* weight calculation fix: use package weight only if calculate weight is active

## 1.5.0
* New product: Warenpost International
* specify endorsement for parcel send via Paket International

## 1.4.4
* check for comma in weight settings and replace it with a dot
* improved error handling for gkv requests
* bugfix for call to TableViewNameGenerator

## 1.4.3
* bugfix for special character handling in label data

## 1.4.2
* added address delete button to flow template
* fixed javascript to not delete address delete button
* resized logo
* error handling in admin controllers
* delete tracking code from order if corresponding label is deleted
* improved weight calculation
* set ordernr as customer reference
* correct insurance rules for non-EUR currencies
* premium service available for DHL International delivery
* display article title in a language dependant on the receiver country in export documents
* tarif number can be assigned to articles and will be displayed in export documents
* bugfix: corect special chars in lables for name, articles and address

## 1.4.1
* removed tracking pixel

## 1.4.0
* integrated the Internetmarke Products
* new Standortsuche using Location Finder - Unified

## 1.3.1
* open links to dhl from the oxid admin in a new tab
* set active flag of services in gkv to 0/1 instead of false/true
* fix links to logs in the module config tab in oxid admin

## 1.3.0
* create export documents for international shipments
* allows international shipments outside the EU
* bugfix: check for user, address and payment data when showing wunschpaket services
* bugfix: oxid 6.2 compatible email rendering
* bugfix: check for basket existance when calculating surcharge in emails

## 1.2.4
* bugfix for article parent extension

## 1.2.3
* added additional features for return label creation:
    * option do prevent customers to create return labels and instead let them request them
    * return label creation link in emails
    * sending an email with the return label to the customer after it was created
    * return label creation for guest order
* change additional services in custom label creation process
* bugfix for basket without user
* bugfix don't allow non german packstation in filialfinder results

## 1.2.2
* added a list of additional services:
    * bulky goods (assign per product or category)
    * visual check of age (assign per product or category)
    * additional incurance (assign per shipping method)
    * ident check (assign per shipping method)
    * cash on delivery (assign per payment method)
* retoure international for returns outside the EU
* set a time span in which customers are allowed to create return labels after products were sent

## 1.2.1
* store shipment number in oxtrackcode field of order after delivery label creation
* display dhl tracking link when oxtrackcode was set via delivery label creation

## 1.2.0
* create return labels in the oxid admin
* allow users to create return labels in the frontend
* display return labels and return label QR codes
* define the receiverID for returns on a per country level

## 1.1.1
* fixed HTML layout

## 1.1.0
* product Warenpost is now available
* only those services are selectable and sent that are available for the product
* GoGreen label can be displayed for dhl deliveries on the checkout overview page

## 1.0.5
* Removed preferred time

## 1.0.4
* Oxid 6.2 compatibility

## 1.0.3
* Bugfix: put addinfo data in name3 field to display it on labels
* use real shipment methods for credentials check

## 1.0.2
* Bugfix: use Mediaopt credentials for GKV requests and add customer gkv login to requests

## 1.0.1
* Bugfix: use Mediaopt credentials for Wunschpaket and Standortsuche requests

## 1.0.0
* Initial release of the DHL Produkte und Services plugin for OXID.
