<?php
$sLangName = 'English';
$aLang = [
    'charset' => 'UTF-8',

    'moOrderBatch'                                 => 'DHL Batch Processing',
    'MO_DHL__BATCH_TITLE'                          => 'DHL Batch Processing',
    'MO_DHL__EXPORT'                               => 'Export',
    'MO_DHL__BATCH_ERROR_NO_ORDER_SELECTED'        => 'Please select at least one order.',
    'MO_DHL__EXPORT_ORDERS_WITHOUT_BILLING_NUMBER' => 'A billing number could not be determined for the shipments with one the following references: %s',
    'MO_DHL__BATCH_ERROR_CREATION_ERROR'           => 'The label for order nr. %s could not be created because of: %s',
    'MO_DHL__LAST_DHL_STATUS'                      => 'Status of the last label creation task',
    'MO_DHL__ELEMENTS_PER_PAGE'                    => 'Elements per page',
    'MO_DHL__ORDER_DHL'                            => 'DHL',
    'MO_DHL__PROCESS_AND_PARTICIPATION'            => 'Process and Participation numbers',
    'MO_DHL__WUNSCHPAKET'                          => 'Preferred delivery options',
    'MO_DHL__WUNSCHTAG'                            => 'Preferred day',
    'MO_DHL__WUNSCHORT'                            => 'Drop-off location',
    'MO_DHL__WUNSCHNACHBAR'                        => 'Neighbour',
    'MO_DHL__EKP'                                  => 'EKP',
    'MO_DHL__EKP_ERROR'                            => 'An EKP consists of exactly ten digits.',
    'MO_DHL__FILIALROUTING_EMAIL_ERROR'            => 'The alternative e-mail address for Filialrouting was not valid and therefor was reset.',
    'MO_DHL__PARTICIPATION_NUMBER'                 => 'Participation number',
    'MO_DHL__INTERNETMARKE_PRODUCT_NUMBER'         => 'Product-Id',
    'HELP_MO_DHL__INTERNETMARKE_PRODUCT_NUMBER'    => 'Please use an ID from the list in DHL > Internetmarke > Products.',
    'MO_DHL__PARTICIPATION_NUMBER_ERROR'           => 'A participation number is exactly two characters long and consists solely of letters and digits',
    'MO_DHL__INTERNETMARKE_PRODUCT_ERROR'          => 'The specified product for Internetmarke could not be found. Please use an ID from the list in DHL > Internetmarke > Products.',
    'MO_DHL__OPERATOR'                             => 'Delivery operator',
    'HELP_MO_DHL__OPERATOR'                        => 'Please provide the name of the delivery operator. This information is needed for a possible return outside the EU.',
    'MO_DHL__CUSTOMER_RETOURE_REQUEST_STATUS'      => 'Customer retoure request status',
    'MO_DHL__REQUESTED'                            => 'Requested',
    'MO_DHL__CREATED'                              => 'Created',
    'MO_DHL__DECLINED'                             => 'Declined',
    'MO_DHL__PROCESS_IDENTIFIER'                   => 'Process number',
    'MO_DHL__PROCESS_IDENTIFIER_ERROR'             => 'Please choose a process number from the list.',
    'MO_DHL__DELIVERYSET_DHL'                      => 'DHL',
    'MO_DHL__DELIVERY_DHL'                         => 'DHL',
    'MO_DHL__PAYMENTS_DHL'                         => 'DHL',
    'MO_DHL__EXCLUDED'                             => 'Excluded',
    'MO_DHL_SAVE_AND_CHECK'                        => 'Save and check credentials',
    'MO_DHL__NO_DELIVERYSET'                       => 'Please configure at least one shipping method to use the dhl services',
    'MO_DHL__CHECKING_DELIVERYSET'                 => 'Testing shipping method ',
    'MO_DHL__CORRECT_CREDENTIALS'                  => 'Credentials are corrent',
    'MO_DHL__INCORRECT_CREDENTIALS'                => 'Credentials are incorrect. Please review your credentials.',
    'MO_DHL__CHECK_FOR_SANDBOX_NOT_POSSIBLE'       => 'The credentials can\'t be checked if the sandbox mode is active.',
    'MO_DHL__LOGIN_FAILED'                         => 'Credentials are incorrect. Login failed.',
    'MO_DHL__LABELS'                               => 'Labels',
    'MO_DHL__LABEL'                                => 'Delivery label',
    'MO_DHL__EXPORT_LABEL'                         => 'Export label',
    'MO_DHL__RETOURE_LABEL'                        => 'Retoure label',
    'MO_DHL__RETOURE_QR_LABEL'                     => 'Retoure QR Code',
    'MO_DHL__INSTALL_FOLDER_ERROR'                 => 'The directory %s could not be created. Please create it manually',
    'MO_DHL__CREATE_LABEL'                         => 'Create a new delivery label',
    'MO_DHL__CREATE_LABELS'                        => 'Create labels',
    'MO_DHL__CREATE_RETOURE_LABELS'                => 'Create Retoure labels',
    'MO_DHL__DELETE_SHIPMENT'                      => 'Cancel shipment',

    'MO_DHL__CUSTOM_LABEL_CREATE'             => 'Create individual label',
    'MO_DHL__CUSTOM_LABEL_BACK'               => 'Back',
    'MO_DHL__CUSTOM_LABEL_GENERAL'            => 'General',
    'MO_DHL__CUSTOM_LABEL_WEIGHT'             => 'Weight (in kg)',
    'MO_DHL__CUSTOM_LABEL_WEIGHT_PER_ARTICLE' => 'Weight per article',
    'MO_DHL__CUSTOM_LABEL_PROCESS'            => 'Process no.',
    'MO_DHL__CUSTOM_LABEL_RECEIVER'           => 'Receiver',
    'MO_DHL__CUSTOM_LABEL_RETURN_RECEIVER'    => 'Return Shipment - Receiver data',
    'MO_DHL__CUSTOM_LABEL_NAME'               => 'Name',
    'MO_DHL__CUSTOM_LABEL_MAIL'               => 'E-Mail',
    'MO_DHL__CUSTOM_LABEL_PHONE'              => 'Phone number',
    'MO_DHL__CUSTOM_LABEL_COMPANY'            => 'Company',
    'MO_DHL__CUSTOM_LABEL_ADRESS_ADDITION'    => 'Address addition',
    'MO_DHL__CUSTOM_LABEL_STREETNAME'         => 'Street',
    'MO_DHL__CUSTOM_LABEL_STREETNUMBER'       => 'Street number',
    'MO_DHL__CUSTOM_LABEL_ZIP'                => 'Zip code',
    'MO_DHL__CUSTOM_LABEL_CITY'               => 'City',
    'MO_DHL__CUSTOM_LABEL_COUNTRY'            => 'Country',
    'MO_DHL__CUSTOM_LABEL_PACKSTATION_NUMBER' => 'Packstation number',
    'MO_DHL__CUSTOM_LABEL_POSTFILIAL_NUMBER'  => 'Filial number',
    'MO_DHL__CUSTOM_LABEL_POST_NUMBER'        => 'Post number',
    'MO_DHL__CUSTOM_LABEL_SHIPPER'            => 'Shipper',
    'MO_DHL__CUSTOM_LABEL_SERVICES'           => 'Shipment Services',

    'MO_DHL__COUNTRY_DHL'              => 'DHL',
    'MO_DHL__RETOURE_RECEIVER_ID'      => 'Retoure receiver (receiverID)',
    'HELP_MO_DHL__RETOURE_RECEIVER_ID' => 'You can find the retoure receivers (receiverID) in the DHL Business Customer Portal (https://www.dhl-geschaeftskundenportal.de) at "Retoure" > "Settings" > "Receiver ID".',
    'MO_DHL__CREATE_RETOURE'           => 'Create Retoure label',
    'MO_DHL__NO_RECEIVER_ID'           => 'The Retoure Receiver Id is not set for the given country %s. Please add it under Master Settings > Countries > DHL.',

    'MO_DHL__ARTICLES_DHL'              => 'DHL',
    'MO_DHL__CATEGORIES_DHL'            => 'DHL',
    'MO_DHL__VISUAL_AGE_CHECK'          => 'Age check',
    'MO_DHL__VISUAL_AGE_CHECK16'        => 'Age check: 16 years',
    'MO_DHL__VISUAL_AGE_CHECK18'        => 'Age check: 18 years',
    'MO_DHL__BULKY_GOOD'                => 'Bulky good',
    'MO_DHL__IDENT_CHECK'               => 'Ident-Check',
    'MO_DHL__FOR_IDENT_CHECK'           => 'for Ident-Check',
    'MO_DHL__CASH_ON_DELIVERY'          => 'Cash on delivery',
    'MO_DHL__ADDITIONAL_INSURANCE'      => 'Additional Insurance',
    'HELP_MO_DHL__ADDITIONAL_INSURANCE' => 'DHL normally insures the delivery inside Germany up to 500 EUR concerning losing or damaging. For deliveries of more expensive products DHL offers an additional insurance up to 2.500 EUR (+6,00 EUR surcharge) or 25.000 EUR  (+18,00 EUR surcharge). You can find more informationens <a href="https://www.dhl.de/content/dam/images/pdf/GK/Services/dhl-transportversicherung-infoblatt-en-052020.pdf" target="_blank" rel="noopener noreferrer">here</a>',
    'MO_DHL__ECONOMY'                   => 'Service Delivery Type: Economy',
    'HELP_MO_DHL__ECONOMY'              => 'Standard delivery.',
    'MO_DHL__CDP'                       => 'Service Delivery Type: CDP (Closest Droppoint)',
    'HELP_MO_DHL__CDP'                  => 'Delivery to the droppoint closest to the address of the recipient of the shipment.',
    'MO_DHL__PREMIUM'                   => 'Service Delivery Type: Premium',
    'HELP_MO_DHL__PREMIUM'              => 'A package with Service Premium is preferred and always transported by the fastest route. Your package always takes the next possible flight or truck to the destination and gets priority status in the destination country. So it reaches its destination much faster.',
    'MO_DHL__PDDP'                      => 'PDDP (Postal Delivery Duty Paid)',
    'HELP_MO_DHL__PDDP'                 => 'Deutsche Post and sender handle import duties instead of consignee',
    'MO_DHL__ZOLLTARIF'                 => 'HS tariff number',
    'HELP_MO_DHL__ZOLLTARIF'            => 'Optional parameter used for the creation of export document for DHL Paket International. Internationally standardized system of names and numbers to classify traded products.',

    'MO_DHL__ENDORSEMENT'                              => 'Endorsement',
    'HELP_MO_DHL__ENDORSEMENT'                         => 'This service defines the handling of parcels that cannot be delivered. This service is only relevant for DHL Paket International.',
    'MO_DHL__ENDORSEMENT_IMMEDIATE'                    => 'Sending back to sender',
    'MO_DHL__ENDORSEMENT_ABANDONMENT'                  => 'Abandonment of parcel at the hands of sender (free of charge)',
    'MO_DHL__LABEL_CREATED_WITH_WEAK_VALIDATION_ERROR' => 'While processing the request a weak error occured. The request was still processed successfully.',

    'MO_DHL__WALLAT_BALANCE_CHECK' => 'Your credentials for the Portokasse are correct. Your balance is %.2f €',

    'MO_DHL'                                          => 'DHL',
    'MO_DHL__INTERNETMARKE'                           => 'Internetmarke',
    'MO_DHL__INTERNETMARKE_PRODUCT'                   => 'Products',
    'MO_DHL__INTERNETMARKE_REFUND'                    => 'Refunds',
    'MO_DHL__RETOURE_TRANSACTION_ID'                  => 'Transaction Id',
    'MO_DHL__RETOURE_TRANSACTION_STATUS'              => 'Status',
    'MO_DHL__RETOURE_REQUESTED'                       => 'Refund requested on',
    'MO_DHL__RETOURE_REFUNDED'                        => 'Already refunded',
    'MO_DHL__INTERNETMARKE_REFUND_REQUESTED_MESSAGE'  => 'The refund was requested with the transaction ID %s. The status of the refund can we checked at DHL > Internetmarke > Refunds.',
    'MO_DHL__INTERNETMARKE_REFUND_STATUS_FINISHED'    => 'finished',
    'MO_DHL__INTERNETMARKE_REFUND_STATUS_REQUESTED'   => 'requested',
    'MO_DHL__INTERNETMARKE_REFUND_STATUS_IN_PROGRESS' => 'in progress',
    'MO_DHL__UPDATE_STATUS'                           => 'Update Status',
    'MO_DHL__INTERNETMARKE_DETAILS'                   => 'Details',
    'MO_DHL__PRODWSID'                                => 'ProdWS-Id',
    'MO_DHL__NAME'                                    => 'Name',
    'MO_DHL__DESCRIPTION'                             => 'Description',
    'MO_DHL__PRICE'                                   => 'Price',
    'MO_DHL__UPDATE_PRODUCTLIST'                      => 'Update productlist',
    'MO_DHL__WEIGHT'                                  => 'Weight limits',
    'MO_DHL__DIMENSION'                               => 'Size limits',
    'MO_DHL__BASE_SERVICE'                            => 'Base product',
    'MO_DHL__ADDITIONAL_SERVICES'                     => 'Additional products',

    'MO_DHL__ERROR_PRINT_FORMAT'       => 'An Error %s occured in line %d in file %s',
    'MO_DHL__ERROR_WHILE_EXECUTION'    => 'An error occured while processing your action:',
    'MO_DHL__ERROR_PROCESS_IS_MISSING' => 'The delivery set is missing a reference to a DHL product using the process number.',
    'MO_DHL__ERROR_ WEIGHT_WITH_COMMA' => 'A comma was used as a seperator for the weight settings instead of a dot. This was fixed automatically.',
];
