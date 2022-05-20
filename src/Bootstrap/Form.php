<?php

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright Mediaopt GmbH
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
    const MERCHANT_ID_FIELD  = 'MoptWordline.config.merchantId';
    const API_KEY_FIELD  = 'MoptWordline.config.apiKey';
    const API_SECRET_FIELD = 'MoptWordline.config.apiSecret';
    const LOG_LEVEL = 'MoptWordline.config.logLevel';
}
