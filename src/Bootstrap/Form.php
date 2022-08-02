<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Bootstrap
 */

namespace MoptWordline\Bootstrap;

/**
 * This class will represent the plugin config options
 *
 * @author Mediaopt GmbH
 * @package MoptWordline\Bootstrap
 */
class Form
{
    /** Field names for the plugin config */
    const IS_LIVE_MODE_FIELD = 'MoptWordline.config.isLiveMode';
    const LIVE_ENDPOINT_FIELD = 'MoptWordline.config.liveEndpoint';
    const SANDBOX_ENDPOINT_FIELD = 'MoptWordline.config.sandboxEndpoint';
    const RETURN_URL_FIELD = 'MoptWordline.config.returnUrl';
    const MERCHANT_ID_FIELD  = 'MoptWordline.config.merchantId';
    const API_KEY_FIELD  = 'MoptWordline.config.apiKey';
    const API_SECRET_FIELD = 'MoptWordline.config.apiSecret';
    const LOG_LEVEL = 'MoptWordline.config.logLevel';

    /** @var string Fieldset name for the plugin custom field */
    const CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_FIELDSET = 'payment_transaction_fieldset';

    /** @var string Field name for the plugin custom field */
    const CUSTOM_FIELD_WORDLINE_PAYMENT_HOSTED_CHECKOUT_ID = 'payment_transaction_id';
    const CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_STATUS = 'payment_transaction_status';
    const CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_READABLE_STATUS = 'payment_transaction_readable_status';

    /** @var string Field name for the plugin session key */
    const SESSION_OPERATIONS_LOCK = 'order_locked';
}
