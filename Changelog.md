# Changelog
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
