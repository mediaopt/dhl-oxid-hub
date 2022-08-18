<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline\Bootstrap
 */

namespace MoptWorldline\Bootstrap;

/**
 * This class will represent the plugin config options
 *
 * @author Mediaopt GmbH
 * @package MoptWorldline\Bootstrap
 */
class Form
{
    /** Field names for the plugin config */
    const IS_LIVE_MODE_FIELD = 'MoptWorldline.config.isLiveMode';
    const LIVE_ENDPOINT_FIELD = 'MoptWorldline.config.liveEndpoint';
    const SANDBOX_ENDPOINT_FIELD = 'MoptWorldline.config.sandboxEndpoint';
    const RETURN_URL_FIELD = 'MoptWorldline.config.returnUrl';
    const MERCHANT_ID_FIELD  = 'MoptWorldline.config.merchantId';
    const API_KEY_FIELD  = 'MoptWorldline.config.apiKey';
    const API_SECRET_FIELD = 'MoptWorldline.config.apiSecret';
    const LOG_LEVEL = 'MoptWorldline.config.logLevel';

    /** @var string Fieldset name for the plugin custom field */
    const CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_FIELDSET = 'payment_transaction_fieldset';

    /** @var string Field name for the plugin custom field */
    const CUSTOM_FIELD_WORLDLINE_PAYMENT_HOSTED_CHECKOUT_ID = 'payment_transaction_id';
    const CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_STATUS = 'payment_transaction_status';
    const CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_READABLE_STATUS = 'payment_transaction_readable_status';

    /** @var string Field name for the plugin session key */
    const SESSION_OPERATIONS_LOCK = 'order_locked';
}
