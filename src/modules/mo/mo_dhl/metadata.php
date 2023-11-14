<?php

namespace Mediaopt\DHL;

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';
/**
 * Module information
 */
$aModule = [
    'id'          => 'mo_dhl',
    'title'       => 'Post & Paket Versand',
    'description' => [
        'de' => '<p>Erweitern Sie Ihren Shop um den Post & Paket Versand.</p>' . '<p><a href="https://projects.mediaopt.de/projects/mopt-postp-ua/wiki" target="_blank">Handbuch</a></p>',
        'en' => '<p>Enable features providing Post & Paket Delivery to your OXID shop.</p>' . '<p><a href="https://projects.mediaopt.de/projects/mopt-postp-ua/wiki" target="_blank">Handbook</a></p>',
    ],
    'thumbnail'   => 'logo.png',
    'version'     => '1.7.4',
    'author'      => '<a href="http://www.mediaopt.de" target="_blank">mediaopt.</a>',
    'url'         => 'http://www.mediaopt.de',
    'email'       => 'shopsoftware@deutschepost.de',
    'extend'      => [
        \OxidEsales\Eshop\Core\ViewConfig::class                                  => Core\ViewConfig::class,
        \OxidEsales\Eshop\Core\InputValidator::class                              => Core\InputValidator::class,
        \OxidEsales\Eshop\Core\Email::class                                       => Core\Email::class,
        \OxidEsales\Eshop\Application\Controller\Admin\ModuleConfiguration::class => Application\Controller\Admin\ModuleConfiguration::class,
        \OxidEsales\Eshop\Application\Controller\Admin\OrderOverview::class       => Application\Controller\Admin\OrderOverview::class,
        \OxidEsales\Eshop\Application\Controller\UserController::class            => Application\Controller\UserController::class,
        \OxidEsales\Eshop\Application\Controller\OrderController::class           => Application\Controller\OrderController::class,
        \OxidEsales\Eshop\Application\Controller\BasketController::class          => Application\Controller\BasketController::class,
        \OxidEsales\Eshop\Application\Controller\PaymentController::class         => Application\Controller\PaymentController::class,
        \OxidEsales\Eshop\Application\Controller\AccountOrderController::class    => Application\Controller\AccountOrderController::class,
        \OxidEsales\Eshop\Application\Component\UserComponent::class              => Application\Component\UserComponent::class,
        \OxidEsales\Eshop\Application\Model\Basket::class                         => Application\Model\Basket::class,
        \OxidEsales\Eshop\Application\Model\Order::class                          => Application\Model\Order::class,
        \OxidEsales\Eshop\Application\Model\User::class                           => Application\Model\User::class,
        \OxidEsales\Eshop\Application\Model\Delivery::class                       => Application\Model\Delivery::class,
        \OxidEsales\Eshop\Application\Model\DeliverySet::class                    => Application\Model\DeliverySet::class,
        \OxidEsales\Eshop\Application\Model\PaymentList::class                    => Application\Model\PaymentList::class,
        \OxidEsales\Eshop\Application\Model\DeliveryList::class                   => Application\Model\DeliveryList::class,
        \OxidEsales\Eshop\Application\Model\DeliverySetList::class                => Application\Model\DeliverySetList::class,
        \OxidEsales\Eshop\Application\Model\Article::class                        => Application\Model\Article::class,
        \OxidEsales\Eshop\Application\Model\Category::class                       => Application\Model\Category::class,
    ],
    'controllers' => [
        'MoDHLFinder'               => Controller\FinderController::class,
        'MoDHLCategoriesDHL'        => Controller\Admin\CategoryDHLController::class,
        'MoDHLArticlesDHL'          => Controller\Admin\ArticlesDHLController::class,
        'MoDHLCountryDHL'           => Controller\Admin\CountryDHLController::class,
        'MoDHLDeliverySetDHL'       => Controller\Admin\DeliverySetDHLController::class,
        'MoDHLDeliveryDHL'          => Controller\Admin\DeliveryDHLController::class,
        'MoDHLPaymentsDHL'          => Controller\Admin\PaymentsDHLController::class,
        'MoDHLOrderBatch'           => Controller\Admin\OrderBatchController::class,
        'MoDHLOrderDHL'             => Controller\Admin\OrderDHLController::class,
        'MoDHLYellowBox'            => Controller\YellowBoxController::class,
        'MoDHLGuest'                => Controller\GuestController::class,
        'MoDHLInternetmarkeProducts'        => Controller\Admin\InternetmarkeProductsController::class,
        'MoDHLInternetmarkeProductsList'    => Controller\Admin\InternetmarkeProductsListController::class,
        'MoDHLInternetmarkeProductsDetails' => Controller\Admin\InternetmarkeProductsDetailsController::class,
        'MoDHLInternetmarkeRefunds'        => Controller\Admin\InternetmarkeRefundsController::class,
        'MoDHLInternetmarkeRefundsList'    => Controller\Admin\InternetmarkeRefundsListController::class,
        'MoDHLInternetmarkeRefundsDetails' => Controller\Admin\InternetmarkeRefundsDetailsController::class,
    ],
    'events'      => [
        'onActivate'   => Install::class . '::onActivate',
        'onDeactivate' => Install::class . '::onDeactivate',
    ],
    'blocks'      => [
        [
            'template' => 'order_overview.tpl',
            'block'    => 'admin_order_overview_deliveryaddress',
            'file'     => 'views/admin/blocks/admin_order_overview_deliveryaddress.tpl',
        ],
        [
            'template' => 'form/user.tpl',
            'block'    => 'user',
            'file'     => 'views/blocks/user.tpl',
        ],
        [
            'template' => 'page/checkout/order.tpl',
            'block'    => 'shippingAndPayment',
            'file'     => 'views/blocks/checkout_order_shipping_and_payment.tpl',
        ],
        [
            'template' => 'page/checkout/order.tpl',
            'block'    => 'checkout_order_address',
            'file'     => 'views/blocks/checkout_order_address.tpl',
        ],
        [
            'template' => 'form/user_checkout_change.tpl',
            'block'    => 'user_checkout_change',
            'file'     => 'views/blocks/user_checkout_change.tpl',
        ],
        [
            'template' => 'form/user_checkout_noregistration.tpl',
            'block'    => 'user_checkout_noregistration',
            'file'     => 'views/blocks/user_checkout_noregistration.tpl',
        ],
        [
            'template' => 'form/user_checkout_registration.tpl',
            'block'    => 'user_checkout_registration',
            'file'     => 'views/blocks/user_checkout_registration.tpl',
        ],
        [
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'act_shipping',
            'file'     => 'views/blocks/payment_act_shipping.tpl',
        ],
        [
            'template' => 'page/checkout/payment.tpl',
            'block'    => 'checkout_payment_nextstep',
            'file'     => 'views/blocks/checkout_payment_nextstep.tpl',
        ],
        [
            'template' => 'module_config.tpl',
            'block'    => 'admin_module_config_var_types',
            'file'     => 'views/admin/blocks/module_config_admin_module_config_var_types.tpl',
        ],
        [
            'template' => 'form/fieldset/user_shipping.tpl',
            'block'    => 'form_user_shipping_address_select',
            'file'     => 'views/blocks/form_user_shipping_address_select.tpl',
        ],
        [
            'template' => 'page/checkout/inc/basketcontents.tpl',
            'block'    => 'checkout_basketcontents_delcosts',
            'file'     => 'views/blocks/checkout_basketcontents_delcosts.tpl',
        ],
        [
            'template' => 'form/fieldset/user_shipping.tpl',
            'block'    => 'form_user_shipping_country',
            'file'     => 'views/blocks/form_user_shipping_country.tpl',
        ],
        [
            'template' => 'layout/base.tpl',
            'block'    => 'head_meta_robots',
            'file'     => 'views/blocks/head_meta_robots.tpl',
        ],
        [
            'template' => 'email/plain/order_owner.tpl',
            'block'    => 'email_plain_order_ownerdelcosts',
            'file'     => 'views/blocks/email_plain_order_ownerdelcosts.tpl',
        ],
        [
            'template' => 'email/plain/order_cust.tpl',
            'block'    => 'email_plain_order_cust_delcosts',
            'file'     => 'views/blocks/email_plain_order_cust_delcosts.tpl',
        ],
        [
            'template' => 'email/html/order_owner.tpl',
            'block'    => 'email_html_order_owner_delcosts',
            'file'     => 'views/blocks/email_html_order_owner_delcosts.tpl',
        ],
        [
            'template' => 'email/html/order_cust.tpl',
            'block'    => 'email_html_order_cust_delcosts',
            'file'     => 'views/blocks/email_html_order_cust_delcosts.tpl',
        ],
        [
            'template' => 'page/account/order.tpl',
            'block'    => 'account_order_history_cart_items',
            'file'     => 'views/blocks/account_order_history_cart_items.tpl',
        ],
        [
            'template' => 'mo_dhl__guest_order.tpl',
            'block'    => 'account_order_history_cart_items',
            'file'     => 'views/blocks/account_order_history_cart_items.tpl',
        ],
        [
            'template' => 'email/html/ordershipped.tpl',
            'block'    => 'email_html_ordershipped_shipmenttrackingurl',
            'file'     => 'views/tpl/email/order_retoure_html.tpl',
        ],
        [
            'template' => 'email/plain/ordershipped.tpl',
            'block'    => 'email_html_ordershipped_shipmenttrackingurl',
            'file'     => 'views/tpl/email/order_retoure_plain.tpl',
        ],
    ],
    'templates'   => [
        'mo_dhl__main.tpl'                   => 'mo/mo_dhl/views/tpl/main.tpl',
        'mo_dhl__finder.tpl'                 => 'mo/mo_dhl/views/tpl/finder.tpl',
        'mo_dhl__finder_azure.tpl'           => 'mo/mo_dhl/views/tpl/azure/finder.tpl',
        'mo_dhl__finder_flow.tpl'            => 'mo/mo_dhl/views/tpl/flow/finder.tpl',
        'mo_dhl__finder_wave.tpl'            => 'mo/mo_dhl/views/tpl/wave/finder.tpl',
        'mo_dhl__order_batch.tpl'            => 'mo/mo_dhl/views/admin/tpl/order_batch.tpl',
        'mo_dhl__wunschpaket.tpl'            => 'mo/mo_dhl/views/tpl/wunschpaket.tpl',
        'mo_dhl__wunschpaket_azure.tpl'      => 'mo/mo_dhl/views/tpl/azure/wunschpaket.tpl',
        'mo_dhl__wunschpaket_flow.tpl'       => 'mo/mo_dhl/views/tpl/flow/wunschpaket.tpl',
        'mo_dhl__wunschpaket_wave.tpl'       => 'mo/mo_dhl/views/tpl/wave/wunschpaket.tpl',
        'mo_dhl__order_dhl.tpl'              => 'mo/mo_dhl/views/admin/tpl/order_dhl.tpl',
        'mo_dhl__article_dhl.tpl'            => 'mo/mo_dhl/views/admin/tpl/article_dhl.tpl',
        'mo_dhl__category_dhl.tpl'           => 'mo/mo_dhl/views/admin/tpl/category_dhl.tpl',
        'mo_dhl__order_dhl_custom_label.tpl' => 'mo/mo_dhl/views/admin/tpl/order_dhl_custom_label.tpl',
        'mo_dhl__deliveryset_dhl.tpl'        => 'mo/mo_dhl/views/admin/tpl/deliveryset_dhl.tpl',
        'mo_dhl__delivery_dhl.tpl'           => 'mo/mo_dhl/views/admin/tpl/delivery_dhl.tpl',
        'mo_dhl__payments_dhl.tpl'           => 'mo/mo_dhl/views/admin/tpl/payments_dhl.tpl',
        'mo_dhl__country_dhl.tpl'            => 'mo/mo_dhl/views/admin/tpl/country_dhl.tpl',
        'mo_dhl__surcharge.tpl'              => 'mo/mo_dhl/views/tpl/surcharge.tpl',
        'mo_dhl__email_order_html.tpl'       => 'mo/mo_dhl/views/tpl/email/order_html.tpl',
        'mo_dhl__email_order_plain.tpl'      => 'mo/mo_dhl/views/tpl/email/order_plain.tpl',
        'mo_dhl__retoure_links.tpl'          => 'mo/mo_dhl/views/tpl/retoure_links.tpl',
        'mo_dhl__retoure_button.tpl'         => 'mo/mo_dhl/views/tpl/retoure_button.tpl',
        'mo_dhl__retoure_request.tpl'        => 'mo/mo_dhl/views/tpl/retoure_request.tpl',
        'mo_dhl__retoure.tpl'                => 'mo/mo_dhl/views/tpl/retoure.tpl',
        'mo_dhl__email_retoure_html.tpl'     => 'mo/mo_dhl/views/tpl/email/retoure_html.tpl',
        'mo_dhl__email_retoure_plain.tpl'    => 'mo/mo_dhl/views/tpl/email/retoure_plain.tpl',
        'mo_dhl__guest_order.tpl'            => 'mo/mo_dhl/views/tpl/guest_order.tpl',
        'mo_dhl__internetmarke.tpl'          => 'mo/mo_dhl/views/admin/tpl/internetmarke.tpl',
        'mo_dhl__internetmarke_list.tpl'     => 'mo/mo_dhl/views/admin/tpl/internetmarke_list.tpl',
        'mo_dhl__internetmarke_details.tpl'  => 'mo/mo_dhl/views/admin/tpl/internetmarke_details.tpl',
        'mo_dhl__internetmarke_refunds.tpl'          => 'mo/mo_dhl/views/admin/tpl/internetmarke_refunds.tpl',
        'mo_dhl__internetmarke_refunds_list.tpl'     => 'mo/mo_dhl/views/admin/tpl/internetmarke_refunds_list.tpl',
        'mo_dhl__internetmarke_refunds_details.tpl'  => 'mo/mo_dhl/views/admin/tpl/internetmarke_refunds_details.tpl',
        'mo_dhl__internetmarke_products_search.tpl' => 'mo/mo_dhl/views/admin/tpl/internetmarke_products_search.tpl',
    ],
    'settings'    => [
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__account_sandbox',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__account_rest_api',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__account_user',
            'type'  => 'str',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__account_password',
            'type'  => 'password',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__merchant_ekp',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__account_check',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__authentication_client_id',
            'type'  => 'str',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__authentication_client_secret',
            'type'  => 'str',
        ],
        [
            'group' => 'mo_dhl__account',
            'name'  => 'mo_dhl__authentication_check',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__portokasse',
            'name'  => 'mo_dhl__portokasse_user',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__portokasse',
            'name'  => 'mo_dhl__portokasse_password',
            'type'  => 'password',
        ],
        [
            'group' => 'mo_dhl__internetmarke',
            'name'  => 'mo_dhl__internetmarke_layout',
            'type'  => 'str',
            'value' => '1',
        ],
        [
            'group' => 'mo_dhl__portokasse',
            'name'  => 'mo_dhl__internetmarke_check',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__delivery',
            'name'  => 'mo_dhl__only_with_leitcode',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__delivery_weight',
            'name'  => 'mo_dhl__default_weight',
            'type'  => 'str',
        ],
        [
            'group' => 'mo_dhl__delivery_weight',
            'name'  => 'mo_dhl__calculate_weight',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'mo_dhl__delivery_weight',
            'name'  => 'mo_dhl__packing_weight_in_percent',
            'type'  => 'str',
        ],
        [
            'group' => 'mo_dhl__delivery_weight',
            'name'  => 'mo_dhl__packing_weight_absolute',
            'type'  => 'str',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_line1',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_line2',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_line3',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_street',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_street_number',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_zip',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__sender',
            'name'  => 'mo_dhl__sender_city',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group'       => 'mo_dhl__sender',
            'name'        => 'mo_dhl__sender_country',
            'type'        => 'select',
            'value'       => 'DEU',
            'constraints' => 'DEU|AUT',
        ],
        [
            'group' => 'mo_dhl__services',
            'name'  => 'mo_dhl__filialrouting_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__services',
            'name'  => 'mo_dhl__filialrouting_alternative_email',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__services',
            'name'  => 'mo_dhl__paketankuendigung_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__services',
            'name'  => 'mo_dhl__paketankuendigung_custom',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group'       => 'mo_dhl__services',
            'name'        => 'mo_dhl__notification_mode',
            'type'        => 'select',
            'value'       => 'NEVER',
            'constraints' => 'NEVER|ASK|ALWAYS',
        ],
        [
            'group' => 'mo_dhl__services',
            'name'  => 'mo_dhl__go_green_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group'       => 'mo_dhl__services',
            'name'        => 'mo_dhl__ident_check_min_age',
            'type'        => 'select',
            'value'       => '0',
            'constraints' => '0|16|18',
        ],
        [
            'group' => 'mo_dhl__services',
            'name'  => 'mo_dhl__no_neighbour_delivery_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__cod',
            'name'  => 'mo_dhl__cod_accountOwner',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__cod',
            'name'  => 'mo_dhl__cod_bankName',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__cod',
            'name'  => 'mo_dhl__cod_iban',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__retoure',
            'name'  => 'mo_dhl__retoure_reference_prefix',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group'       => 'mo_dhl__retoure',
            'name'        => 'mo_dhl__retoure_allow_frontend_creation',
            'type'        => 'select',
            'value'       => 'NEVER',
            'constraints' => 'NEVER|ONLY_DHL|ALWAYS',
        ],
        [
            'group' => 'mo_dhl__retoure',
            'name'  => 'mo_dhl__retoure_days_limit',
            'type'  => 'str',
            'value' => '30',
        ],
        [
            'group' => 'mo_dhl__retoure',
            'name'  => 'mo_dhl__retoure_admin_approve',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__beilegerretoure_active',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_use_sender',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_line1',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_line2',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_line3',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_street',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_street_number',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_zip',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__beilegerretoure',
            'name'  => 'mo_dhl__retoure_receiver_city',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group'       => 'mo_dhl__beilegerretoure',
            'name'        => 'mo_dhl__retoure_receiver_country',
            'type'        => 'select',
            'value'       => 'DEU',
            'constraints' => 'DEU|AUT',
        ],
        [
            'group' => 'mo_dhl__standortsuche',
            'name'  => 'mo_dhl__prod_standortsuche_password',
            'type'  => 'str',
        ],
        [
            'group'       => 'mo_dhl__standortsuche',
            'name'        => 'mo_dhl__standortsuche_maximumHits',
            'type'        => 'select',
            'value'       => '20',
            'constraints' => '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50',
        ],
        [
            'group' => 'mo_dhl__standortsuche',
            'name'  => 'mo_dhl__standortsuche_googleMapsApiKey',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'mo_dhl__standortsuche',
            'name'  => 'mo_dhl__standortsuche_packstation',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__standortsuche',
            'name'  => 'mo_dhl__standortsuche_postfiliale',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__standortsuche',
            'name'  => 'mo_dhl__standortsuche_paketshop',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__standortsuche',
            'name'  => 'mo_dhl__standortsuche_map_radius',
            'type'  => 'str',
            'value' => '0',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__wunschtag_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__wunschtag_surcharge',
            'type'  => 'str',
            'value' => '1.20',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__wunschtag_surcharge_text',
            'type'  => 'arr',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__wunschtag_cutoff',
            'type'  => 'str',
            'value' => '12:00',
        ],
        [
            'group'       => 'mo_dhl__wunschtag',
            'name'        => 'mo_dhl__wunschtag_preparation',
            'type'        => 'select',
            'value'       => '0',
            'constraints' => '0|1|2|3',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_help',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_mon',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_tue',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_wed',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_thu',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_fri',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschtag',
            'name'  => 'mo_dhl__handing_over_sat',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'mo_dhl__wunschort',
            'name'  => 'mo_dhl__wunschort_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__wunschnachbar',
            'name'  => 'mo_dhl__wunschnachbar_active',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group'       => 'mo_dhl__logs',
            'name'        => 'mo_dhl__logLevel',
            'type'        => 'select',
            'value'       => 'ERROR',
            'constraints' => 'ERROR|INFO|DEBUG',
        ],
        [
            'group'       => 'mo_dhl__logs',
            'name'        => 'mo_dhl__retention',
            'type'        => 'select',
            'value'       => 'ONE_MONTH',
            'constraints' => 'ONE_DAY|TWO_DAYS|THREE_DAYS|FOUR_DAYS|FIVE_DAYS|SIX_DAYS|ONE_WEEK|TWO_WEEKS|THREE_WEEKS|ONE_MONTH|TWO_MONTHS|QUARTER_YEAR|HALF_YEAR|YEAR|UNLIMITED',
        ],
        [
            'group' => 'mo_dhl__logs',
            'name'  => 'mo_dhl__logfiles',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'mo_dhl__privacy',
            'name'  => 'mo_dhl__privacy_policy',
            'type'  => 'str',
            'value' => 'oxsecurityinfo',
        ],
    ],
];
